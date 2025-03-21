<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
class NewsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách tin tức và truyền nó đến view
        $newsList = News::with(['details', 'category']);
    
        // Kiểm tra xem có yêu cầu lọc theo category hay không
        $categoryFilter = $request->input('category');
    
        if ($categoryFilter) {
            $newsList->where('CategoryID', $categoryFilter);
        }
    
        // Sắp xếp tin tức theo thứ tự giảm dần của CategoryID
        $newsList->orderBy('CategoryID', 'desc');
    
        // Lấy kết quả cuối cùng
        $newsList = $newsList->get();
    
        return view('news.index', compact('newsList'));
    }

    public function contact()
    {
        return view('news.contact');
    }

    public function show($id)
    {
        // Lấy chi tiết tin tức dựa trên ID và truyền nó đến view
        $news = News::with('category', 'details')->findOrFail($id);
        return view('news.news_detail', compact('news'));
    }
    
    public function category($category)
    {
        // Lấy danh sách tin tức theo danh mục và truyền nó đến view
        $newsList = News::whereHas('category', function ($query) use ($category) {
            $query->where('CategoryName', $category);
        })->with(['details', 'category'])->get();

        return view('news.category', compact('newsList'));
    }


    public function saveComment(Request $request, $newsId)
    {
        // Validate dữ liệu nhập vào từ form comment
        $request->validate([
            'content' => 'required|max:255|min:2', // Đặt điều kiện phù hợp với yêu cầu của bạn
        ]);

        // Tạo một bản ghi comment mới
        $comment = new Comment();
        $comment->UserID = Auth::id(); // Lấy ID của người dùng hiện tại đăng nhập
        $comment->NewsID = $newsId; // Lấy ID của tin tức mà comment được đăng trong đó
        $comment->Content = $request->input('content');
        $comment->Created_at = now(); // Sử dụng ngày giờ hiện tại

        // Lưu bản ghi comment vào cơ sở dữ liệu
        $comment->save();

        // Chuyển hướng trở lại trang chi tiết tin tức sau khi lưu comment
        return redirect()->route('news.show', $newsId)->with('success', 'Comment đã được đăng thành công');
    }

}
