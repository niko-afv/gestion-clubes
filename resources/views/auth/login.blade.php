<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AMCH| Login</title>

    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        img{
            display: block;
            margin: 0 auto 10px;
        }
    </style>
</head>

<body class="gray-bg">

<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">
            <!--
            <h2 class="font-bold">Welcome to IN+</h2>
            -->

            <img src="{{ url('images/parcheamch.png') }}" width="350">

            <!--
            <p>
                <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
            </p>
            -->

        </div>
        <div class="col-md-6 login_1">
            <div class="ibox-content">
                @if (session('alert'))
                    <div class="alert alert-{{ session('type') }}">
                        {{ session('msg') }}
                    </div>
                @endif
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <form class="m-t" role="form" action="index.html">
                    <div class="form-group">
                        <select class="chosen-select form-control" required name="club">
                            <option value="false">Selecciona tu Club</option>
                            @foreach($clubes as $club)
                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b next_login">Siguiente</button>

                </form>
                <p class="text-muted text-center">
                    <small>¿Tu club no aparece en el listado?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="/register">Activa tu Club</a>
            </div>
        </div>
        <div class="col-md-6 login_2" hidden>
            <div class="ibox-content">
                <h3 class="text-center club_title"></h3>
                <form class="m-t" role="form" action="{{ url('login') }}" method="post">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-Mail" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required="">
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>

                    <a href="#">
                        <small>Olvidé mi contraseña</small>
                    </a>

                    <p class="text-muted text-center">
                        <small>¿No es tu Club?</small>
                    </p>
                    <a class="btn btn-sm btn-white btn-block back_login" href="#">Volver</a>
                </form>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Conquistadores AMCH
        </div>
        <div class="col-md-6 text-right">
            <small>© 2019</small>
        </div>
    </div>
</div>

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
</body>

</html>
