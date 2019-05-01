@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Crear un evento</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
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
                        <form method="post" action="{{ route('events_save') }}">
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Nombre</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
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
                                    <textarea class="form-control" placeholder="Ingrese una breve descripción del evento" name="description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row" id="data_5">
                                <label class="col-sm-2 col-form-label">Duración</label>
                                <div class="col-sm-10">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon">&nbsp;desde &nbsp;&nbsp;</span>
                                        <input type="text" class="form-control-sm form-control" name="start" value="{{ old('start') }}" autocomplete="off">
                                        <span class="input-group-addon">&nbsp;hasta &nbsp;&nbsp;</span>
                                        <input type="text" class="form-control-sm form-control" name="end" value="{{ old('end') }}" autocomplete="off">
                                    </div>
                                    @if ($errors->has('end'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('end') }}
                                        </div>
                                    @endif
                                    @if ($errors->has('start'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('start') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group row" id="zones_select">
                                <label class="col-sm-2 col-form-label">Zona (s)</label>
                                <div class="col-sm-9">
                                    @if(Auth::user()->profile->level == 1)
                                        @include('partials.zones_select', ['zones'=> $zones])
                                    @elseif(Auth::user()->profile->level == 0)
                                        @include('partials.fields_select', ['fields'=> $fields])
                                    @endif
                                    @if ($errors->has('zone'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('zone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group row">
                                <div class="col-sm-6 col-sm-offset-2">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary btn-lg pull-right" type="submit">Save changes</button>
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
        $('#data_5 .input-daterange').datepicker({
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true,
          startDate: '+1d'
        });

        $('.select2_demo_3').select2({
          placeholder : "Selecciona una alternativa",
          alowClear: true
        })
      });

    </script>
@endsection