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
                <li class="breadcrumb-item">
                    <a>Clubes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Listar Clubes</strong>
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
                                    <th>Unidades</th>
                                    <th>Miembros</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clubes as $club)
                                <tr class="">
                                    <td>{{ $club->name }}</td>
                                    <td>{{ ($club->hasDirector())?$club->director->name:'Sin Director' }}</td>
                                    <td>{{ $club->zone->name }}</td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Director</th>
                                    <th>Zona</th>
                                    <th>Unidades</th>
                                    <th>Miembros</th>
                                </tr>
                                </tfoot>
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
      dom: '<"html5buttons"B>lTfgitp',
      buttons: [
        //{ extend: 'copy'},
        //{extend: 'csv'},
        //{extend: 'excel', title: 'ExampleFile'},
        //{extend: 'pdf', title: 'ExampleFile'},

        {extend: 'print',
          customize: function (win){
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');

            $(win.document.body).find('table')
              .addClass('compact')
              .css('font-size', 'inherit');
          }
        }
      ]

    });

  });

</script>
@endsection