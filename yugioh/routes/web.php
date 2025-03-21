<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YugiohController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[YugiohController::class,'index'])->name('home');

// Route để hiển thị danh sách thẻ từ 
Route::get('/cardinfo', [YugiohController::class, 'index_card'])->name('cardinfo');
Route::post('/cardinfo/increment-views/{id}', [YugiohController::class, 'incrementViewsCard'])->name('incrementViews');
Route::post('/cardinfo/increment-views-news/{id}', [YugiohController::class, 'incrementViewsNews'])->name('incrementViewsNews');
//Route hiển thị cardset
Route::get('/cardsets', [YugiohController::class, 'showAllCardSets'])->name('cardset');
Route::get('/cardsets/{setCode}', [YugiohController::class, 'showCardSetDetail'])->name('cardset.show');

//Route hiểN thị các catalog thẻ của người dùng
Route::post('/cardinfo/toggle-favorite', [UserController::class, 'toggleFavorite'])->name('toggle.favorite');
Route::get('/catalog', [UserController::class, 'showOwnedItems'])->name('catalog.index');
Route::get('/balance/add', [UserController::class, 'showBalanceForm'])->name('balance.show');
Route::post('/balance/add', [UserController::class, 'addBalance'])->name('balance.add');
Route::get('/packs', [UserController::class, 'showPacks'])->name('user.packs');
Route::post('/packs/{packId}/buy', [UserController::class, 'buyPack'])->name('user.buyPack');
Route::get('/owned-packs', [UserController::class, 'showOwnedPacks'])->name('user.owned_packs');    
Route::post('/owned-packs/{packId}', [UserController::class, 'randomGacha'])->name('randomize.cards');
Route::get('/purchase', [UserController::class, 'purchaseHistory'])->name('purchase.history');
Route::get('/auction', [UserController::class, 'auction'])->name('user.auction')->middleware('checkAuction'); 
Route::get('/auction/create', [UserController::class, 'createAuctionSession'])->name('user.Create.auction'); 
Route::post('/auction/store', [UserController::class, 'storeAuctionSession'])->name('user.store.auction');
Route::post('/auction/{id}', [UserController::class, 'bid'])->name('user.bid.auction');
Route::get('/catalog_user', [UserController::class, 'showCatalog'])->name('user.catalog');


// Route để hiển thị chi tiết tin tức
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/contact', [NewsController::class, 'contact'])->name('news.contact');
Route::get('/news/category/{category}', [NewsController::class, 'category'])->name('news.category');
Route::post('/news/{newsId}/save-comment', [NewsController::class, 'saveComment'])->name('comment.save');

//Route check quyền truy cập của người dùng
Route::middleware(['checkUserRole'])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin_index'])->name('admin');
    // news manager
    Route::get('/admin/news', [AdminController::class, 'database'])->name('database');
    Route::get('/admin/news/create', [AdminController::class, 'createForm'])->name('news.create');
    Route::post('/admin/news/create', [AdminController::class, 'create'])->name('news.store');
    Route::get('/admin/news/{id}/edit', [AdminController::class, 'editForm'])->name('news.edit');
    Route::put('/admin/news/{id}/edit', [AdminController::class, 'editnews'])->name('news.update');
    Route::post('/admin/news/{id}/delete', [AdminController::class, 'delete'])->name('news.delete');
    // user manager
    Route::get('/admin/users', [AdminController::class, 'index'])->name('users.index');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edituser'])->name('users.edit');
    Route::put('/admin/users/{id}/update', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{id}/delete', [AdminController::class, 'destroy'])->name('users.destroy');
    // card manager
    Route::get('/admin/cards', [AdminController::class, 'index_card'])->name('cards.index');
    Route::get('/admin/cards/create', [AdminController::class, 'create_card'])->name('cards.create');
    Route::post('/admin/cards/store', [AdminController::class, 'store_card'])->name('cards.store');
    Route::get('/admin/cards/{id}/edit', [AdminController::class, 'edit_card'])->name('cards.edit');
    Route::put('/admin/cards/{id}', [AdminController::class, 'update_card'])->name('cards.update');
    Route::delete('/admin/cards/{id}/delete', [AdminController::class, 'destroy_card'])->name('cards.destroy');
    //pack
    Route::get('/admin/packs', [AdminController::class, 'index_pack'])->name('packs.index');
    Route::get('/admin/packs/create', [AdminController::class, 'create_pack'])->name('packs.create');
    Route::post('/admin/packs/store', [AdminController::class, 'store_pack'])->name('packs.store');
    Route::get('/admin/packs/{id}', [AdminController::class, 'show_card'])->name('packs.show');
    Route::get('/admin/packs/{id}/edit', [AdminController::class, 'edit_pack'])->name('packs.edit');
    Route::put('/admin/packs/{id}/update', [AdminController::class, 'update_pack'])->name('packs.update');
    Route::get('/admin/packs/{id}/delete', [AdminController::class, 'destroy_pack'])->name('packs.destroy');

    //reciept
    Route::get('/admin/reciept', [AdminController::class, 'index_reciept'])->name('reciept.index');
    Route::get('/admin/reciept/{id}', [AdminController::class, 'reciept_detail'])->name('reciept.detail');

    //comment
    Route::get('/admin/comment', [AdminController::class, 'index_cmt'])->name('comments.index');
    Route::delete('/admin/comment/{id}', [AdminController::class, 'destroy_cmt'])->name('comments.destroy');
});

//Route đăng nhập,đăng ký
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes for password reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'checkEmail'])->name('password.email');
Route::match(['get', 'post'], '/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');