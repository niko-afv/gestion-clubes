@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Crear una unidad</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('my_club') }}">Mi Club</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Nueva Unidad</strong>
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
                        <h5>Ingrese los datos de la nueva unidad</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <form method="post" action="{{ route('unit_save') }}">
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Nombre</label>

                                <div class="col-sm-10">
                                    <div class="input-group phone">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span> <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Se aconseja indicar el rango de edad de sus miembros, el significado del nombre, etc." name="description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('description') }}
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