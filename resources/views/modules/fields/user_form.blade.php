@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ (isset($member->user))?'Cambiar Password':'Añadir Como Usuario' }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('my_field') }}">{{ Auth::user()->member->institutable->name }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">Miembros</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">{{ $member->name }}</a>
                </li>
                <li class="breadcrumb-item active">
                    @if(isset($member->user))
                        <strong>Cambiar password de usuario</strong>
                    @else
                        <strong>Añadir como usuario</strong>
                    @endif
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Ingrese los datos del usuario</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="{{ route('save_field_user', $member) }}">
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Email</label>

                                <div class="col-sm-10">
                                    <div class="input-group phone">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span><input type="text" class="form-control" name="email" disabled value="{{ isset($member)?$member->email:old('email') }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Password</label>

                                    <div class="col-sm-10">
                                        <div class="input-group phone">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control" name="password" value="">
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Repetir Password</label>

                                    <div class="col-sm-10">
                                        <div class="input-group phone">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" class="form-control" name="password_confirmation" value="">
                                        </div>
                                        @if ($errors->has('password_confirmation'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('password_confirmation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Perfil</label>
                                <div class="col-sm-9">
                                    <select class="select2_demo_3 form-control select2-hidden-accessible" multiple  tabindex="-1" aria-hidden="true" name="profile">
                                        <option>Selecciona una alternativa</option>
                                        @foreach($profiles as $profile)
                                            <option value="{{ $profile->id }}" {{ (old('profile') == $profile->id || (isset($member->user) && $member->user->profile_id == $profile->id))?'selected':'' }}>{{ $profile->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('profile'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('profile') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 col-sm-offset-2">
                                    {{ csrf_field() }}
                                    <input hidden name="club_id" value="{{ Auth::user()->member->institutable->id }}">
                                    <button class="btn btn-primary btn-lg pull-right" type="submit">Guardar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
      $(document).ready(function(){
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "progressBar": true,
          "preventDuplicates": false,
          "profileClass": "toast-top-right",
          "onclick": null,
          "showDuration": "400",
          "hideDuration": "1000",
          "timeOut": "7000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };

        $('#data_3 .input-group.date').datepicker({
          startView: 2,
          todayBtn: "linked",
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true
        });

        $('.select2_demo_3').select2({
          placeholder : "Selecciona un campo",
          alowClear: true
        })
      });

    </script>
@endsection