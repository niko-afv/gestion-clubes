@extends('layouts.app')

@section('title', 'Clubes inscritos')

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
                    <a href="{{ route('event_detail', [$event->id]) }}">{{ $event->name }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Clubes inscritos</strong>
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
                                    <h2>Clubes inscritos</h2>
                                </div>

                            </div>
                        </div>
                        <!--
                        <div class="row">
                            <div class="col-lg-6">
                                <dl class="row mb-0">
                                    <div class="col-sm-4 text-sm-right"><dt>Estado:</dt> </div>
                                    <div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label {{($event->active)?'label-primary':'label-danger'}}">{{ ($event->active)?'Activo':'Inactivo' }}</span></dd></div>
                                </dl>
                                <dl class="row mb-0">

                                    <div class="col-sm-4 text-sm-right"><dt>Zona(s):</dt> </div>
                                    <div class="col-sm-8 text-sm-left">
                                        @foreach($event->zones as $zone)
                                            <span class="tag label label-primary">{{ strtoupper($zone->name) }}</span>
                                        @endforeach
                                    </div>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="row mb-0">
                                    <div class="col-sm-2 text-sm-right"><dt>Description:</dt> </div>
                                    <div class="col-sm-10 text-sm-left"><dd class="mb-1">{{ $event->description }}</dd> </div>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-5 col-lg-push-2">
                                <dl class="row mb-0">
                                    &nbsp;
                                    @if(Auth::user()->profile->level >1)
                                        @if($event->active)
                                            <a href="{{ route('show_inscribe', ['event_id' => $event->id]) }}" class="btn btn-block btn-primary" style="color: #fff;"><i class="fa fa-hand-o-up"></i>PARTICIPAR</a>
                                        @else
                                            <button type="button" disabled class="btn btn-block btn-primary" style="color: #fff;"><i class="fa fa-hand-o-up"></i>PARTICIPAR</button>
                                        @endif
                                    @endif
                                </dl>
                            </div>
                        </div>
                        -->



                        @if(Auth::user()->profile->level <= 1)


                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Miembros</th>
                                            <th>Unidades</th>
                                            <th>Zona</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($event->clubs as $club)
                                            <tr class="">
                                                <td>{{ $club->name }}</td>
                                                <td>{{ $event->members($club->id)->count() }}</td>
                                                <td>{{ $event->units($club->id)->count() }}</td>
                                                <td>{{ $club->zone->name }}</td>
                                                <td>
                                                    <button onclick="window.location.replace('{{ route('event_club_detail',['event'=>$event->id, 'club'=>$club->id]) }}');" title="Ver Evento" class="btn btn-primary" type="button">
                                                        <i class="fa fa-eye"></i>&nbsp;
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

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
      });

    </script>
@endsection