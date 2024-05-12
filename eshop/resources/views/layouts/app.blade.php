<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <a class="nav-link " href="{{ route('books.search') }}"><h5>Knihy</h5></a>
                    <a class="nav-link " href="{{ route('books.admin') }}"><h5>Pridať knihu</h5></a>
                </ul>

                    <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">

                        <!-- Authentication Links -->
                        @guest

                        <a class="nav-link " href="" onclick="displayCart();return false;"><h5>Košík</h5></a>
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Prihlásiť sa</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Zaregistrovať sa</a>
                                </li>
                            @endif
                        @else

                            <a class="nav-link " href="{{ route('cart.index') }}"><h5>Košík</h5></a>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->email }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Odhlásiť sa
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
    function checkInput() {
      var input = document.querySelector('input[name="q"]').value;
      var button = document.getElementById('searchButton');
      button.disabled = input.trim() === ''; // Disable button if input is empty or just whitespace
    }
    </script>
    <script src="{{ asset('cart.js') }}"></script>
</body>
</html>
