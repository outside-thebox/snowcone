<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="assets/css/app.css" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/vue.js') !!}
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('js/HoldOn.js') !!}
    {!! Html::script('js/jquery.mask.js') !!}
    {!! Html::style('assets/css/HoldOn.css', array('media' => 'screen')) !!}
    {!! Html::style('assets/css/font-awesome.css', array('media' => 'screen')) !!}

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        /*
         Possible types: "sk-cube-grid", "sk-bounce", "sk-folding-cube","sk-circle","sk-dot","sk-falding-circle"
         "sk-cube-grid", "custom"
         */
        function cargando(type,message){
            HoldOn.open({
                theme: type,
                message:"<h4>"+message+"</h4>"
            });

            setTimeout(function(){
                HoldOn.close();
            },300000);
        }

    </script>



</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" id="main">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        cargando("sk-folding-cube",'');
    </script>
    @yield('scripts')
    <script>
        HoldOn.close();
    </script>
</body>
</html>
