<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Carrinho de Compras</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{url('/')}}">Carrinho de Compras</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-targer="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{__('Toggle navigation')}}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- NavBar lado esquerdo -->
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <!-- Navbar lado direito-->
                    <ul class="navbar-nav ml-auto">
                        <!-- Links de Autenticação -->
                        @guest
                        <li class="nav-item">
                            <a class="navbar-link" href="#">

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">

                            </a>
                        </li>

                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">Minhas Compras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Carrinho de Compras</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="" onclick="">
                                </a>

                                <form id="logout-form" action="" method="POST" style="display: none;">
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
        @stack('scripts')
    </div>
</body>

</html>
