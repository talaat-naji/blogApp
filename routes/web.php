<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;


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
Route::get('/linkstorage', function () { $targetFolder = base_path().'/storage/app/publicc/postImage';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage'; symlink($targetFolder, $linkFolder); });
    Route::get('/linkcss', function () { $targetFolder = base_path().'/resources/css';
        $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/css'; symlink($targetFolder, $linkFolder); }); 

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])
// ->get('/dashboard', [PostsController::class,'showPosts'])
// ->name('feeds');
->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])
->post('/likejs', [LikesController::class,'likePostjs']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/like', [LikesController::class,'likePost'])->name('like');

Route::middleware(['auth:sanctum', 'verified'])
->post('/likecount', [LikesController::class,'likeCount'])->name('likeCount');

Route::middleware(['auth:sanctum', 'verified'])
->get('/feeds', [PostsController::class,'showPosts'])
->name('feeds');

Route::middleware(['auth:sanctum', 'verified'])
->post('/feeds/addPosts', [PostsController::class,'addPosts'])
->name('addPost');

Route::middleware(['auth:sanctum', 'verified'])
->post('/feeds', [PostsController::class,'showPosts'])
->name('showPost');

Route::middleware(['auth:sanctum', 'verified'])
->post('/del', [PostsController::class,'delPosts'])
->name('delPost');

Route::middleware(['auth:sanctum', 'verified'])
->post('/commentjs', [CommentsController::class,'cmntPosts']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/countCommentjs', [CommentsController::class,'cmntCount']);


Route::middleware(['auth:sanctum', 'verified'])
->post('/cmntContent', [CommentsController::class,'cmntContent']);