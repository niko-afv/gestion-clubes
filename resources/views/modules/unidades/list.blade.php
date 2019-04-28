@extends('layouts.app')

@section('title', 'Lista de Unidades')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Lista de Unidades</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>Unidades</a>
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
                        <h5>Lista de todos los unidades registrados para el campo</h5>
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
                                    <th>Miembros</th>
                                    <th>Club</th>
                                    <th>Zona</th>
                                    <th>Código</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($unidades as $unidad)
                                <tr class="">
                                    <td>{{ $unidad->name }}</td>
                                    <td>{{ $unidad->members->count() }}</td>
                                    <td>{{ $unidad->club->name }}</td>
                                    <td>{{ $unidad->club->zone->name }}</td>
                                    <td>{{ $unidad->code }}</td>
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