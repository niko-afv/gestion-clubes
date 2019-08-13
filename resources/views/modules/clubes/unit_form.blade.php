@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ (isset($unit))?'Actualizar Unidad':'Crear una unidad' }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
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

                        @if(isset($unit))
                        <form method="post" action="{{ route('update_unit', $unit) }}">
                        @else
                        <form method="post" action="{{ route('save_unit') }}">
                        @endif
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Nombre</label>

                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users"></i></span> <input type="text" class="form-control" name="name" value="{{ isset($unit)?$unit->name:old('name') }}" {{ (isset($unit) && $unit->isLocked())?'disabled':'' }}>
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
                                    <textarea class="form-control" placeholder="Se aconseja indicar el rango de edad de sus miembros, el significado del nombre, etc." name="description" {{ (isset($unit) && $unit->isLocked())?'disabled':'' }}>{{ isset($unit)?$unit->description:old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Añadir Integrantes</label>
                                <div class="col-sm-9">
                                    <select class="select2_demo_3 form-control select2-hidden-accessible" multiple tabindex="-1" aria-hidden="true" name="members[]" {{ (isset($unit) && $unit->isLocked())?'disabled':'' }}>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('zone'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('zone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                @if(isset($unit) && $unit->isLocked())
                                    <div class="col-sm-12 col-sm-offset-2">
                                        <div class="alert alert-warning">
                                            <big class="text-center">
                                                Esta Unidad <strong>Está Participando</strong> De Un Evento Activo.
                                            </big>

                                            <p>
                                                Antes de modificarla, debe desinscribirla del evento.
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
                            <div class="hr-line-dashed"></div>
                            @if(isset($unit))
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Integrantes Actuales</label>
                                <div class="col-sm-9">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        @if(!$unit->isLocked())
                                        <th>Remover</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($unit->members as $member)
                                        <tr class="">
                                            <td>{{ $member->name }}</td>
                                            @if(!$unit->isLocked())
                                            <td class="center">
                                                <a class="remove_member" data-id="{{ $member->id }}" class="btn"><i class="fa fa-trash"></i>&nbsp;</a>
                                            </td>
                                            @endif
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
          "positionClass": "toast-top-right",
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
          placeholder : "Selecciona un miembro del Club",
          alowClear: true
        })

        @if(isset($unit))
        $('.remove_member').click(function () {
          var member_id = $(this).data('id');
          var token = $("input[name='_token']").val();
          $element = $(this);

          $.post('{{ route('remove_member', $unit->id) }}', {member: member_id, _token: token }, function (response) {

            if (response.error){
              toastr.warning(response.message, 'Cuidado');
            }else {
              toastr.success(response.message, 'Excelente');
              $element.parent().parent().fadeOut(1000);
            }
          })
        })
        @endif

      });

    </script>
@endsection