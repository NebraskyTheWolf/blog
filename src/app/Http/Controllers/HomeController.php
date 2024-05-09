<?php

namespace App\Http\Controllers;
use App\Lib\BetterStackService;
use App\Models\EventAttachments;
use App\Models\Events;
use App\Models\Post;
use App\Models\PostsComments;
use App\Models\ReportedAttachments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->flush();
        Auth::logout();

        toast()
            ->success(__('common.logged.out'))
            ->pushOnNextPage();

        return redirect()->route('news');
    }

    public function article(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $pageSlug = (isset($request->slug)) ? intval($request->slug) : false;

        $page = Post::where('id', $pageSlug)->firstOrFail();
        $author = User::where('id', $page->author)->firstOrFail();

        if ($author->avatar_id == null) {
            $author->avatar = 'https://ui-avatars.com/api/?name=' .  $author->name . '&background=0D8ABC&color=fff';
        } else {
            $author->avatar = "https://autumn.fluffici.eu/avatars/" . $author->avatar_id;
        }

        $subjects = BetterStackService::fetchTags($page->body);

        $title = $page->title;
        $description = $page->description;
        $content = $page->body;

        if ($page->banner == null) {
            $page->banner = "https://via.placeholder.com/800x400";
        } else {
            $page->banner = "https://autumn.fluffici.eu/attachments/" . $page->banner;
        }

        $comments = PostsComments::where('post_id', $page->id)->get();

        foreach ($comments as $comment) {
            $user = User::where('id', intval($comment->author))->first();
            $comment->user = $user;

            if ($comment->user->avatar_id == null) {
                $comment->user->avatar = 'https://ui-avatars.com/api/?name=' . $comment->user->name . '&background=0D8ABC&color=fff';
            } else {
                $comment->user->avatar = "https://autumn.fluffici.eu/avatars/" . $comment->user->avatar_id;
            }
        }

        return view('layouts.pages', compact(
            'page',
            'subjects',
            'author',
            'title',
            'description',
            'content',
            'comments'
        ));
    }

    public function news(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $newsArticles = Post::orderBy('created_at', 'desc')->get();
        foreach ($newsArticles as $new) {
            $new->author = User::where('id', $new->author)->firstOrFail();

            if ($new->banner == null) {
                $new->banner = "https://via.placeholder.com/800x400";
            } else {
                $new->banner = "https://autumn.fluffici.eu/attachments/" . $new->banner;
            }
        }

        return \view('layouts.trello')->with('newsArticles', $newsArticles);
    }
}
