@extends('layouts.app')

@section('title', 'Lista de Eventos')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Lista de Eventos</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>Eventos</a>
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
                        <h5>Eventos registrados</h5>
                        @if(Auth::user()->profile->level < 3)
                            <div class="">
                                <p style="text-align: right">
                                    <a href="{{ route('events_create') }}" class="btn btn-outline btn-primary"><i class="fa fa-plus"></i>&nbsp;Nuevo Evento</a>
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Comienza</th>
                                    <th>Termina</th>
                                    <th>Zona</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                <tr class="">
                                    <td>{{ $event->name }}</td>
                                    <td>{{ \Carbon\Carbon::create($event->start)->format('d-M-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::create($event->end)->format('d-M-Y') }}</td>
                                    <td>
                                        @foreach($event->zones as $zone)
                                            <span class="tag label label-primary">{{ strtoupper($zone->name) }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if(Auth::user()->profile->level < 3)
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" {{ ($event->active)?'checked':'' }} class="onoffswitch-checkbox" id="event-{{ $event->id }}">
                                                <label class="onoffswitch-label" data-event="{{ $event->id }}" for="event-{{ $event->id }}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        @else
                                            <dd class="mb-1"><span class="label {{($event->active)?'label-primary':'label-danger'}}">{{ ($event->active)?'Activo':'Inactivo' }}</span></dd>
                                        @endif

                                    </td>
                                    <td class="center">
                                        <button onclick="window.location.replace('{{ route('event_detail',['event'=>$event->id]) }}');" title="Ver Evento" class="btn btn-primary" type="button"><i class="fa fa-eye"></i>&nbsp;</button>
                                        @if(Auth::user()->profile->level < 3)
                                        <button onclick="window.location.replace('{{ route('event_edit',['event'=>$event->id]) }}');" title="Modificar Evento" class="btn btn-primary" type="button"><i class="fa fa-edit"></i>&nbsp;</button>
                                        @endif
                                        @if(Auth::user()->profile->id == 6)
                                            <!-- TODO   add isAdmin() verificator -->
                                            <button data-url="{{ route('event_sync',['event'=>$event->id]) }}" title="Sincronizar Evento" class="btn btn-primary event_sync" type="button"><i class="fa fa-repeat"></i>&nbsp; </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ csrf_field() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>
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

    $('.event_sync').click(function () {
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

    $('.onoffswitch-label').click(function () {
      var event = $(this).data('event');
      var token = $("input[name='_token']").val();

      $.post('/eventos/'+event+'/toggle', {event: event, _token: token }, function (response) {
        if (response.isActived == 0){
          toastr.warning(response.message, 'Cuidado');
        }else {
          toastr.success(response.message, 'Excelente');
        }
      })
    });

    $('.dataTables-example').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"html5buttons"B>lTfgitp'
    });

  });

</script>
@endsection