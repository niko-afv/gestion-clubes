@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Lista de Usuarios</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>Usuarios</a>
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
                        <h5>Lista de todos los usuarios registrados para el campo</h5>
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
                                    <th>Email</th>
                                    <th>Club</th>
                                    <th>Perfil</th>
                                    <th>Cargo(s)</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($usuarios as $usuario)
                                <tr class="">
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ ($usuario->member->institutable instanceof \App\Club)?$usuario->member->institutable->name:'' }}</td>
                                    <td>{{ $usuario->profile->name }}</td>
                                    <td>
                                        @foreach($usuario->member->positions as $position)
                                            <span class="tag label label-primary">{{ strtoupper($position->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" {{ ($usuario->active)?'checked':'' }} class="onoffswitch-checkbox" id="usuario-{{ $usuario->id }}">
                                                <label class="onoffswitch-label" data-user="{{ $usuario->id }}" for="usuario-{{ $usuario->id }}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>


                                        <span class="label {{($usuario->active)?'label-primary':'label-danger'}}">{{ ($usuario->active)?'Activo':'Inactivo' }}</span>
                                    </td>
                                    <td></td>
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
    {{ csrf_field() }}
@endsection


@section('scripts')
<script>
  $(document).ready(function(){
    $('.dataTables-example').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp'
    });


    $('.onoffswitch-label').click(function () {
      var user = $(this).data('user');
      var token = $("input[name='_token']").val();

      $.post('/usuarios/'+user+'/toggle', {user: user, _token: token }, function (response) {
        if (response.isActived == 0){
          toastr.warning(response.message, 'Cuidado');
        }else {
          toastr.success(response.message, 'Excelente');
        }
      })
    });

  });

</script>
@endsection