<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8"/>
        <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link href='https://fonts.googleapis.com/css?family=Lexend Deca' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+64NhFtSv4Yl4wlLhGw/Kck/jI8K1UZflFJwAwewI3lpv1Z" crossorigin="anonymous">

        <meta property="og:image" content="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" />
        <meta property="og:image:secure_url" content="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="128" />

        <meta name="og:title" content="Logged in • Fluffici"/>
        <meta name="og:type" content="summary"/>

        <meta name="og:description" content="@yield('description')"/>

        <meta name="copyright" content="Fluffici Z.S">
        <meta name="webmaster" content="Vakea, vakea@fluffici.eu">

        <meta name="contact" content="administrace@fluffici.eu">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta content="yes" name="apple-touch-fullscreen" />
        <meta name="apple-mobile-web-app-status-bar-style" content="red">
        <meta name="format-detection" content="telephone=no">
        <meta name="theme-color" content="#FF002E">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

        <title>Logged in - Fluffici</title>

        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f0f2f5; /* Background color */
                margin: 0;
                padding: 0;
                position: relative;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .logo {
                width: 80px;
                position: absolute;
                top: 20px;
                right: 20px;
            }

            .container {
                text-align: center;
            }

            h1 {
                margin-bottom: 20px;
                color: #333; /* Heading color */
            }

            p {
                margin-bottom: 20px;
                color: #666; /* Paragraph color */
            }

            .loading-spinner {
                color: #ff8300; /* Spinner color */
                font-size: 36px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <img src="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" alt="Fluffici Logo" class="logo">
        <div class="container">
            <h1>{{ __('common.login.success') }}</h1>
            <p>{{ __('common.login.now') }}</p>
            <small>{{ __('common.login.redirecting') }}</small>
            <div class="loading-spinner">
                <i class="fas fa-circle-notch fa-spin"></i>
            </div>
        </div>

        <script>
            setTimeout(function() {
                window.location.href = 'https://blog.fluffici.eu';
            }, 5000);
        </script>
    </body>
</html>
