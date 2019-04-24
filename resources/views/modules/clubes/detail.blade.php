@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $club->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('clubes_list') }}">Clubes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ $club->name }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="wrapper wrapper-content animated fadeInUp">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="m-b-md">
                            <!--<a href="#" class="btn btn-white btn-xs float-right">Edit project</a>-->
                            <h2>{{ $club->name }}</h2>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Estado:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label {{($club->active)?'label-primary':'label-danger'}}">{{ ($club->active)?'ACTIVO':'INACTIVO' }}</span></dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Director:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ ($club->hasDirector())?$club->director->name:'Director no asociado' }}</dd> </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Unidades:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ $club->units->count() }}</dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Zona:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1"><a href="#" class="text-navy">{{ $club->zone->name }}</a> </dd></div>
                        </dl>

                    </div>
                    <div class="col-lg-6" id="cluster_info">

                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Last Updated:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">16.08.2014 12:15:57</dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Created:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"> 10.07.2014 23:36:57</dd>
                            </div>
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
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i>Unidades</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="full-height-scroll">
                                            @if(Auth::user()->profile->level >=3)
                                            <div class="">
                                                <p>
                                                    <button onclick="window.location.replace('{{ route('add_member') }}');" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus"></i>&nbsp;Nuevo Miembro</button>
                                                </p>
                                            </div>
                                            @endif
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <tbody>
                                                    @foreach($club->members as $member)
                                                    <tr>
                                                        <td class="client-avatar"><img alt="image" src="{{ $member->avatar }}"> </td>
                                                        <td><a href="#" class="client-link">{{ $member->name }}</a></td>
                                                        <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                        <td>{{ $member->phone }}</td>
                                                        <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                        <td>{{ $member->email }}</td>
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
                                            <p>
                                                <button onclick="window.location.replace('{{ route('add_unit') }}');" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus"></i>&nbsp;Nuevo Unidad</button>
                                            </p>
                                        @endif
                                        <div class="full-height-scroll">
                                            <div class="row">
                                                @foreach($club->units as $unit)
                                                <div class="col-lg-4">
                                                    <div class="ibox">
                                                        <div class="ibox-title">
                                                            <!--
                                                            <span class="label label-primary float-right">NEW</span>
                                                            <h5>Unidad: Nombre de Unidad</h5>
                                                            -->
                                                        </div>
                                                        <div class="ibox-content">
                                                            <div class="team-members">
                                                            </div>
                                                            <h4>{{ $unit->name }}</h4>
                                                            <p>

                                                            </p>
                                                            <div>
                                                                <span>Fuerza:</span>
                                                                <div class="stat-percent">{{ $unit->members->count() }} Miembros</div>
                                                                <div class="progress progress-mini">
                                                                    <div style="width: 0%;" class="progress-bar"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row  m-t-sm">
                                                                <div class="col-sm-12">
                                                                    <div class="font-bold">Consejero</div>
                                                                    {{ 'No Asignado' }}
                                                                </div>
                                                                <div class="col-sm-4 text-right">
                                                                    <a href="{{ route('edit_unit', $unit->id) }}" class="btn btn-outline btn-link" title="Editar Unidad"><i class="fa fa-edit"></i></a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

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
    </div>
@endsection


@section('scripts')
    <script>
      $(document).ready(function(){

      });

    </script>
@endsection