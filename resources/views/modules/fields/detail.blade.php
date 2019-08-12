@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $field->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('clubes_list') }}">Clubes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ $field->name }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="m-b-md">
                            <!--<a href="#" class="btn btn-white btn-xs float-right">Edit project</a>-->
                            <h2>{{ $field->name }}</h2>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Estado:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label {{($field->active)?'label-primary':'label-danger'}}">{{ ($field->active)?'ACTIVO':'INACTIVO' }}</span></dd></div>
                        </dl>
                        <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right"><dt>Director:</dt> </div>
                                <div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ ($field->hasDirector())?$field->director->name:'Director no asociado' }}</dd> </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Campo Superior:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1"><a href="#" class="text-navy">{{ $field->parent->name }}</a> </dd></div>
                        </dl>

                    </div>
                </div>

                <div class="row m-t-sm">
                    <div class="col-lg-12">
                        <div class="ibo">
                        <div class="ibox-content">
                            <div class="clients-list">
                                <ul class="nav nav-tabs">
                                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i>Miembros</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i>Zonas</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="full-height-scroll">
                                            @if(Auth::user()->profile->level >=3)
                                            <div class="">
                                                <p>

                                                </p>
                                                <p style="text-align: right">
                                                    <a href="{{ route('add_member') }}" class="btn btn-outline btn-primary"><i class="fa fa-plus"></i>&nbsp;Nuevo Miembro</a>
                                                    &nbsp;

                                                    <a href="{{ route('import_member') }}" class="btn btn-outline btn-primary"><i class="fa fa-table"></i>&nbsp;Importar</a>


                                                </p>
                                            </div>
                                            @endif
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover dataTables-example">
                                                    <thead>
                                                    <tr>
                                                        <td>Nombre</td>
                                                        <td>Rut</td>
                                                        <td>Edad</td>
                                                        <td></td>
                                                        <td>Telefono</td>
                                                        <td></td>
                                                        <td>E-mail</td>
                                                        <td>Cargos</td>
                                                        <td>Acciones</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($field->members as $member)
                                                    <tr>
                                                        <!--
                                                        <td class="client-avatar"><img alt="image" src="{{ $member->avatar }}"> </td>
                                                        -->
                                                        <td><a href="#" class="client-link">{{ $member->getName() }}</a></td>
                                                        <td><a href="#" class="client-link">{{ $member->dni }}</a></td>
                                                        <td><a href="#" class="client-link">{{ ($member->age() == 0)?'No Especificado':$member->age() }}</a></td>
                                                        <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                        <td>{{ $member->phone }}</td>
                                                        <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                        <td>{{ $member->email }}</td>
                                                        <td>
                                                            @foreach($member->positions as $position)
                                                                <span class="tag label label-primary">{{ strtoupper($position->name) }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a style="color: #1c84c6; display: inline-block; width: 20%;" href="{{ route('edit_member', $member->id) }}" class="btn btn-outline btn-link" title="Modificar"><i class="fa fa-edit"></i></a>
                                                            <a style="color: #ED5565; display: inline-block; width: 20%;" data-id="{{ $member->id }}" href="{{ route('delete_member') }}" class="btn btn-outline btn-link delete_member" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                                                        </td>
                                                        <!--
                                                        <td class="client-status"><span class="label label-primary">Active</span></td>
                                                        -->
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        @if(Auth::user()->profile->level >=3)
                                            <div class="">
                                                <p>

                                                </p>
                                                <p style="text-align: right">
                                                    <a href="{{ route('add_unit') }}" class="btn btn-outline btn-primary"><i class="fa fa-plus"></i>&nbsp;Nuevo Unidad</a>
                                                </p>
                                            </div>
                                        @endif
                                        <div class="full-height-scroll">
                                            <div class="container">
                                                <div class="row">

                                                    @foreach($field->zones as $zone)

                                                        <div class="col-lg-3">
                                                            <div class="ibox ">
                                                                <div class="ibox-title">
                                                                    <p></p>
                                                                    <p>
                                                                    </p>

                                                                    <h5>{{ $zone->name }}</h5>
                                                                </div>
                                                                <div class="ibox-content">
                                                                    <h3>Fuerza:</h3>
                                                                    <h1 class="no-margins">{{ $zone->clubs->count() }}</h1>

                                                                    <div class="stat-percent font-bold text-danger">&nbsp;&nbsp;{{ $zone->clubs()->disabled()->count() }} <i class="fa fa-window-close"></i></div>
                                                                    <div class="stat-percent font-bold text-success">{{ $zone->clubs()->activated()->count() }} <i class="fa fa-check-square"></i></div>

                                                                    <small>Clubes</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            {{ csrf_field() }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function(){

        $('.dataTables-example').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp'
        });

      $('.unit_sync').click(function () {
            var url = $(this).data('url');
            var token = $("input[name='_token']").val();

            $.post(url, { _token: token }, function (response) {
              if (response.error == true){
                toastr.warning(response.message, 'Cuidado');
              }else {
                toastr.success(response.message, 'Excelente');
              }
            });
          });

        @if(Auth::user()->profile->level >= 3)
            $('.delete_member').click(function (event) {
                event.preventDefault();
                var member_id = $(this).data('id');
                var token = $("input[name='_token']").val();
                var url = $(this).attr('href');
                $element = $(this);

                $.post(url, {member_id: member_id, _token: token }, function (response) {
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