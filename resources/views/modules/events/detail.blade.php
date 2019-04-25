@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $event->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('events_list') }}">Eventos</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ $event->name }}</strong>
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
                            <h2>{{ $event->name }}</h2>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Estado:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label {{($event->active)?'label-primary':'label-danger'}}">{{ ($event->active)?'Activo':'Inactivo' }}</span></dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Description:</dt> </div>
                            <div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $event->description }}</dd> </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Unidades:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ 0 }}</dd></div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right"><dt>Zona:</dt> </div>
                            <div class="col-sm-8 text-sm-left"> <dd class="mb-1"><a href="#" class="text-navy">{{ $event->eventable->name }}</a> </dd></div>
                        </dl>

                    </div>
                    <div class="col-lg-6" id="cluster_info">

                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Fecha inicio:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">{{ \Carbon\Carbon::create($event->start)->format('d-M-Y') }}</dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-right">
                                <dt>Fecha término:</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">{{ \Carbon\Carbon::create($event->end)->format('d-M-Y') }}</dd>
                            </div>
                        </dl>
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