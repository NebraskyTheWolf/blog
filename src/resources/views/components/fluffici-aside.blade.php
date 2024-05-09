@php use Illuminate\Support\Facades\Auth; @endphp
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('news') }}"><img src="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" alt="header" width="210" class="sidebar-brand"></a>
    </div>
    <div class="sidebar-nav">
        <h2>{{ __('common.main') }}</h2>
        <ul>
            <li class="active"><a href="{{ route('news') }}"><i class="fas fa-home"></i> {{ __('common.news') }}</a></li>
        </ul>
    </div>

    @if(Auth::check())
        <div class="sidebar-profile-card">
            @if (Auth::user()->avatar !== 1)
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff" alt="Profile Picture" width="50">
            @else
                <img src="https://autumn.fluffici.eu/avatars/{{ Auth::user()->avatar_id }}" alt="Profile Picture" width="50">
            @endif

            <p style="color: #fff">{{ Auth::user()->name }}</p>
        </div>
        <a class="logout-btn" href="{{ route('profile.logout') }}">{{ __('common.logout') }}</a>
    @else
        <a class="logout-btn" href="{{ app('authSDK')->getAuthURL() }}">{{ __('common.login') }}</a>
    @endif

    @if(request()->routeIs('article'))
        <button id="displayMetadata" class="meta-btn">{{ __('common.metadata') }}</button>
    @endif
</aside>
