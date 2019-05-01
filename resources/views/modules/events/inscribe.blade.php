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
                <li class="breadcrumb-item">
                    <a href="{{ route('event_detail', ['event' => $event->id]) }}">{{ $event->name }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Inscribir</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Mis Unidades </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre de Unidad</th>
                            <th>Miembros</th>
                            <th>Inscribir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($club->units as $unit)
                        <tr>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->members->count() }}</td>
                            <td>
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" {{ ($unit->participate())?'checked':'' }} class="onoffswitch-checkbox" id="unit-{{ $unit->id }}">
                                        <label class="onoffswitch-label" data-type="unit" data-id="{{ $unit->id }}" for="unit-{{ $unit->id }}">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Directiva / Apoyo </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Inscribir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($club->directive as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->positions()->first()->name }}</td>
                                <td>
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" {{ ($member->participate())?'checked':'' }} class="onoffswitch-checkbox" id="member-{{ $member->id }}">
                                            <label class="onoffswitch-label" data-type="member" data-id="{{ $member->id }}" for="member-{{ $member->id }}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @foreach($club->supportTeam as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->positions()->first()->name }}</td>
                                <td>
                                    <div class="switch">
                                        <div class="onoffswitch">
                                            <input type="checkbox" {{ ($member->participate())?'checked':'' }} class="onoffswitch-checkbox" id="member-{{ $member->id }}">
                                            <label class="onoffswitch-label" data-type="member" data-id="{{ $member->id }}" for="member-{{ $member->id }}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
    <input hidden name="event" value="{{ $event->id }}">
@endsection


@section('scripts')
    <script>
      $(document).ready(function(){
        $('.onoffswitch-label').click(function () {
          $element = $(this);
          var id = $(this).data('id');
          var type = $(this).data('type');
          var event = $('input[name="event"]').val();
          var token = $("input[name='_token']").val();
          var checked = $element.parent().children('input').attr('checked');
          var url = '/eventos/'+event+'/';

          if( checked == undefined){
            url += 'inscribir';
          }else{
            url += 'desincribir';
          }

          $.post(url, {id: id, type: type, _token: token }, function (response) {
            if (response.participate == 0){
              toastr.warning(response.message, 'Cuidado');
              $element.parent().children('input').removeAttr('checked');
            }else {
              $element.parent().children('input').attr('checked','checked');
              toastr.success(response.message, 'Excelente');
            }
          })
        });
      });
    </script>
@endsection