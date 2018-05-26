<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>MRGames</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            html, body {
                background-color: #F0FFFF;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 44px;
            }

            .links {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .text {
              font-size: 24px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title">
                    Добро пожаловать на наш сайт с мини-играми!
                </div>
                <div class="text">
                  Здесь вы найдете множество интересных игр, в которые сможете поиграть с друзьями онлайн!
                </div>
                <img src="{{asset('img/snake.png')}}" width="50%">
                <div class="text">
                  <a href="{{ url('/game/0') }}">Пошли играть!</a>
                </div>


            </div>
        </div>
    </body>
</html>
