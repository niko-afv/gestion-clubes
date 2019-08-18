@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Crear un Club</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('my_club') }}">Clubes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Nuevo Club</strong>
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
                        <h5>Ingrese los datos del nuevo club</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        @if(isset($club))
                            <form method="post" action="{{ route('update_club', $club) }}">
                                @else
                                    <form method="post" action="{{ route('save_club') }}">
                                        @endif

                                        <div class="form-group  row">
                                            <label class="col-sm-2 col-form-label">Nombre del Club</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" value="{{ isset($club)?$club->name:old('name') }}" {{ (isset($club) && $club->isLocked())?'disabled':'' }}>
                                                @if ($errors->has('name'))
                                                    <div class="alert alert-danger">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Zona</label>
                                            <div class="col-sm-9">
                                                <select class="select2_demo_3 form-control select2-hidden-accessible"  tabindex="-1" aria-hidden="true" name="zone" {{ (isset($club) && $club->isLocked())?'disabled':'' }}>
                                                    <option>Selecciona una alternativa</option>
                                                    @foreach($zones as $zone)
                                                        <option value="{{ $zone->id }}" {{ (old('zone') == $zone->id)?'selected':'' }}>{{ $zone->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('zone'))
                                                    <div class="alert alert-danger">
                                                        {{ $errors->first('zone') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            @if(isset($club) && $club->isLocked())
                                                <div class="col-sm-12 col-sm-offset-2">
                                                    <div class="alert alert-warning">
                                                        <big class="text-center">
                                                            <strong>Esta miembro Está Participando de un evento activo.</strong>
                                                        </big>

                                                        <p>
                                                            Antes de modificarlo, debe desinscribirlo del evento.
                                                        </p>

                                                        <a class="alert-link" href="{{ route('events_list') }}">Ir a ventos</a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-sm-6 col-sm-offset-2">
                                                    {{ csrf_field() }}
                                                    <input hidden name="club_id" value="{{ Auth::user()->member->institutable->id }}">
                                                    <button class="btn btn-primary btn-lg pull-right" type="submit">Guardar</button>
                                                </div>
                                            @endif

                                        </div>

                                        @if(isset($club) && $club->zones()->count())
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Cargos Actuales</label>
                                                <div class="col-sm-9">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                                            <thead>
                                                            <tr>
                                                                <th>Cargo</th>
                                                                <th>Remover</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($club->zones as $zone)
                                                                <tr class="">
                                                                    <td>{{ $zone->name }}</td>
                                                                    <td class="center">
                                                                        <a class="remove_club" data-id="{{ $zone->id }}" title="Ver Evento" class="btn"><i class="fa fa-trash"></i>&nbsp;</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif
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
          "zoneClass": "toast-top-right",
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

        $('.select2_demo_3').select2({
          placeholder : "Selecciona una Zona",
          alowClear: true
        })

      });

    </script>
@endsection