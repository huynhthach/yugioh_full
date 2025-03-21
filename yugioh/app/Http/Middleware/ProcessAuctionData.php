<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OwnedItem;
use App\Models\Receipt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ProcessAuctionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Lấy thời gian hiện tại
        $currentDateTime = Carbon::now()->addHour(7);

        // Lấy các phiên đấu giá có CategoryReceiptID = 1 và State = 1
        $auctions = Receipt::where('CategoryReceiptID', 1)
            ->where('State', 1)
            ->get();

        foreach ($auctions as $auction) {
            // Chuyển đổi thời gian phiên đấu giá sang định dạng Carbon
            $auctionDateTime = Carbon::parse($auction->RecieptDate);

            // Kiểm tra xem thời gian hiện tại có lớn hơn hoặc bằng thời gian phiên đấu giá kết thúc không
            if ($currentDateTime->greaterThanOrEqualTo($auctionDateTime->addSeconds(10))) {
                foreach ($auction->recieptdetail as $detail) {
                    if (isset($auction->UserIDBuy)) {
                        $this->decreaseQuantityForSeller($auction->UserIDSell, $detail);
                        $this->increaseQuantityForBuyer($auction->UserIDBuy, $detail);
                        $this->updateBalanceForBuyer($auction->UserIDBuy);
                        $this->updateBalanceForSeller($auction->UserIDSell);
                    }
                }
                // Cập nhật trạng thái của phiên đấu giá khi thời gian đã hết
                $auction->State = 0;
                $auction->save();
                $auction->refresh();
            }
        }

        return $next($request);
    }

    protected function increaseQuantityForBuyer($userId, $detail)
    {
        // Kiểm tra xem có người mua nào không
        // Tìm ownedItemBuy dựa trên OwnerID và ItemID
        $ownedItemBuy = OwnedItem::where('OwnerID', $userId)
            ->where('ItemID', $detail->ItemID)
            ->first();


        // Kiểm tra xem ownedItemBuy có tồn tại không
        if ($ownedItemBuy) {
            // Tăng số lượng của ownedItemBuy
            $ownedItemBuy->Quantity += $detail->Quantity;
            $ownedItemBuy->save();
        } else {
            // Tạo mới ownedItem nếu không tồn tại
            OwnedItem::create([
                'OwnerID' => $userId,
                'ItemID' => $detail->ItemID,
                'NgaySoHuu' => Carbon::now(),
                'Quantity' => $detail->Quantity,
            ]);
        }
    }


    protected function decreaseQuantityForSeller($userId, $detail)
    {
        // Kiểm tra xem có người bán nào không
        // Tìm ownedItemSell dựa trên OwnerID và ItemID
        $ownedItemSell = OwnedItem::where('OwnerID', $userId)
            ->where('ItemID', $detail->ItemID)
            ->first();
        // Kiểm tra giá trị của $userId và $detail->ItemID


        // Kiểm tra xem ownedItemSell có tồn tại không
        if ($ownedItemSell) {
            // Giảm số lượng của ownedItemSell
            $ownedItemSell->Quantity -= $detail->Quantity;
            // Xóa ownedItemSell nếu số lượng bằng 0
            if ($ownedItemSell->Quantity == 0) {
                $ownedItemSell->delete();
            } else {
                $ownedItemSell->save();
            }
        }
    }

    protected function updateBalanceForSeller($userId)
    {
        // Tìm người bán dựa trên UserID
        $seller = User::find($userId);
        $sell = Receipt::where('UserIDBuy',$userId)->first();

        if ($seller && $sell) {
            // Lấy giá trị TotalAmount từ đối tượng thích hợp (phụ thuộc vào cấu trúc dữ liệu của ứng dụng)
            $totalAmount = $sell->TotalAmount; // Sử dụng cú pháp này nếu TotalAmount là một thuộc tính của User

            // Cập nhật số dư của người bán
            $seller->balance += $totalAmount;

            // Lưu thay đổi
            $seller->save();
        }
    }



    protected function updateBalanceForBuyer($userId)
    {
        // Tìm người bán dựa trên UserID
        $buyer = User::find($userId);
        $buy = Receipt::where('UserIDSell',$userId)->first();

        if ($buyer && $buy) {
            // Lấy giá trị TotalAmount từ đối tượng thích hợp (phụ thuộc vào cấu trúc dữ liệu của ứng dụng)
            $totalAmount = $buy->TotalAmount; // Sử dụng cú pháp này nếu TotalAmount là một thuộc tính của User

            // Cập nhật số dư của người bán
            $buyer->balance += $totalAmount;

            // Lưu thay đổi
            $buyer->save();
        }
    }
}
