<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AMCH | Activa tu Club</title>

    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        h1{
            font-size: 110px !important;
        }
    </style>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">AMCH</h1>

        </div>
        <h3 class="text-center">Activación de Acceso</h3>
        <p class="text-center">Para acceder al sistema de gestión, el club debe ser activado por el director.</p>

        @if (session('alert'))
            <div class="alert alert-{{ session('type') }}">
                {{ session('msg') }}
            </div>
        @endif
        <form class="m-t" role="form" action="{{ url('register') }}" method="post">
            <div class="form-group">
                <select class="chosen-select form-control" required name="club">
                    <option value="">Selecciona un Club</option>
                    @foreach($clubes as $club)
                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email del director" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">Activar</button>

            {{ csrf_field() }}

            <p class="text-muted text-center"><small>Si tu club no aparece, puede deberse a que ya fue activado o a que no está registrado en nuestro campo</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ url('login') }}">Volver</a>
        </form>
        <p class="m-t"> <small>Conquistadores AMCH 2018</small> </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="js/popper.min.js"></script>
<script src="js/app.js"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
  $(document).ready(function(){
    $('.i-checks').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
    });
  });
</script>
</body>

</html>
