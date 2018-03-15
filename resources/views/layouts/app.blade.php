<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cuentónomo</title>
    <meta name='Description' content='Cuentas fáciles para los autónomos. Genera tus facturas.'>
    <meta name='Keywords' content='Cuentas, Facturas, Autónomo, Gratis'>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <meta name="author" content="Andreu garcía" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    @yield('css')

    <style media="screen">
      body {
        padding-top: 5rem;
      }
      .btn-epic {
        padding: .75rem 2.5rem;
        color: #fff;
        text-shadow: 1px 1px 2px #333;
        /*border-color: ;*/
        border: 2px solid #fff;
        background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
        transition: all 2.5s;
      }
      .btn-epic:hover {
        text-shadow: 1px 1px 3px #999;
        /*border-color: #000;*/
        border: 2px solid #333;
        cursor: pointer;
        /*background:linear-gradient(60deg, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82, #f79533);*/
        transition: all 0.5s;
      }
      .lafecha { font-size: 13px; }
      .fw-200 { font-weight: 200; }
    </style>

</head>
<body>

    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
          <a class="navbar-brand" href="{{ url('home') }}">
            {{-- fa-briefcase --}}
            <i class="fa fa-fw fa-moon-o" aria-hidden="true"></i>
            Cuentónomo
          </a>
          {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button> --}}

          <a href="{{ url('new') }}" class="navbar-toggler btn btn-outline-warning my-2 my-sm-0" title="Nuevo"><i class="fa fa-plus"></i></a>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              @guest
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
              @else
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="{{ url('user') }}"><i class="fa fa-fw fa-user"></i> Tus datos</a>
                  <a class="dropdown-item" href="{{ url('home') }}"><i class="fa fa-fw fa-pie-chart"></i> Dashboard</a>
                  <a class="dropdown-item" href="{{ url('new') }}"><i class="fa fa-fw fa-plus"></i> Nuevo</a>
                  <a class="dropdown-item" href="{{ url('horas') }}"><i class="fa fa-fw fa-clock-o"></i> Horas</a>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </div>
              </li>
              @endguest
            </ul>
            <div class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
              <a href="{{ url('new') }}" class="btn btn-outline-warning my-2 my-sm-0" title="Nuevo"><i class="fa fa-plus"></i></a>
            </div>
          </div>
        </nav>

        @yield('content')

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

    @yield('scripts')

    <script type="text/javascript">
      // Cargamos los tooltips on ready
      $(function() { $('[data-toggle="tooltip"]').tooltip(); });
    </script>

</body>
</html>
