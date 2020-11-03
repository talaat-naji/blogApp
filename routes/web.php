<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;


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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])
->post('/like', [LikesController::class,'likePost'])->name('like');

Route::middleware(['auth:sanctum', 'verified'])
->get('/feeds', [PostsController::class,'showPosts'])
->name('feeds');

Route::middleware(['auth:sanctum', 'verified'])
->post('/feeds', [PostsController::class,'addPosts'])
->name('addPost');

Route::middleware(['auth:sanctum', 'verified'])
->post('/del', [PostsController::class,'delPosts'])
->name('delPost');