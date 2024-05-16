<?php

/*
                            LICENCE PRO PROPRIETÁRNÍ SOFTWARE
              Verze 1, Organizace: Fluffici, z.s. IČO: 19786077, Rok: 2024
                            PODMÍNKY PRO POUŽÍVÁNÍ

    a. Použití: Software lze používat pouze podle přiložené dokumentace.
    b. Omezení reprodukce: Kopírování softwaru bez povolení je zakázáno.
    c. Omezení distribuce: Distribuce je povolena jen přes autorizované kanály.
    d. Oprávněné kanály: Distribuci určuje výhradně držitel autorských práv.
    e. Nepovolené šíření: Šíření mimo povolené podmínky je zakázáno.
    f. Právní důsledky: Porušení podmínek může vést k právním krokům.
    g. Omezení úprav: Úpravy softwaru jsou zakázány bez povolení.
    h. Rozsah oprávněných úprav: Rozsah úprav určuje držitel autorských práv.
    i. Distribuce upravených verzí: Distribuce upravených verzí je povolena jen s povolením.
    j. Zachování autorských atribucí: Kopie musí obsahovat všechny autorské atribuce.
    k. Zodpovědnost za úpravy: Držitel autorských práv nenese odpovědnost za úpravy.

    Celý text licence je dostupný na adrese:
    https://autumn.fluffici.eu/attachments/xUiAJbvhZaXW3QIiLMFFbVL7g7nPC2nfX7v393UjEn/fluffici_software_license_cz.pdf
*/

namespace App\Http\Controllers;
use App\Lib\BetterStackService;
use App\Models\Post;
use App\Models\PostsComments;
use App\Models\PostsLikes;
use App\Models\User;
use Httpful\Exception\ConnectionErrorException;
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

    /**
     * @throws ConnectionErrorException
     */
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

        $page->likes = count(PostsLikes::where('post_id', $page->id)->get()) ?? 0;
        $author->roles = BetterStackService::fetchRoles($author->id, false);
        $author->roles_array = BetterStackService::fetchRoles($author->id, true);
        $author->tag = '@' . str_replace(' ', '_', strtolower($author->name));

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

    public function sendComment(Request $request): RedirectResponse
    {
        $id = intval($request->get('postId'));

        if (Auth::guest()) {
            return redirect(env('PUBLIC_URL') . '/post/' . $id);
        }

        if ($request->user()->discord_linked == 1) {
            if ($this->isDBVerified($request->user()->discord_id)) {
                $msg = $request->get('comment');

                if (strlen($msg) >= 256)
                    return redirect(env('PUBLIC_URL') . '/post/' . $id)
                        ->with('flash.error', __('common.comment.too_long'));

                if (BetterStackService::isModerated($msg)) {
                    return redirect(env('PUBLIC_URL') . '/article/' . $id)
                        ->with('flash.success', __('common.comment.moderated'));
                }

                if ($this->containsLink($msg)) {
                    return redirect(env('PUBLIC_URL') . '/article/' . $id)
                        ->with('flash.success', __('common.comment.moderated.link'));
                }

                $comment = new PostsComments();
                $comment->post_id = $id;
                $comment->author = Auth::id();
                $comment->message = $msg;
                $comment->save();

                return redirect(env('PUBLIC_URL') . '/article/' . $id)
                    ->with('flash.success', __('common.comment.sent'));
            } else {
                return redirect(env('PUBLIC_URL') . '/article/' . $id)->with('flash.error', __('common.verification.required'));
            }
        } else {
            return redirect(env('PUBLIC_URL') . '/article/' . $id)->with('flash.error', __('common.discord.required'));
        }
    }

    private function containsLink($msg): bool
    {
        $pattern = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
        return preg_match($pattern, $msg) > 0;
    }

    public function sendLike(Request $request): RedirectResponse
    {
        $id = intval($request->get('postId'));

        if (Auth::guest()) {
            return redirect(env('PUBLIC_URL') . '/post/' . $id);
        }

        if ($request->user()->discord_linked == 1) {
            if ($this->isDBVerified($request->user()->discord_id)) {
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
            } else {
                return redirect(env('PUBLIC_URL') . '/article/' . $id)->with('flash.error', __('common.verification.required'));
            }
        } else {
            return redirect(env('PUBLIC_URL') . '/article/' . $id)->with('flash.error', __('common.discord.required'));
        }
    }

    public function isDBVerified(string $snowflake): bool
    {
        $response = \Httpful\Request::get("https://frdbapi.fluffici.eu/api/users/" . $snowflake . '/is-verified')->expectsJson()->send();

        if ($response->code === 200) {
            $body = json_decode(json_encode($response->body), true);
            return boolval($body['data']['verified']);
        }

        return false;
    }
}
