<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsDetail;
use App\Models\User; // Fix the namespace
use App\Models\Item;
use App\Models\Views;
use App\Models\Pack;
use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function admin_index()
    {
        // Lấy 3 views có số lần xem cao nhất của 'card'
        $cardViews = Views::where('Path', 'like', '/cardinfo/increment-views/%')->orderBy('View', 'desc')->take(3)->get();

        // Lấy 3 views có số lần xem cao nhất của 'news'
        $newsViews = Views::where('Path', 'like', '/news/%')->orderBy('View', 'desc')->take(3)->get();
        
        // Lấy ID của các views tương ứng
        $cardViewIds = $cardViews->pluck('ID');
        $newsViewIds = $newsViews->pluck('ID');

        // Lấy thông tin từ bảng Items và News dựa trên danh sách ID
        $cardItems = Item::whereIn('ItemID', $cardViewIds)->get();
        $newsItems = News::whereIn('NewsID', $newsViewIds)->get();

        // Xử lý dữ liệu để truyền cho view
        $labelsCard = $cardItems->pluck('ItemName');
        $viewsCard = $cardItems->map(function ($item) use ($cardViews) {
            return $cardViews->where('ID', $item->ItemID)->first()->View;
        });

        $labelsNews = $newsItems->pluck('Title');
        $viewsNews = $newsItems->map(function ($item) use ($newsViews) {
            return $newsViews->where('ID', $item->NewsID)->first()->View;
        });

        return view('admin.admin', compact('labelsCard', 'viewsCard', 'labelsNews', 'viewsNews'));
    }
    
    public function database(Request $request)
    {
        $perPage = 7; // Số lượng dòng trên mỗi trang
        $currentPage = $request->query('page', 1); // Trang hiện tại, mặc định là trang 1
        $searchName = $request->input('search_name'); // Tên cần tìm kiếm
        
        // Xây dựng query để lấy dữ liệu
        $query = DB::table('news')
                    ->select('CategoryName', 'Title', 'PublishedDate', 'NewsID')
                    ->join('newscategories', 'news.CategoryID', '=', 'newscategories.CategoryID');
    
        // Nếu có tên cần tìm kiếm, thêm điều kiện lọc vào query
        if ($searchName) {
            $query->where('Title', 'like', '%' . $searchName . '%');
        }
        
        // Đếm tổng số dòng trong bảng dữ liệu
        $totalRows = $query->count();
    
        // Tính toán số lượng trang
        $totalPages = ceil($totalRows / $perPage);
    
        // Tính toán vị trí bắt đầu của dữ liệu trong truy vấn
        $offset = ($currentPage - 1) * $perPage;
    
        // Lấy dữ liệu cho trang hiện tại
        $db = $query->offset($offset)
                    ->limit($perPage)
                    ->get();
    
        // Truyền dữ liệu và thông tin phân trang vào view
        return view('admin.admin_manage.news_manage', [
            'db' => $db,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ]);
    }    
    
    public function editForm($id)
    {
        $news = News::with('category', 'details')->findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.function.edit', compact('news', 'categories'));
    }

    public function editnews(Request $request, $id)
    {
        // Function to check if the file has a valid image MIME type
        $isValidImage = function ($file) {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

            return in_array($file->getClientMimeType(), $allowedMimeTypes);
        };

        // Check if the uploaded news image has a duplicate name and is a valid image
        if ($request->hasFile('news_image')) {
            $image = $request->file('news_image');
            $imageName = $image->getClientOriginalName();

            if (!$isValidImage($image)) {
                return redirect()->back()->with('error', 'Chỉ chấp nhận file ảnh (JPEG, PNG, GIF). Vui lòng chọn một file khác.');
            }

            $duplicateImagesNews = DB::table('News')
                ->where('image', $imageName)
                ->where('NewsID', '!=', $id)
                ->count();

            if ($duplicateImagesNews > 0) {
                return redirect()->back()->with('error', 'Tên ảnh đã tồn tại trong hệ thống. Vui lòng chọn một ảnh khác.');
            }
        }

        // Check if the uploaded news detail image has a duplicate name and is a valid image
        if ($request->hasFile('news_detail_image')) {
            $imageDetail = $request->file('news_detail_image');
            $imageDetailName = $imageDetail->getClientOriginalName();

            if (!$isValidImage($imageDetail)) {
                return redirect()->back()->with('error', 'Chỉ chấp nhận file ảnh (JPEG, PNG, GIF). Vui lòng chọn một file khác.');
            }

            $duplicateImagesNewsDetail = DB::table('NewsDetails')
                ->where('ImagePath', $imageDetailName)
                ->where('NewsID', $id)
                ->count();

            if ($duplicateImagesNewsDetail > 0) {
                return redirect()->back()->with('error', 'Tên ảnh đã tồn tại trong hệ thống. Vui lòng chọn một ảnh khác.');
            }
        }
    
        // Update news
        DB::table('News')
            ->where('NewsID', $id)
            ->update([
                'Title' => $request->input('title'),
                'CategoryID' => $request->input('category_id'),
                'PublishedDate' => now(),
            ]);
    
        // Update news detail
        DB::table('NewsDetails')
            ->join('News', 'News.NewsID', '=', 'NewsDetails.NewsID')
            ->where('NewsDetails.NewsID', $id)
            ->update([
                'Content' => $request->input('content'),
            ]);
    
        // Process and save the image for News
        if ($request->hasFile('news_image')) {
            $image = $request->file('news_image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('img/img_news/'), $imageName);
            DB::table('News')
                ->where('NewsID', $id)
                ->update(['image' => $imageName]);
        }
    
        // Process and save the image for NewsDetail
        if ($request->hasFile('news_detail_image')) {
            $imageDetail = $request->file('news_detail_image');
            $imageDetailName = $imageDetail->getClientOriginalName();
            $imageDetail->move(public_path('img/img_news_detail/'), $imageDetailName);
            DB::table('NewsDetails')
                ->where('NewsDetails.NewsID', $id)
                ->update(['ImagePath' => $imageDetailName]);
        }
    
        return redirect()->route('database');
    }        

    public function createForm()
    {
        $categories = NewsCategory::all();
        return view('admin.function.create', compact('categories'));
    }

    public function create(Request $request)
    {
        // Validation rules for file uploads
        $validationRules = [
            'news_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file types and size as needed
            'news_detail_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        // Validate the request data
        $validator = Validator::make($request->all(), $validationRules);
    
        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Create new news
        $news = new News;
        $newsDetail = new NewsDetail;
        $news->Title = $request->input('title');
    
        // Upload image for News
        if ($request->hasFile('news_image')) {
            $image = $request->file('news_image');
            $imageName = $image->getClientOriginalName(); // Use the original name
            $image->move(public_path('img/img_news/'), $imageName);
            $news->image = $imageName;
        }
    
        // Upload image for NewsDetail
        if ($request->hasFile('news_detail_image')) {
            $imageDetail = $request->file('news_detail_image');
            $imageDetailName = $imageDetail->getClientOriginalName(); // Use the original name
            $imageDetail->move(public_path('img/img_news_detail/'), $imageDetailName);
            $newsDetail->ImagePath = $imageDetailName;
        }
    
        $news->CategoryID = $request->input('category_id');
        $news->PublishedDate  = Carbon::now();
        $news->save();
    
        // Create new news detail
        $newsDetail->Content = $request->input('content');
        $newsDetail->NewsID = $news->NewsID;
        $newsDetail->save();
    
        return redirect()->route('database');
    }
    
        
    public function delete($id)
    {
        // Kiểm tra xem news có tồn tại không
        $news = News::find($id);

        if (!$news) {
            return redirect()->route('database')->with('error', 'News not found');
        }

        // Xóa news detail trước
        $news->details()->delete();

        // Xóa news
        $news->delete();

        return redirect()->route('database')->with('success', 'News deleted successfully');
    }

    public function index(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $currentUser = Auth::user();
    
        // Lấy từ khóa tìm kiếm từ request
        $keyword = $request->input('keyword');
    
        // Lấy toàn bộ người dùng trừ người đang đăng nhập
        $users = User::where('UserID', '!=', $currentUser->UserID)
                     ->where('Username', 'like', '%' . $keyword . '%')
                     ->get();
    
        return view('admin.admin_manage.users', compact('users'));
    }
    


    public function edituser($id)
    {
        $user = User::find($id);
        return view('admin.function.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Username' => 'required',
            'Email' => 'required|email',
        ]);

        $user = User::find($id);
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }


    // card manage
    public function index_card(Request $request)
    {
        $itemsPerPage = 7;
        $currentPage = $request->query('page', 1); // Trang hiện tại, mặc định là trang 1
        $categoryFilter = $request->input('category'); // Lọc theo loại thẻ
    
        // Xây dựng truy vấn dựa trên loại thẻ
        $query = Item::query();
        if ($categoryFilter) {
            $query->where('ItemCategory', $categoryFilter);
        }
    
        // Đếm tổng số dòng trong bảng dữ liệu
        $totalRows = $query->count();
    
        // Tính toán số lượng trang
        $totalPages = ceil($totalRows / $itemsPerPage);
    
        // Tính toán vị trí bắt đầu của dữ liệu trong truy vấn
        $offset = ($currentPage - 1) * $itemsPerPage;
        $items = $query->offset($offset)->limit($itemsPerPage)->get();
    
        // Lấy danh sách các loại thẻ để hiển thị trong dropdown filter
        $categories = Item::select('ItemCategory')->distinct()->pluck('ItemCategory');
    
        return view('admin.admin_manage.item_manage', [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories, // Truyền danh sách loại thẻ vào view
            'categoryFilter' => $categoryFilter // Truyền giá trị loại thẻ đã lọc vào view
        ]);
    }
    

    public function create_card()
    {
        return view('admin.function.create_card');
    }

    public function store_card(Request $request)
    {
        // Create new news
        $item = new Item;
        $item->ItemName = $request->input('ItemName');
        $item->ItemCategory = $request->input('ItemCategory');
        $item->Description  = $request->input('Description');
        // Upload image for News
        if ($request->hasFile('item_image')) {
            $image = $request->file('item_image');
            $imageName = $image->getClientOriginalName(); // Use the original name
            $image->move(public_path('img/item_img/'), $imageName);
            $item->image = $imageName;
        }

        $item->save();

        return redirect()->route('cards.index');
    }

    public function edit_card($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.function.edit_card', compact('item'));
    }

    public function update_card(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $item->ItemName = $request->input('ItemName');
        $item->ItemCategory = $request->input('ItemCategory');
        $item->Description = $request->input('Description');

        if ($request->hasFile('item_image')) {
            // Delete existing image
            if ($item->image) {
                unlink(public_path('img/item_img/') . $item->image);
            }

            // Upload new image
            $image = $request->file('item_image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('img/item_img/'), $imageName);
            $item->image = $imageName;
        }

        $item->save();

        return redirect()->route('cards.index');
    }

    public function destroy_card($id)
    {
        $item = Item::findOrFail($id);

        // Delete associated image
        if ($item->image) {
            unlink(public_path('img/item_img/') . $item->image);
        }
        $item->delete();

        return redirect()->route('cards.index')->with('success', 'Item deleted successfully.');
    }

    //PACK manage

    public function index_pack()
    {
        // Lấy danh sách các pack từ model Pack
        $packs = Pack::all();
        
        // Trả về view 'packs.index' với biến packs chứa danh sách các pack
        return view('admin.admin_manage.packs_manage', compact('packs'));
    }

    public function create_pack()
    {
        $items = Item::all();
        return view('admin.function.create_packs', compact('items'));
    }

    public function store_pack(Request $request)
    {
        // Validation rules
        $request->validate([
            'pack_name' => 'required|string|max:255',
            'selected_items' => 'required|array|min:20', // Chắc chắn ít nhất một thẻ được chọn
            'selected_items.*' => 'exists:items,ItemID', // Kiểm tra các giá trị trong mảng có tồn tại trong bảng items không
            'pack_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra hình ảnh và các định dạng hình ảnh cho phép
            'price' => 'required|numeric|min:0', // Kiểm tra giá và đảm bảo nó không âm
        ]);

        // Lấy các ID của các thẻ được chọn từ form
        $selectedItems = $request->input('selected_items');
        $rates = $request->input('rates');
        
        // Đảm bảo tổng của tỉ lệ bằng 100%
        $totalRate = array_sum($rates);
        if ($totalRate != 100) {
            return redirect()->back()->with('error', 'Tổng tỉ lệ phải bằng 100%.');
        }
    
        // Xử lý upload hình ảnh gói
        if ($request->hasFile('pack_image')) {
            $image = $request->file('pack_image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của hình ảnh
            $image->move(public_path('img/pack_image/'), $imageName); // Di chuyển hình ảnh vào thư mục công khai
        } else {
            $imageName = ''; // Gán giá trị mặc định nếu không có hình ảnh được tải lên
        }
    
        // Tạo một gói mới
        $pack = Pack::create([
            'PackName' => $request->input('pack_name'),
            'Image_pack' => $imageName, // Lưu tên hình ảnh vào cơ sở dữ liệu
            'Price' => $request->input('price'), // Lưu giá vào cơ sở dữ liệu
        ]);
    
        // Duyệt qua mỗi ID thẻ và tạo một bản ghi mới trong bảng pack_cards
        foreach ($selectedItems as $key => $itemId) {
            $pack->packCards()->create([
                'CardID' => $itemId,
                'Rate' => $rates[$key], // Gán tỉ lệ cho mỗi thẻ tương ứng
            ]);
        }
    
        return redirect()->route('packs.index')->with('success', 'Pack created successfully.');
    }    

    public function edit_pack($id)
    {
        $pack = Pack::findOrFail($id);
        $items = Item::all();
        return view('admin.function.edit_pack', compact('pack', 'items'));
    }

    public function update_pack(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'pack_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // Thêm quy tắc kiểm tra cho price
            'selected_items' => 'required|array|min:1', // Chắc chắn ít nhất một thẻ được chọn
            'selected_items.*' => 'exists:items,ItemID', // Kiểm tra các giá trị trong mảng có tồn tại trong bảng items không
            'pack_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra hình ảnh và các định dạng hình ảnh cho phép
        ]);
    
        $pack = Pack::findOrFail($id);
        
        // Xử lý upload hình ảnh gói
        if ($request->hasFile('pack_image')) {
            $image = $request->file('pack_image');
            $imageName = $image->getClientOriginalName(); // Lấy tên gốc của hình ảnh
            $image->move(public_path('img/pack_image/'), $imageName); // Di chuyển hình ảnh vào thư mục công khai
            $pack->Image_pack = $imageName; // Cập nhật tên hình ảnh
        }
    
        $pack->PackName = $request->input('pack_name');
        $pack->Price = $request->input('price'); // Cập nhật giá
    
        $pack->save();
    
        // Xoá các thẻ cũ trong pack
        $pack->packCards()->delete();
    
        // Lấy các ID của các thẻ được chọn từ form
        $selectedItems = $request->input('selected_items');
        $rates = $request->input('rates'); // Lấy các rate từ form
        
        // Duyệt qua mỗi ID thẻ và tạo một bản ghi mới trong bảng pack_cards
        foreach ($selectedItems as $key => $itemId) {
            $pack->packCards()->create([
                'CardID' => $itemId,
                'Rate' => $rates[$key], // Thêm rate cho thẻ tương ứng
            ]);
        }
    
        return redirect()->route('packs.index', $id)->with('success', 'Pack updated successfully.');
    }
    
    public function destroy_pack($id)
    {
        $pack = Pack::findOrFail($id);
        $pack->packCards()->delete(); // Xoá các thẻ trong pack
        $pack->delete(); // Xoá pack
        return redirect()->route('packs.index')->with('success', 'Pack deleted successfully.');
    }

    public function show_card($id)
    {
        $pack = Pack::findOrFail($id);
        $cards = $pack->packCards()->with('card')->get();

        return view('admin.admin_manage.show_card', compact('pack', 'cards'));
    }


    public function index_reciept(Request $request)
    {
        $itemsPerPage = 10; // Số mục trên mỗi trang
        $currentPage = $request->query('page', 1); // Trang hiện tại, mặc định là trang 1
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Xây dựng truy vấn dựa trên ngày bắt đầu và ngày kết thúc
        $query = Receipt::query();
    
        // Nếu ngày bắt đầu và ngày kết thúc được cung cấp, lọc danh sách hoá đơn theo ngày bán
        if ($startDate && $endDate) {
            $query->whereBetween('RecieptDate', [$startDate, $endDate]);
        }
    
        // Đếm tổng số dòng trong bảng dữ liệu
        $totalRows = $query->count();
    
        // Tính toán số lượng trang
        $totalPages = ceil($totalRows / $itemsPerPage);
    
        // Tính toán vị trí bắt đầu của dữ liệu trong truy vấn
        $offset = ($currentPage - 1) * $itemsPerPage;
        $reciept = $query->offset($offset)->limit($itemsPerPage)->get();
    
        return view('admin.admin_manage.reciept_manager', [
            'reciept' => $reciept,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ]);
    }
    

    public function reciept_detail($id){
        $reciept = ReceiptDetail::where('RecieptID',$id)->firstOrFail();
        return view('admin.admin_manage.reciept_detail',compact('reciept'));
    }

    public function index_cmt(Request $request)
    {
        $keyword = $request->input('keyword');
    
        // Lấy tất cả các comment từ database
        $comments = Comment::where('Content', 'like', "%$keyword%")->get();
    
        // Trả về view hiển thị tất cả các comment
        return view('admin.admin_manage.comments_manage', compact('comments'));
    }
    

    public function destroy_cmt($id)
    {
        // Tìm comment cần xóa
        $comment = Comment::where('Comment_ID',$id);

        // Xóa comment
        $comment->delete();

        // Chuyển hướng về trang hiển thị tất cả các comment
        return redirect()->route('comments.index')->with('success', 'Comment đã được xóa thành công');
    }
}
