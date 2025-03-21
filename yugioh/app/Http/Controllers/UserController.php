<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite_Tags;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Receipt;
use App\Models\Pack;
use App\Models\ReceiptDetail;
use App\Models\OwnedItem;
use App\Models\GachaResult;
use App\Models\GachaResultDetail;
use App\Models\Transaction;
use Carbon\Carbon;


class UserController extends Controller
{

    public function showCatalog()
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để mua pack.');
        }
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Lấy danh sách các pack mà người dùng đang sở hữu
        $ownedPacks = OwnedItem::where('OwnerID', $user->UserID)
            ->whereNotNull('PackID')
            ->with('pack')
            ->get();

        $ownedCards = OwnedItem::where('OwnerID', $user->UserID)
        ->whereNotNull('ItemID')
        ->with('item')
        ->get();


        $ownedItems = Favorite_Tags::where('UserID', $user->UserID)->get();
        $catalogItems = $ownedItems->map(function ($ownedItem) {
            return $ownedItem->item;
        });

        return view('user.catalog_user', compact('ownedPacks', 'catalogItems','ownedCards'));
    }

    public function purchaseHistory()
    {
        $user = Auth::user();
        // Lấy thông tin lịch sử mua pack
        $receiptDetails = Receipt::where('UserIDBuy', $user->UserID)->get();
    
        return view('user.history', compact('receiptDetails'));
    }
    

    public function toggleFavorite(Request $request)
    {
        $itemId = $request->input('item_id');
        $userId = auth()->id();

        if ($userId) {
            $item = Item::find($itemId);

            // Kiểm tra xem item có thuộc sở hữu của người đăng nhập hay không
            $isOwner = $item->favorite_tags()->where('UserID', $userId)->exists();

            if (!$isOwner) {
                // Nếu chưa sở hữu, thêm vào ownerItems
                $item->favorite_tags()->create([
                    'UserID' => $userId,
                ]);
            } else {
                // Nếu đã sở hữu, xoá khỏi ownerItems
                $item->favorite_tags()->where('UserID', $userId)->delete();
            }

            return response()->json(['success' => true, 'isFavoritedByUser' => $item->isFavoritedByUser($userId)]);
        }

        return response()->json(['success' => false]);
    }

    public function showBalanceForm()
    {
        return view('user.balance');
    }

    public function addBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000', // Kiểm tra số tiền nhập vào là số và không âm
        ]);

        $user = auth()->user(); // Lấy thông tin người dùng đã đăng nhập

        $Transaction = Transaction::create([
            'UserID' => $user->UserID,
            'Amount' => $request->input('amount'),
            'Date' => now(),
        ]);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/balance/add";
        $vnp_TmnCode = "B4W5SRO6"; //Mã website tại VNPAY 
        $vnp_HashSecret = "XQXYWTTUBECMBQIVZQLYZCTVCSMVYVUM"; //Chuỗi bí mật

        $vnp_TxnRef = $Transaction->TransID; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
        $vnp_OrderInfo = 'thanh toán đơn hàng';
        $vnp_OrderType = 'payment';
        $vnp_Amount = $request->input('amount') * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            $oneTimeToken = uniqid();
            $_SESSION['oneTimeToken'] = $oneTimeToken;

            // Điều hướng người dùng đến VNPAY với token này
            header('Location: ' . $vnp_Url);
            // Cộng số dư và lưu lại
            $user->balance += $request->input('amount');
            $user->save();
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function showPacks()
    {
        $packs = Pack::orderByDesc('PackID')->get(); // Sắp xếp theo trường 'PackID' giảm dần
        return view('user.pack', compact('packs'));
    }


    public function buyPack($packId, Request $request)
    {
        $quantity = $request->input('quantity');
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để mua pack.');
        }

        // Lấy thông tin pack
        $pack = Pack::findOrFail($packId);

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Kiểm tra số dư của người dùng
        if ($user->balance < $pack->Price) {
            // Trả về phản hồi JSON cho client
            return response()->json(['success' , 'message' => 'Số dư của bạn không đủ để mua pack này.']);
        }

        // Tạo hoá đơn mới
        $receipt = new Receipt();
        $receipt->UserIDBuy = $user->UserID;
        $receipt->TotalAmount = $pack->Price * $quantity;
        $receipt->RecieptDate = Carbon::now();
        $receipt->State = 1;
        $receipt->CategoryReceiptID = 2;
        $receipt->save();

        // Lưu thông tin chi tiết hoá đơn
        $receiptDetail = new ReceiptDetail();
        $receiptDetail->RecieptID = $receipt->RecieptID; // Gán RecieptID của hoá đơn mới
        $receiptDetail->PackID = $pack->PackID; // Giả sử pack được lưu trong trường 'PackID' của bảng 'packs'
        $receiptDetail->Quantity = $quantity;
        $receiptDetail->save();

        // Trừ số tiền của pack từ số dư của người dùng
        $user->balance -= $pack->Price * $quantity;
        $user->save();

        // Kiểm tra xem người dùng đã có pack này chưa
        $ownedItem = OwnedItem::where('PackID', $pack->PackID)
            ->where('OwnerID', $user->UserID)
            ->first();

        if ($ownedItem) {
            // Nếu đã có, tăng số lượng lên
            $ownedItem->update(['Quantity' => $ownedItem->Quantity + $quantity]);
        } else {
            // Nếu chưa có, tạo mới ownedItem và đặt số lượng là 1
            OwnedItem::create([
                'OwnerID' => $user->UserID,
                'PackID' => $pack->PackID,
                'NgaySoHuu' => now(),
                'Quantity' => 1,
            ]);
        }

        // Trả về view showPacks và thông báo "Mua pack thành công" dưới dạng session flash
        return response()->json(['success' => true, 'message' => 'Bạn đã mua pack thành công.']);
    }

    public function randomGacha($packId)
    {
        // Lấy pack muốn random
        $pack = Pack::findOrFail($packId);

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();


        // Kiểm tra số lượng pack có đủ để quay không
        $ownedPack = OwnedItem::where('PackID', $pack->PackID)
            ->where('OwnerID', $user->UserID)
            ->first();

        // Nếu số lượng pack không đủ
        if (!$ownedPack || $ownedPack->Quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Số lượng pack không đủ.']);
        }
        // Tạo một kết quả gacha mới
        $gachaResult = new GachaResult();
        $gachaResult->UserID = $user->UserID;
        $gachaResult->PackID = $pack->PackID;
        $gachaResult->GachaDate = now();
        $gachaResult->save();

        // Tạo một mảng lưu trữ tỉ lệ tích luỹ của các thẻ trong pack
        $cumulativeRates = [];
        $totalRate = 0;
        foreach ($pack->packCards as $packCard) {
            $totalRate += $packCard->Rate;
            $cumulativeRates[] = $totalRate;
        }

        // Random 10 thẻ từ pack
        $selectedPackCards = [];
        for ($i = 0; $i < 10; $i++) {
            // Random một số trong khoảng từ 1 đến tổng tỉ lệ
            $randomRate = mt_rand(1, $totalRate);

            // Tìm thẻ tương ứng với tỉ lệ random
            foreach ($cumulativeRates as $index => $cumulativeRate) {
                if ($randomRate <= $cumulativeRate) {
                    $selectedPackCards[] = $pack->packCards[$index];
                    break;
                }
            }
        }
        // Ghi kết quả gacha chi tiết và cập nhật owned items
        foreach ($selectedPackCards as $selectedPackCard) {
            // Ghi kết quả gacha chi tiết
            $gachaResultDetail = new GachaResultDetail();
            $gachaResultDetail->GachaResultID = $gachaResult->GachaResultID;
            $gachaResultDetail->CardID = $selectedPackCard->CardID;
            $gachaResultDetail->save();

            // Kiểm tra xem thẻ đã có trong gacha result detail của kết quả gacha hiện tại hay không
            $existingGachaDetail = GachaResultDetail::where('GachaResultID', $gachaResult->GachaResultID)
                ->where('CardID', $selectedPackCard->CardID)
                ->exists();

            // Kiểm tra xem thẻ đã có trong owned items của người dùng hay không
            $existingOwnedItem = OwnedItem::where('OwnerID', $user->UserID)
                ->where('ItemID', $selectedPackCard->CardID)
                ->exists();

            if ($existingGachaDetail && $existingOwnedItem) {
                // Nếu thẻ đã tồn tại trong cả gacha result detail và owned items, tăng số lượng trong owned items lên 1
                OwnedItem::where('OwnerID', $user->UserID)
                    ->where('ItemID', $selectedPackCard->CardID)
                    ->increment('Quantity');
            } elseif ($existingGachaDetail && !$existingOwnedItem) {
                // Nếu thẻ đã tồn tại trong gacha result detail nhưng chưa có trong owned items, tạo mới owned item với số lượng là 1
                OwnedItem::create([
                    'OwnerID' => $user->UserID,
                    'ItemID' => $selectedPackCard->CardID,
                    'NgaySoHuu' => now(),
                    'Quantity' => 1,
                ]);
            }
        }
        // Kiểm tra xem người dùng đã có pack này chưa
        $ownedPack = OwnedItem::where('PackID', $pack->PackID)
            ->where('OwnerID', $user->UserID)
            ->first();

        if ($ownedPack) {
            // Nếu đã có, giảm số lượng đi 1
            $ownedPack->decrement('Quantity');

            // Nếu quantity = 0 thì xóa pack
            if ($ownedPack->Quantity <= 0) {
                $ownedPack->delete();
            }
        }

        $cardImages = [];

        // Lặp qua các thẻ đã chọn và lấy thông tin chi tiết từ bảng Items
        foreach ($selectedPackCards as $selectedPackCard) {
            // Truy xuất thông tin chi tiết của thẻ từ bảng Items
            $card = Item::findOrFail($selectedPackCard->CardID);

            // Lấy đường dẫn hình ảnh của thẻ và thêm vào mảng cardImages
            $cardImages[] = $card->image;
        }

        $cardImages = [];

        // Lặp qua các thẻ đã chọn và lấy thông tin chi tiết từ bảng Items
        foreach ($selectedPackCards as $selectedPackCard) {
            // Truy xuất thông tin chi tiết của thẻ từ bảng Items
            $card = Item::findOrFail($selectedPackCard->CardID);

            // Lấy đường dẫn hình ảnh của thẻ và thêm vào mảng cardImages
            $cardImages[] = $card->image;
        }

        return response()->json(['success' => true, 'message' => 'Gacha completed successfully.', 'cardImages' => $cardImages]);
    }

    public function auction()
    {
        // Lấy các phiên đấu giá có CategoryReceiptID = 1 và State = 1
        $auctions = Receipt::where('CategoryReceiptID', 1)
            ->where('State', 1)
            ->get();

        // Thêm tính toán thời gian còn lại cho mỗi phiên đấu giá
        foreach ($auctions as $auction) {
            foreach ($auction->recieptdetail as $detail) {
                if ($detail->item) {
                    $auctionEndTime = Carbon::parse($auction->recieptdate)->addSecond(10); // Thay 10 bằng 600 (30 phút)
                    $endTimeInSeconds = $auctionEndTime->timestamp;
                    $detail->auctionEndTime = $endTimeInSeconds;
                }
            }
        }

        return view('user.auction', compact('auctions'));
    }


    public function createAuctionSession(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập');
        }
        // Lấy thông tin người dùng đang đăng nhập
        $userId = Auth::id();

        // Kiểm tra xem người dùng có thẻ nào để đấu giá không
        $ownedItems = OwnedItem::where('OwnerID', $userId)->get();

        // Nếu người dùng không có thẻ nào, chuyển hướng hoặc hiển thị thông báo phù hợp
        if ($ownedItems->isEmpty()) {
            return redirect()->back()->with('error', 'Bạn không có thẻ nào để đấu giá.');
        }

        // Nếu người dùng có thẻ, hiển thị form tạo phiên đấu giá
        return view('user.function.createAuction', compact('ownedItems'));
    }

    public function storeAuctionSession(Request $request)
    {
        // Lấy thông tin người dùng đang đăng nhập
        $userId = Auth::id();

        // Thiết lập múi giờ chuẩn
        $now = Carbon::now('UTC');
        // Chuyển đổi sang múi giờ địa phương (UTC+7)
        $nowLocal = $now->copy()->addHours(7);
        // Tạo phiên đấu giá mới
        $auction = new Receipt();
        $auction->UserIDBuy = null; // Chưa có người mua
        $auction->UserIDSell = $userId; // Người bán là người đang đăng nhập
        $auction->RecieptDate = $nowLocal; // Ngày tạo phiên đấu giá
        $auction->TotalAmount = $request->amount; // Giá đề xuất
        $auction->State = 1; // Trạng thái là đang đấu giá
        $auction->CategoryReceiptID = 1; // CategoryReceiptID là 1 cho đấu giá
        $auction->save();

        // Thêm chi tiết phiên đấu giá vào bảng RecieptDetails
        $auctionDetail = new ReceiptDetail();
        $auctionDetail->RecieptID = $auction->RecieptID;
        $auctionDetail->ItemID = $request->item_id;
        $auctionDetail->PackID = null; // Nếu có PackID thì thêm vào đây
        $auctionDetail->Quantity = $request->quantity;
        $auctionDetail->save();

        // Redirect hoặc hiển thị thông báo thành công
        return redirect()->back()->with('success', 'Phiên đấu giá đã được tạo thành công.');
    }

    public function bid(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập');
        }
        // Lấy thông tin người dùng đăng nhập
        $userId = Auth::user();

        // Lấy thông tin phiên đấu giá
        $auction = Receipt::findOrFail($id);

        // Kiểm tra xem người đăng nhập có phải là người bán hay không
        if ($userId->UserID === $auction->UserIDSell) {
            return redirect()->back()->with('error', 'Bạn không thể đấu giá trên sản phẩm của chính mình.');
        }

        // Kiểm tra xem số tiền đấu giá có lớn hơn số tiền hiện tại và phù hợp với số dư người dùng không
        $currentBid = $auction->TotalAmount;
        $newBid = $request->input('bidAmount');
        $userBalance = $userId->balance;

        if ($newBid <= $currentBid || $newBid > $userBalance) {
            return redirect()->back()->with('error', 'Số tiền đấu giá không hợp lệ.');
        }

        // Cập nhật thông tin phiên đấu giá
        $auction->TotalAmount = $newBid;
        $auction->UserIDBuy = $userId->UserID;
        $auction->save();

        return redirect()->back()->with('success', 'Bạn đã đấu giá thành công.');
    }
}
