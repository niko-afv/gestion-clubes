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
                    <a href="{{ route('event_detail', [$event->id]) }}">{{ $event->name }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('event_clubs', [$event->id]) }}">Clubes inscritos</a>
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
        <div class="col-lg-12">
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


                @if(Auth::user()->profile->level <= 1)
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <!--
                                    <span class="label label-success float-right"></span>
                                    -->
                                    <h5>Unidades</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $event->units($club->id)->count() }}</h1>
                                    <!--
                                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                                    -->
                                    <small>Unidades inscritos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <!--
                                    <span class="label label-success float-right"></span>
                                    -->
                                    <h5>Miembros</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $event->members($club->id)->count() }}</h1>
                                    <!--
                                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                                    -->
                                    <small>Miembros inscritos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <!--
                                    <span class="label label-success float-right"></span>
                                    -->
                                    <h5>Directivos</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $event->members($club->id, [1,2,3,4,5,6])->count() }}</h1>
                                    <!--
                                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                                    -->
                                    <small>Directivos inscritos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <!--
                                    <span class="label label-success float-right"></span>
                                    -->
                                    <h5>Apoyo</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ $event->members($club->id,[9,10])->count() }}</h1>
                                    <!--
                                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                                    -->
                                    <small>Lideres de apoyo inscritos</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Unidad</th>
                                    <th>Cargos</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($event->members($club->id)->get() as $member)
                                    <tr class="">
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->age() }}</td>
                                        <td>{{ ($member->unit)?$member->unit->name:'' }}</td>
                                        <td>
                                            @foreach($member->positions as $position)
                                                <span class="tag label label-primary">{{ strtoupper($position->name) }}</span>
                                            @endforeach
                                        </td>
                                        <td></td>
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