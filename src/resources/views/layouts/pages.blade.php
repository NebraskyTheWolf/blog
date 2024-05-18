@php
    use App\Lib\BetterStackService;
    use App\Models\PostsLikes;
    use Illuminate\Support\Facades\Auth;use Illuminate\Support\Str;
@endphp

@extends('index')

@section('title', $title)
@section('description', $description)
@section('image', $page->banner)

@section('head')
    <style>
        .blog-post {
            display: flex;
            flex-direction: column; /* change from row to column because in news-article each section tends to flow top to bottom */
            font-family: Georgia, 'Times New Roman', Times, serif; /* change to a more readable font for articles */
            font-size: 18px; /* increase the base font size for better readability (adjust as needed) */
            line-height: 1.7; /* increase line height for better readability  */
            color: #fff; /* Make text color a dark gray for easy reading */
            max-width: 800px; /* optimal line length for reading is generally around 60-75 characters, adjust as needed */
            margin: 0 auto; /* Center the container horizontally */
            overflow-y: auto; /* Keep overflow setting */
        }

        .post-header {
            width: 100%;
            margin-bottom: 20px;
            background-color: #1a1c1c;
        }

        .blog-post::-webkit-scrollbar {
            width: 8px; /* scrollbar width */
        }

        .blog-post::-webkit-scrollbar-thumb {
            background-color: #334141; /* scrollbar thumb color */
            border-radius: 5px; /* scrollbar thumb border radius */
        }

        .blog-post::-webkit-scrollbar-track {
            background-color: #1F2937; /* scrollbar track color */
            border-radius: 5px; /* scrollbar track border radius */
        }

        .blog-post .post-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #fff;
        }

        .blog-post .post-meta {
            font-size: 14px;
            color: #666;
        }

        .blog-post .post-content {
            width: calc(60% - 20px); /* Adjust width as needed */
            margin-right: 20px;
            color: #fff;
            background-color: #1a1c1c;
        }

        .sidebar-article {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px; /* Adjust the width as needed */
            height: 100vh;
            background-color: #1a1c1c;
            padding: 20px;
            overflow-y: auto;
            z-index: 1000; /* Ensure it's above other content */
        }

        .sidebar-article .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-article .sidebar-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: #fff;
        }

        .bottom-sidebar .sidebar-section {
            margin-top: 20px; /* Adjust margin as needed */
        }

        .bottom-sidebar .sidebar-title {
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 10px;
            color: #fff; /* Adjust text color as needed */
        }

        .bottom-sidebar .sidebar-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .blog-post .author-info {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .blog-post .author-avatar {
            width: 50px; /* Modified width */
            height: 50px; /* Modified height */
            border-radius: 50%;
            margin-right: 10px;
        }

        .blog-post .author-meta {
            flex: 1;
        }

        .blog-post .author-name {
            font-weight: bold;
            margin-bottom: 5px;
            color: #fff;
        }

        .blog-post .author-role {
            color: #666;
            font-size: 14px;
        }

        .blog-post .comment-body {
            max-height: 200px; /* Adjust max-height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .blog-post .comment {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #fff;
        }

        .blog-post .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .blog-post .content {
            flex: 1;
            color: #fff;
        }

        .blog-post .comment-actions {
            width: 100%;
            margin-top: 20px;
        }

        .blog-post .authentication-required-card .card-body {
            text-align: center;
        }

        .blog-post .authentication-required-card .card-title {
            margin-bottom: 5px;
        }

        .comment-form {
            width: 100%;
            margin-top: 20px;
        }

        .comment-form .card {
            background-color: #333; /* Card background color */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Box shadow */
            width: 100%;
        }

        .comment-form .card-body {
            padding: 20px;
        }

        .comment-form .form-label {
            font-weight: bold;
            color: #fff; /* Form label color */
            margin-bottom: 10px;
        }

        .comment-form .form-control {
            background-color: #444; /* Form input background color */
            color: #fff; /* Form input text color */
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            height: auto;
            min-height: 100px;
            margin-bottom: 15px;
        }

        .btn-primary, .btn-like {
            background-color: #007bff; /* Button background color */
            color: #fff; /* Button text color */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover, .btn-like:hover {
            background-color: #0056b3; /* Darker color on hover */
        }

        .comment-form .btn {
            margin-top: 10px;
        }

        .btn-like {
            margin-top: 20px;
        }

        /* Define scrollbar width and color */
        .scroll::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        .scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .scroll::-webkit-scrollbar-thumb {
            background: red; /* Change color to red */
        }

        /* Handle on hover */
        .scroll::-webkit-scrollbar-thumb:hover {
            background: darkred; /* Change color to dark red on hover */
        }

        .form-label {
            color: #fff; /* Form label color */
            margin-bottom: 10px;
        }

        .form-control {
            background-color: #444; /* Form input background color */
            color: #fff; /* Form input text color */
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }

        .btn-primary, .btn-like {
            color: #fff; /* Button text color */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Modal Styles */
        .modal-fluffici {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.6); /* Black w/ opacity */
            padding-top: 60px; /* Location of the box */
        }

        .modal-fluffici .modal-content {
            background-color: #202225; /* Discord-like dark background color */
            margin: 5% auto; /* 5% from the top and centered */
            padding: 20px;
            border-radius: 10px;
            width: 60%; /* Smaller width */
            max-width: 500px; /* Maximum width */
            color: #fff; /* Text color */
            font-family: 'Roboto', sans-serif; /* Discord-like font */
        }

        /* Close button */
        .modal-fluffici .close {
            color: #fff;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-fluffici .close:hover {
            color: #ccc;
        }

        /* Tabs */
        .modal-fluffici .tab {
            overflow: hidden;
            border-bottom: 1px solid #4f545c; /* Discord-like separator color */
            margin-bottom: 15px;
        }

        /* Tab links */
        .modal-fluffici .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
            color: #8e9297; /* Discord-like text color */
            font-weight: bold;
            font-family: 'Roboto', sans-serif; /* Discord-like font */
        }

        /* Change background color of buttons on hover */
        .modal-fluffici .tab button:hover {
            background-color: #36393f; /* Discord-like button hover color */
        }

        /* Create an active/current tablink class */
        .modal-fluffici .tab button.active {
            background-color: red; /* Discord-like primary color */
            color: #fff; /* Text color */
        }

        /* Tab content */
        .modal-fluffici .tabcontent {
            display: none;
            padding: 20px;
            border-top: none;
        }

        /* Profile header */
        .modal-fluffici .profile-header {
            background-color: #0d71bb;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
            position: relative; /* Added for profile picture positioning */
        }

        .modal-fluffici .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #7289da; /* Discord-like primary color */
            position: absolute; /* Position the picture */
            top: calc(100% - 50px); /* Position from bottom */
            right: 20px; /* Space from right */
        }

        .modal-fluffici .profile-info {
            text-align: left;
        }

        .modal-fluffici .profile-name {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .modal-fluffici .profile-discriminator {
            font-size: 14px;
            color: #8e9297; /* Discord-like text color */
        }

        .modal-fluffici .badges {
            margin-top: 10px;
        }

        .modal-fluffici .badge {
            background-color: #43b581; /* Discord-like online status color */
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
        }

        /* About section */
        .modal-fluffici .about-section {
            margin-bottom: 20px;
        }

        .modal-fluffici .about-label {
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Separator */
        .modal-fluffici .separator {
            border-top: 1px solid #4f545c; /* Discord-like separator color */
            margin: 20px 0;
        }

        .modal-fluffici .role-container {
            display: flex;
            flex-wrap: wrap; /* Allow role cards to wrap to the next line if needed */
            align-items: center; /* Align items vertically */
        }

        /* Role card */
        .modal-fluffici .role-card {
            background-color: #36393f; /* Discord-like dark background color */
            padding: 5px; /* Reduced padding */
            border-radius: 5px;
            display: flex; /* Use flexbox */
            align-items: center; /* Align items vertically */
            margin-right: 5px;
            font-size: 12px; /* Reduced font size */
            text-transform: uppercase; /* Convert text to uppercase */
        }

        /* Icon */
        .modal-fluffici .role-card i {
            margin-right: 5px; /* Add space between icon and text */
        }

        .modal-fluffici .role-card svg {
            margin-right: 5px; /* Add space between icon and text */
        }

        .modal-fluffici .role-text {
            color: #fff; /* Text color */
            font-size: 14px;
        }

        .open-modal-btn-author {
            color: #fff;
        }

        .open-modal-btn-author:hover {
            color: #0a4fff;
        }

        @media only screen and (max-width: 768px) {
            .blog-post {
                flex-direction: row; /* Revert to horizontal alignment for larger screens */
            }

            .post-title {
                font-size: 20px;
            }

            .post-meta {
                font-size: 12px;
                color: #fff;
            }

            .post-content {
                width: 100%; /* Take full width on small screens */
                margin-right: 0;
            }

            .sidebar {
                width: 100%; /* Take full width on small screens */
            }

            .sidebar-title {
                font-size: 16px;
            }

            .bottom-sidebar {
                padding: 10px; /* Reduce padding */
            }

            .author-avatar {
                width: 40px;
                height: 40px;
            }

            .author-name {
                font-size: 16px;
            }

            .author-role {
                font-size: 12px;
            }

            .comment-card {
                width: 100%;
            }

            .avatar {
                width: 30px;
                height: 30px;
            }

            .comment {
                margin-bottom: 10px;
            }

            .comment-actions {
                margin-top: 10px;
            }

            .form-control {
                min-height: 80px;
            }

            .btn-primary,
            .btn-like,
            .btn {
                padding: 8px 16px;
                font-size: 14px;
            }

            .btn .btn-secondary {
                background-color: #0a4fff;
            }

            .modal-fluffici .modal-content {
                width: 80%; /* Adjusted width for smaller screens */
            }

            .modal-fluffici .profile-picture {
                width: 80px;
                height: 80px;
                top: calc(100% - 40px); /* Adjusted position */
            }

            .modal-fluffici .profile-name {
                font-size: 20px;
            }

            .modal-fluffici .profile-discriminator {
                font-size: 12px;
            }

            .modal-fluffici .badge {
                padding: 3px 6px; /* Adjusted padding */
                font-size: 10px; /* Adjusted font size */
            }

            .modal-fluffici .separator {
                margin: 10px 0;
            }

            .modal-fluffici .role-card {
                padding: 3px; /* Adjusted padding */
                margin-right: 3px; /* Adjusted margin */
                font-size: 10px; /* Adjusted font size */
            }

            /* CSS for the content container */
            .blog-post .content-container {
                max-width: 800px;
                margin: 2em auto;
                padding: 20px 40px;
                border-radius: 12px;
                box-shadow: 0 0 15px 5px rgba(0, 0, 0, 0.1);
            }

            .container-article {
                margin-top: 20px;
            }

            .container-article h1 {
                color: #fff;
            }

            .close-btn {
                position: absolute;
                right: 10px;
                top: 10px;
                cursor: pointer;
                font-size: 20px;
                color: red;
            }
        }
    </style>
@endsection

@section('metadata')
    <small class="post-meta" style="color: #fff">Zveřejněno v {{ \Carbon\Carbon::parse($page->created_at)->format("F j, Y, H:i") }}</small>
    <br>
    <small class="post-meta"
           style="color: #fff">{{ __('common.likes', [ 'likes' => $page->likes ]) }}</small>

    @if(Auth::check())
        <form action="{{ route('comment.like') }}" method="post">
            @csrf
            <input type="number" value="{{ $page->id }}" name="postId" hidden>

            @if (PostsLikes::where('post_id', $page->id)->where('user_id', Auth::id())->exists())
                <input type="text" value="unlike" name="action" hidden>
                <button type="submit" class="btn-primary btn-like" style="background-color: transparent">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-heart-filled" width="28" height="28"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path
                            d="M6.979 3.074a6 6 0 0 1 4.988 1.425l.037 .033l.034 -.03a6 6 0 0 1 4.733 -1.44l.246 .036a6 6 0 0 1 3.364 10.008l-.18 .185l-.048 .041l-7.45 7.379a1 1 0 0 1 -1.313 .082l-.094 -.082l-7.493 -7.422a6 6 0 0 1 3.176 -10.215z"
                            stroke-width="0" fill="currentColor"/>
                    </svg>
                </button>
            @else
                <input type="text" value="like" name="action" hidden>
                <button type="submit" class="btn-primary" style="background-color: transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart"
                         width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825"
                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path
                            d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                    </svg>
                </button>
            @endif
        </form>
    @endif
@endsection

@section('content')
    <div class="container-article">
        <h1 style="color: #fff">{{ __('common.report') }}</h1>
        <div class="row">
            <section class="blog-post">
                <div class="content-container">
                    {!! $page->body !!}
                </div>

                <div id="metadataSidebar" class="sidebar-article">
                    <div class="close-btn" onclick="$('#metadataSidebar').fadeOut()">&times;</div>

                    <div class="card sidebar-section">
                        <div class="card-body">
                            <h3 class="sidebar-title">{{ __('common.post.subjects') }}</h3>
                            <ul class="sidebar-list">
                                @if($subjects)
                                    @foreach ($subjects as $subject)
                                        @foreach(explode(' ', preg_replace('/[^a-zA-Z\s]/', '', ltrim($subject['name'], ' 0123456789.'))) as $tag)
                                            <li>
                                                <a href="#{{ Str::slug($tag) }}" style="color: #fff;">{{ $tag }}</a>
                                            </li>
                                        @endforeach
                                    @endforeach
                                @else
                                    <li>
                                        <a href="#" style="color: #fff;">Nebyly nastaveny žádné značky.</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="card sidebar-section">
                        <div class="card-body">
                            <h3 class="sidebar-title">{{ __('common.post.by') }}</h3>
                            <div class="author-info">
                                <img src="{{ $author->avatar }}" alt="avatar" class="author-avatar">
                                <div class="author-meta">
                                    <a class="author-name open-modal-btn-author">{{ $author->name }}</a>
                                    <p class="author-role"
                                       style="color: #fff;">{{ $author->roles }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card sidebar-section">
                        <div class="card-body">
                            <h3 class="sidebar-title">{{ __('common.post.comments') }}</h3>
                            <div class="card-body comment-body scroll">
                                @if($comments->isEmpty())
                                    <p style="color: white;">{{ __('common.post.no_comments') }}</p>
                                @else
                                    @foreach($comments as $comment)
                                        <div class="comment">
                                            <img class="avatar" src="{{ $comment->user->avatar }}"
                                                 alt="{{ $comment->user->name }}">
                                            <div class="content">
                                                <p class="author" style="color: #fff;">{{ $comment->user->name }}</p>
                                                <p class="text" style="color: #fff;">{{ $comment->message }}</p>
                                                <small class="time"
                                                       style="color: #fff;">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if(Auth::check())
                            <button class="btn btn-primary open-modal-btn">Napište komentář</button>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('modals')
    <div id="commentModal" class="modal-fluffici">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="modal-title">Komentář</h2>

            <form action="{{ route('comment.store') }}" method="post" class="card comment-form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="commentTextField" class="form-label">Napište komentář:</label>
                        <textarea class="form-control" name="comment" id="commentTextField" rows="3"
                                  style="background-color: #fff; color: #0e0d10;"></textarea>

                        <input type="number" value="{{ $page->id }}" name="postId" hidden>
                    </div>
                    <button type="submit" class="btn btn-primary">Odeslat komentář</button>
                </div>
            </form>
        </div>
    </div>

    <div id="authorModal" class="modal-fluffici">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="profile-header">
                <div class="profile-info">
                    <div class="profile-name">{{ $author->name }}</div>
                    <div class="profile-discriminator">{{ $author->tag }}</div>
                </div>
                <img src="{{ $author->avatar }}" alt="Profile Picture" class="profile-picture">
            </div>

            <div class="tab">
                <button class="tablinks active" onclick="openTab(event, 'UserInfo')">Uživatelské informace</button>
                <button class="tablinks" onclick="openTab(event, 'SocialMedia')">Sociální média</button>
            </div>

            <div id="UserInfo" class="tabcontent" style="display: block;">
                <div class="about-section">
                    <span class="about-label">O mně:</span>
                    <p>{{ $author->bio }}</p>
                </div>

                <div class="about-section">
                    <span class="about-label">Nálada:</span>
                    <p>{{ $author->pronouns }}</p>
                </div>

                <div class="about-section">
                    <span class="about-label">Připojil/a se k Fluffici v:</span>
                    <p>{{ $author->created_at->format('F j, Y, g:i a') }}</p>
                </div>

                <div class="about-section">
                    <span class="about-label">Roles</span>
                    <div class="role-container">
                        @foreach($author->roles_array as $role)
                            <div class="role-card">
                                @if($role === "Administrátor")
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-shield-check-filled" width="20" height="20"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M11.998 2l.118 .007l.059 .008l.061 .013l.111 .034a.993 .993 0 0 1 .217 .112l.104 .082l.255 .218a11 11 0 0 0 7.189 2.537l.342 -.01a1 1 0 0 1 1.005 .717a13 13 0 0 1 -9.208 16.25a1 1 0 0 1 -.502 0a13 13 0 0 1 -9.209 -16.25a1 1 0 0 1 1.005 -.717a11 11 0 0 0 7.531 -2.527l.263 -.225l.096 -.075a.993 .993 0 0 1 .217 -.112l.112 -.034a.97 .97 0 0 1 .119 -.021l.115 -.007zm3.71 7.293a1 1 0 0 0 -1.415 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z"
                                            stroke-width="0" fill="currentColor"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-urgent"
                                         width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8 16v-4a4 4 0 0 1 8 0v4"/>
                                        <path d="M3 12h1m8 -9v1m8 8h1m-15.4 -6.4l.7 .7m12.1 -.7l-.7 .7"/>
                                        <path
                                            d="M6 16m0 1a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z"/>
                                    </svg>
                                @endif
                                <p class="role-text">{{ $role }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="SocialMedia" class="tabcontent" style="display: block;">
                <div class="about-section">
                    <span class="about-label">Kontakty:</span>
                    <p>Nebyla nastavena žádná sociální média</p>
                </div>
            </div>

            <div class="separator"></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#metadataSidebar').hide()

            // Open modal when the button is clicked
            $(".open-modal-btn").click(function () {
                $("#commentModal").fadeIn();
            });

            $(".close").click(function () {
                $("#commentModal").fadeOut();
                $("#authorModal").fadeOut();
            });

            $(".open-modal-btn-author").click(function () {
                $("#authorModal").fadeIn();
            });

            $('#displayMetadata').on('click', () => {
                $('#metadataSidebar').show()
            })

            $(document).on('click', function(event) {
                // Check if the clicked target is the modal itself or its descendant elements
                if (!$(event.target).closest("#authorModal .modal-content").length) {
                    // Clicked outside the modal content
                    $("#authorModal").fadeOut(); // Hide the modal
                }
            });

            // Optional: Prevent the modal from hiding if you click inside it
            $("#authorModal .modal-content").on('click', function(event) {
                event.stopPropagation();
            });
        });

        function openTab(evt, tabName) {
            // Hide all tab content
            $(".tabcontent").hide();

            // Remove active class from all tablinks
            $(".tablinks").removeClass("active");

            // Show the specific tab content
            $("#" + tabName).show();

            // Add active class to the clicked tablink
            $(evt.target).addClass("active");
        }
    </script>
@endsection
