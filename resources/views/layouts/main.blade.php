<!doctype html>
<html>
    <head>
        <meta name="author" content="Russell James F. Bello">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} | Queuing Application</title>

        <link rel="stylesheet" href="/semantic/dist/semantic.min.css">
        <link rel="stylesheet" href="{{ mix('css/globals.css') }}">
        @yield('custom_css')
    </head>
    <body style="background-color: #fafafa">
        @if(Auth::check())
            <div class="ui left vertical inverted sidebar labeled icon menu">
                <a class="item" href="{{ url('/') }}">
                    <i class="home icon"></i>
                    Home
                </a>

                <a class="item" href="{{ url('stats') }}">
                    <i class="chart bar icon"></i>
                    Stats
                </a>

                @if(Auth::user()->is_admin)
                    <a class="item" href="{{ url('reset') }}">
                        <i class="undo icon"></i>
                        Reset Queue
                    </a>

                    <a class="item" href="{{ url('users') }}">
                        <i class="users icon"></i>
                        Users
                    </a>
                @endif

                <a class="item" href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                    <i class="sign out icon"></i>
                    Log Out
                </a>
            </div>

            <form id="logout_form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endif

        <div id="main_content" class="pusher">
            @yield('content')
        </div>

        <script src="{{ mix('/js/app.js') }}"></script>
        <script src="/semantic/dist/semantic.min.js"></script>
        @yield('custom_js')
    </body>
</html>