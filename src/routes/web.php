<?php

use App\Http\Controllers\HomeController;
use App\Models\PostsComments;
use App\Models\PostsLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use function App\Models\PostsLikes;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main page

Route::get('/', [HomeController::class, 'news'])
    ->name('news');

Route::get('/article/{slug}', [HomeController::class, 'article'])
    ->name('article');

Route::get('/logout', [HomeController::class, 'logout'])
    ->name('profile.logout');

// health check
Route::get('/health', function ($request) {
    return response()->json([
        'status' => 'ok'
    ]);
});
Route::middleware(['auth', 'throttle:30,60'])->post('/post/comment', [HomeController::class, 'sendComment'])
    ->name('comment.store');
Route::middleware(['auth', 'throttle:30,60'])->post('/post/like', [HomeController::class, 'sendLike'])
    ->name('comment.like');
