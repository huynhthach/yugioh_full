<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Views;
use App\Models\Pack;

class YugiohController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $topPacks = Pack::orderBy('Price', 'desc')->take(3)->get();
     return view('welcome',compact('topPacks'));   
    }  

    public function showAllCardSets()
    {
        // Lấy tất cả các categories từ cơ sở dữ liệu
        $categories = ItemCategory::all();

        return view('yugioh.cardset', compact('categories'));
    }     

    public function showCardSetDetail(Request $request, $category)
    {
        $itemsPerPage = 15;
        $itemsPerRow = 3;
        $query = Item::where('ItemCategory', $category);
    
        // Lấy tổng số thẻ
        $totalItems = $query->count();
    
        // Lấy số trang hiện tại từ request hoặc mặc định là trang 1
        $currentPage = $request->input('page', 1);
    
        // Tính số trang
        $totalPages = ceil($totalItems / $itemsPerPage);
    
        // Lấy dữ liệu theo trang
        $offset = ($currentPage - 1) * $itemsPerPage;
        $rows = $query->skip($offset)->take($itemsPerPage)->get();
    
        // Chuyển đổi thành collection
        $rows = collect($rows);
    
        // Chia thành từng hàng
        $items = $rows->chunk($itemsPerRow);
    
        return view('yugioh.cardset_detail', compact('items', 'totalItems', 'totalPages', 'currentPage'));
    }      

    public function index_card(Request $request)
    {
        $itemsPerPage = 15;
        $itemsPerRow = 3;
        $query = Item::query(); // Bắt đầu một query Eloquent từ model Item
    
        // Thêm điều kiện tìm kiếm theo tên thẻ
        $name = $request->input('name');
        if ($name) {
            $query->where('ItemName', 'like', '%' . $name . '%');
        }
    
        // Thêm điều kiện tìm kiếm theo loại thẻ
        $type = $request->input('type');
        if ($type) {
            $query->where('ItemCategory', $type);
        }
        
        $query->orderBy('ItemID', 'desc');
        // Lấy tổng số thẻ
        $totalItems = $query->count();
    
        // Lấy số trang hiện tại từ request hoặc mặc định là trang 1
        $currentPage = $request->input('page', 1);
    
        // Tính số trang
        $totalPages = ceil($totalItems / $itemsPerPage);
    
        // Lấy dữ liệu theo trang
        $offset = ($currentPage - 1) * $itemsPerPage;
        $rows = $query->skip($offset)->take($itemsPerPage)->get();
    
        // Chuyển đổi thành collection
        $rows = collect($rows);
    
        // Chia thành từng hàng
        $items = $rows->chunk($itemsPerRow);
    
        return view('yugioh.cardinfo', compact('items', 'totalItems', 'totalPages', 'currentPage'));
    }
    
    public function incrementViewsCard($id)
    {
        $path = '/cardinfo/increment-views/' . $id;

        // Tìm xem đã có dữ liệu cho path và item_id chưa
        $view = Views::where(function($query) use ($path) {
            $query->where('Path', $path);})->first();
        // Nếu đã tồn tại, thì cập nhật view
        if (isset($view)) {
            DB::statement('UPDATE views SET View = View + 1 WHERE Path = ?', [$path]);
        } else {
            // Nếu chưa tồn tại, tạo mới
            Views::create([
                'Path' => $path,
                'ID' => $id,
                'View' => 0, // hoặc giá trị khởi tạo khác nếu cần
            ]);
        }

        return response()->json(['success' => true]);
    }
    public function incrementViewsNews($id)
    {
        $pathnews = '/news/'.$id;

        // Tìm xem đã có dữ liệu cho path và item_id chưa
        $view = Views::where(function($query) use ($pathnews) {
            $query->where('Path', $pathnews);})->first();
        // Nếu đã tồn tại, thì cập nhật view
        if (isset($view)) {
            DB::statement('UPDATE views SET View = View + 1 WHERE Path = ?', [$pathnews]);
        } else {
            // Nếu chưa tồn tại, tạo mới
            Views::create([
                'Path' => $pathnews,
                'ID' => $id,
                'View' => 0, // hoặc giá trị khởi tạo khác nếu cần
            ]);
        }

        return response()->json(['success' => true]);
    }
}
