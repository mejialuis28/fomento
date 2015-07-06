<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Reserva de instrumentos</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon-social.css') }}">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="{{ asset('css/leaflet.ie.css') }}" />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @yield('css')

    <script src="{{ asset('js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>
<body>

<!-- Navigation & Logo-->
<div class="mainmenu-wrapper">
    <div class="container">
        <nav id="mainmenu" class="mainmenu">
            <ul>
                <li class="logo-wrapper"><a href="{{url('/')}}"><img src="{{asset('img/escudo.jpg')}}" alt="Politecnico Colombiano JIC"></a></li>
                @if (Auth::guest())
                    <li><a href="{{url('login')}}">Ingresar</a></li>
                @else
                    @if(Auth::user()->admin)
                        @if(Auth::user()->admin->activo)
                            @include('_navAdmin')
                        @else
                            @include('_navUser')
                        @endif
                    @else
                        @include('_navUser')
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <strong>{{ Auth::user()->tipo->nombre }}: </strong> {{ Auth::user()->nombres }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{url('logout')}}">Salir</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>


<!-- Services -->
<div class="section">
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Se presentaron los siguientes errores en la página:</strong><br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif(Session::get('mensaje'))
            @if(Session::get('tipo') == 'error')
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se presentó el siguiente error en la página:</strong><br><br>
                    <p>{{Session::get('mensaje')}}</p>
                </div>
            @elseif(Session::get('tipo') == 'success')
                <div class="alert alert-dismissible alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{Session::get('mensaje')}}</p>
                </div>
            @elseif(Session::get('tipo') == 'warning')
                <div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{Session::get('mensaje')}}</p>
                </div>
            @elseif(Session::get('tipo') == 'info')
                <div class="alert alert-dismissible alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{Session::get('mensaje')}}</p>
                </div>
            @endif
        @endif
        @yield('content')
    </div>
</div>
<!-- End Services -->


<!-- Footer -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-copyright">&copy; 2015 Politecnico Colombiano Jaime Isaza Cadavid. Todos los derechos reservados.</div>
            </div>
        </div>
    </div>
</div>

<!-- Javascripts -->
<script src="{{ asset('js/jquery-1.9.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!--<script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>
<script src="{{ asset('js/jquery.fitvids.js') }}"></script>
<script src="{{ asset('js/jquery.sequence-min.js') }}"></script>
<script src="{{ asset('js/jquery.bxslider.js') }}"></script>
<script src="{{ asset('js/main-menu.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>-->
@yield('scripts')
<script type="text/javascript">
    //script para cerrar las alertas.
    window.setTimeout(function() { $(".alert").alert('close'); }, 5000);
</script>
</body>
</html>