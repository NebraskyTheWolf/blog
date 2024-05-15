@php use Carbon\Carbon; @endphp

<!--
    ===========================================
     SOFTWARE PRODUCT PROPRIETARY LICENSE
    ===========================================

    Fluffici, z.s., IČO: 19786077, Year: 2024

    DEVELOPER INFORMATION:
    Developer Name: Vakea
    Contact Information: vakea@fluffici.eu

    TERMS AND CONDITIONS FOR USAGE

    1. You may only use the Software Product in accordance with the accompanying documentation.
    2. Reproduction and distribution of the Software Product are strictly prohibited, except through official channels defined and controlled by the copyright holder. Any illegal reproduction or distribution will be subject to legal action.
    3. You may not modify or make derivative works of the Software Product.
    4. You must retain all copyright, trademark, and proprietary notices on all copies of the Software Product made, if any.
    5. You are not granted any rights to any trademarks or service marks of the Software Product.

    THIS SOFTWARE PRODUCT IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.

    ===========================================
-->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8"/>
        <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/event.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.0/dist/cookieconsent.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        @sectionMissing('image')
            <meta property="og:image" content="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" />
            <meta property="og:image:secure_url" content="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" />
            <meta property="og:image:type" content="image/png" />
            <meta property="og:image:width" content="128" />
            <meta property="og:type" content="summary">
        @endif

        <meta name="copyright" content="Fluffici Z.S">
        <meta name="developer" content="Vakea <vakea@fluffici.eu>">
        <meta name="contact" content="administrace@fluffici.eu">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta content="yes" name="apple-touch-fullscreen" />
        <meta name="apple-mobile-web-app-status-bar-style" content="red">
        <meta name="format-detection" content="telephone=no">
        <meta name="theme-color" content="#FF002E">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title') - Fluffici">
        @hasSection('description')
            <meta property="twitter:description" content="@yield('description')">
        @endif
        @hasSection('image')
            <meta property="twitter:image" content="@yield('image')">
        @endif

        <meta property="og:title" content="@yield('title') - Fluffici">

        @hasSection('description')
            <meta property="og:description" content="@yield('description')">
        @endif
        @hasSection('image')
            <meta property="og:image" content="@yield('image')">
            <meta property="og:type" content="website">
        @endif

        <meta property="og:url" content="{{ url()->current() }}">

        @yield('head')

        <title>@yield('title') - Fluffici</title>
    </head>
   <body class="dark:bg-dots-lighter">
        <x-fluffici-aside/>

        <main class="main-content">
            <section class="dashboard-section">
                <h2>@yield('title')</h2>
                @yield('metadata')
            </section>

            @yield('content')
        </main>

        <footer class="footer">
            <div class="footer-content">
                <p>Copyright &copy; <a href="https://fluffici.eu">Fluffíci, z.s.</a> {{ Carbon::now()->year }} | Všechna práva vyhrazena.</p>
                <div class="developer-card">
                    <p>Developed by <a href="https://nebraskythewolf.work/en">Vakea</a> with ❤️🦊</p>
                </div>
            </div>
        </footer>

        <script type="module" src="{{ url('/js/cookieconsent-config.js') }}"></script>
        <script src="{{ url('/js/app.js') }}"></script>
        @yield('modals')
        @yield('script')

        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            @if (session('flash.success'))
            toastr.success("{!! addslashes(session('flash.success')) !!}")
            @endif
            @if (session('flash.error'))
            toastr.error("{!! addslashes(session('flash.error')) !!}")
            @endif
            @if (session('flash.warning'))
            toastr.warning("{!! addslashes(session('flash.warning')) !!}")
            @endif
            @if (session('flash.info'))
            toastr.info("{!! addslashes(session('flash.info')) !!}")
            @endif

            displayHeaders('Blog');
        </script>
    </body>
</html>
