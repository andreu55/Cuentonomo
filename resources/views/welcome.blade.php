<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Cuentónomo</title>
  <meta name='Description' content='Cuentas fáciles para los autónomos. Genera tus facturas.'>
  <meta name='Keywords' content='Cuentas, Facturas, Autónomo, Gratis'>

  <link rel="shortcut icon" href="{{ asset('public/img/gnomo.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

  <style>
    html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Raleway', sans-serif;
      font-weight: 100;
      height: 100vh;
      margin: 0;
    }
    .full-height { height: 100vh; }
    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }
    .position-ref { position: relative; }
    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }
    .content { text-align: center; }
    .title { font-size: 84px; }
    .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }
    .m-b-md { margin-bottom: 30px; }
  </style>
</head>
<body>
  <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
      <div class="top-right links">
        @auth
          <a href="{{ url('home') }}">Home</a>
        @else
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}">Register</a>
        @endauth
      </div>
    @endif

    <div class="content">
      <img src="{{ asset('public/img/gnomo.svg') }}" alt="Gnómo!">
      <div class="title m-b-md"><i class="far fa-moon"></i>uentónomo</div>
      <div class="links"><a>Cuentas fáciles para los autónomos</a></div>
    </div>
  </div>
</body>
</html>
