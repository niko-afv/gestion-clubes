@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Crear un evento</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('events_list') }}">Eventos</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Nuevo evento</strong>
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
                        <h5>Ingrese los datos del nuevo evento</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <form method="post" action="{{ route('member_save') }}">
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Nombre Completo</label>

                                <div class="col-sm-10">
                                    <div class="input-group phone">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">RUT / DNI</label>

                                <div class="col-sm-10">
                                    <div class="input-group phone">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span> <input type="text" class="form-control" name="dni" value="{{ old('dni') }}">
                                    </div>
                                    @if ($errors->has('dni'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('dni') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                                <div class="col-sm-10">
                                    <div class="form-group" id="data_3">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="birthdate" value="{{ old('birthdate') }}">
                                        </div>
                                    </div>
                                    @if ($errors->has('birthdate'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('birthdate') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Telefono</label>

                                <div class="col-sm-10">
                                    <div class="input-group phone">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Email</label>

                                <div class="col-sm-10">
                                    <div class="input-group phone">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span><input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cargos</label>
                                <div class="col-sm-9">
                                    <select class="select2_demo_3 form-control select2-hidden-accessible" multiple  tabindex="-1" aria-hidden="true" name="position">
                                        <option>Selecciona una alternativa</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ (old('position') == $position->id)?'selected':'' }}>{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('position'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('position') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
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

        $(".touchspin1").TouchSpin({
          buttondown_class: 'btn btn-white',
          buttonup_class: 'btn btn-white'
        });
      });

    </script>
@endsection