@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Lista de Clubes</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>Clubes</a>
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
                        <h5>Lista de todos los clubes registrados para el campo</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Director</th>
                                    <th>Zona</th>
                                    <th>Status</th>
                                    <th>Ver Club</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clubes as $club)
                                <tr class="">
                                    <td>{{ $club->name }}</td>
                                    <td>{{ ($club->hasDirector())?$club->director->name:'Director no asociado' }}</td>
                                    <td>{{ $club->zone->name }}</td>
                                    <td><span class="label {{($club->active)?'label-primary':'label-danger'}}">{{ ($club->active)?'Activo':'Inactivo' }}</span></td>
                                    <td class="center">
                                        <button onclick="window.location.replace('{{ route('club_detail',['club'=>$club->id]) }}');" title="Ver Club" class="btn btn-primary" type="button"><i class="fa fa-eye"></i>&nbsp; Detalles</button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
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

  });

</script>
@endsection