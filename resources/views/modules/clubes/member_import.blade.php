@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Importar Miembros</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('my_club') }}">Mi Club</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Importar Miembros</strong>
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
                        <h5>Selecciones el Archivo para importar</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                            <div class="form-group  row">
                                <div class="col-sm-12 col-sm-offset-2">
                                <form action="{{ route('upload_members') }}"
                                      class="dropzone"
                                      id="my-awesome-dropzone"></form>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                            <tr>
                                                <th>CODIGO_SGC</th>
                                                <th>RUT</th>
                                                <th>NOMBRE</th>
                                                <th>EMAIL</th>
                                                <th>TELEFONO</th>
                                                <th>FECHA_NACIMIENTO</th>
                                                <th>CARGO</th>
                                                <!--
                                                <th>DESCARTAR</th>
                                                -->
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-7 col-lg-7 col-sm-offset-2">
                                {{ csrf_field() }}
                                <button class="btn btn-primary btn-lg pull-right" data-url="{{ route('import_save_members') }}" type="submit" disabled>IMPORTAR</button>
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
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        dictDefaultMessage: "<strong>Puedes arrastrar los archivos a este espacio... </strong></br> o tambien hacer click",
        sending: function (file,xhr, data) {
          var token = $("input[name='_token']").val();
          data.append("_token", token);
        },
        success: function (file, response) {
            if (response.error == false){
                $('button[type="submit"]').removeAttr('disabled');
              $('button[type="submit"]').attr('data-file', response.file_path);

                response.data.forEach(function(item, index){
                var markup = "<tr id='record-"+ index +"'>" +
                  "<td>" + item.codigo_sgc +"</td>" +
                  "<td>" + item.nombre +"</td>" +
                  "<td>" + item.rut +"</td>" +
                  "<td>" + item.email +"</td>" +
                  "<td>" + item.telefono +"</td>" +
                  "<td>" + item.fecha_nacimiento +"</td>" +
                  "<td>" + item.cargo +"</td>" +
                  //"<td><a style='color: #ED5565;' data-index='"+ index +"' class='btn btn-outline btn-link delete_record' title='Eliminar'><i class='fa fa-trash-o'></i></a></td>" +
                  "</tr>";
                $("table tbody").append(markup);
      })
            }
        }
    };

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


        $(document).on('click','button',function (event) {
          event.preventDefault();
          var file_path = $(this).data('file');
          var token = $("input[name='_token']").val();
          var url = $(this).data('url');
          $element = $(this);

          $.post(url, {file_path: file_path, _token: token }, function (response) {
            if (response.error){
              toastr.warning(response.message, 'Cuidado');
            }else {
              toastr.success(response.message, 'Excelente');
              $element.parent().parent().fadeOut(1000);
              setTimeout(function(){
                window.location.replace("{{ route('my_club') }}");
              }, 2500)
            }
          })
        })

        $('table').on('click','.delete_record',function () {
          var index = $(this).data('index');
          $('tr#record-'+index).fadeOut(500);
        })
      });

    </script>
@endsection