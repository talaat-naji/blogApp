<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\NotificationController;


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
Route::get('/linkstorage', function () { $targetFolder = base_path().'/storage';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage'; symlink($targetFolder, $linkFolder); });
   


Route::get('/',[PostsController::class,'publicshowPosts']);
Route::get('/not',[NotificationController::class,'get_notifications']);
Route::middleware(['auth:sanctum', 'verified'])
->group(function(){
    Route::get('/dashboard',[PostsController::class,'showPosts'])->name('dashboard');
    Route::post('/post',[PostsController::class,'showPost'])->name('post');
    Route::post('/usProfile',[PostsController::class,'showProfile']);
    Route::get('/followingPosts',[PostsController::class,'followingPosts']);
    Route::post('/followStat',[FriendController::class,'followStat']);
    Route::post('/addFriend',[FriendController::class,'index'])->name('addFriend');
    Route::post('/feeds', [PostsController::class,'showPosts'])->name('seemore');
    Route::get('/feeds', [PostsController::class,'showPosts'])->name('feeds');
    Route::post('/feeds/addPosts', [PostsController::class,'addPosts'])->name('addPost');
    Route::post('/del', [PostsController::class,'delPosts'])->name('delPost');
    Route::post('/likejs', [LikesController::class,'likePostjs']);
    Route::post('/likecount', [LikesController::class,'likeCount'])->name('likeCount');
    Route::post('/editText', [PostsController::class,'editText']);
    Route::post('/delCmnt', [CommentsController::class,'delCmnt']);
    Route::post('/cmntContent', [CommentsController::class,'cmntContent']);
    Route::post('/commentjs', [CommentsController::class,'cmntPosts']);
    Route::post('/countCommentjs', [CommentsController::class,'cmntCount']);
    Route::post('/notifications',[NotificationController::class,'get_notifications']);
});
