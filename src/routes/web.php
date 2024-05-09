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
Route::middleware(['auth', 'throttle:30,60'])->post('/post/comment', function (Request $request) {
    $id = intval($request->get('postId'));

    if (Auth::guest()) {
        return redirect(env('PUBLIC_URL') . '/post/' . $id);
    }

    $msg = $request->get('comment');

    if (strlen($msg) >= 1000)
        return redirect(env('PUBLIC_URL') . '/post/' . $id)
            ->with('flash.error', __('common.comment.too_long'));

    $comment = new PostsComments();
    $comment->post_id = $id;
    $comment->author = Auth::id();
    $comment->message = $msg;
    $comment->save();

    return redirect(env('PUBLIC_URL') . '/article/' . $id)
        ->with('flash.success', __('common.comment.sent'));
})->name('comment.store');
Route::middleware(['auth', 'throttle:30,60'])->post('/post/like', function (Request $request) {
    $id = intval($request->get('postId'));

    if (Auth::guest()) {
        return redirect(env('PUBLIC_URL') . '/post/' . $id);
    }

    $action = $request->get('action');

    if ($action == 'like') {
        $like = new PostsLikes();
        $like->post_id = $id;
        $like->user_id = Auth::id();
        $like->likes = 1;
        $like->save();
    } else if ($action == 'unlike') {
        $like = PostsLikes::where('post_id', $id)->where('user_id', Auth::id())->first();
        if ($like) {
            $like->delete();
        }
    }

    return redirect(env('PUBLIC_URL') . '/article/' . $id);
})->name('comment.like');
