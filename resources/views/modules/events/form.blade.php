@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ (isset($event)?'Modificar':'Crear') }} un evento</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Principal</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('events_list') }}">Eventos</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Nuevo evento</strong>
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
                        <h5>Ingrese los datos del nuevo evento</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @if(isset($event))
                        <form method="post" action="{{ route('event_update', $event->id) }}">
                        @else
                        <form method="post" action="{{ route('events_save') }}">
                        @endif



                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Nombre</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ isset($event)?$event->name:old('name') }}">
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Ingrese una breve descripción del evento" name="description">{{ isset($event)?$event->description:old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row" id="data_5">
                                <label class="col-sm-2 col-form-label">Duración</label>
                                <div class="col-sm-10">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon">&nbsp;desde &nbsp;&nbsp;</span>
                                        <input type="text" class="form-control-sm form-control" name="start" value="{{ isset($event)?\Carbon\Carbon::create($event->start)->format('m/d/Y'):old('start') }}" autocomplete="off">
                                        <span class="input-group-addon">&nbsp;hasta &nbsp;&nbsp;</span>
                                        <input type="text" class="form-control-sm form-control" name="end" value="{{ isset($event)?\Carbon\Carbon::create($event->end)->format('m/d/Y'):old('end') }}" autocomplete="off">
                                    </div>
                                    @if ($errors->has('end'))
                                        <div class="alert alert-danger">
                                            end
                                            {{ $errors->first('end') }}
                                        </div>
                                    @endif
                                    @if ($errors->has('start'))
                                        <div class="alert alert-danger">
                                            start
                                            {{ $errors->first('start') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group row" id="zones_select">
                                <label class="col-sm-2 col-form-label">Zona (s)</label>
                                <div class="col-sm-9">
                                    @if(Auth::user()->profile->level == 1)
                                        @include('partials.zones_select', ['zones'=> $zones])
                                    @elseif(Auth::user()->profile->level == 0)
                                        @include('partials.fields_select', ['fields'=> $fields])
                                    @endif
                                    @if ($errors->has('zone'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('zone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group row">
                                <div class="col-sm-6 col-sm-offset-2">
                                    {{ csrf_field() }}
                                    @if(isset($event))
                                    <input name="event_id" value="{{ $event->id }}" hidden />
                                    @endif
                                    <button class="btn btn-primary btn-lg pull-right" type="submit">Guardar</button>
                                </div>
                            </div>
                        </form>


                        @if(isset($event))
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Zonas asociadas</label>
                                <div class="col-sm-10">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Remover</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($event->zones as $zone)
                                                <tr class="">
                                                    <td>{{ $zone->name }}</td>
                                                    <td class="center">
                                                        <a class="remove_zone" data-id="{{ $zone->id }}" class="btn"><i class="fa fa-trash"></i>&nbsp;</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        @if(isset($event))
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Actividades del evento</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form role="form" class="">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <div class="form-group col-sm-5">
                                                <select class="select2_demo_3 form-control select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="activity_category">
                                                    <option>Selecciona una alternativa</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--
                                            <div class="form-group col-sm-1">
                                                <button class="btn btn-primary btn-outline" type="submit">Añadir</button>
                                            </div>
                                            -->
                                            <div class="form-group col-sm-7">
                                                <input type="text" name="activity_name" placeholder="Nombre de Actividad" class="form-control">
                                            </div>

                                            <div class="form-group col-sm-12">
                                                <button id="add-activity" class="btn btn-primary btn-block" type="button"> Agregar Actividad</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-7">
                                        <div class="row for_copy">
                                            <div class="form-group col-sm-5">
                                                <input name="items" placeholder="Item a Evaluar" class="form-control item">
                                            </div>
                                            <div class="form-group col-sm-5 pts_input">
                                                <input class="touchspin2 form-control points" type="text" value="5" style="display: block;">

                                            </div>
                                            <div class="form-group col-sm-2">
                                                <div class="btn-group">
                                                    &nbsp;
                                                    <button class="btn btn-primary btn-outline btn-plus" type="button"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Items</th>
                                <th>Remover</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr class="d-none activity_copy">
                                    <td data-name="activity_name"></td>
                                    <td class="center">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Puntos</th>
                                                <th>Remover</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="d-none item_copy">
                                                    <td data-name="item_name"></td>
                                                    <td data-name="item_points"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="center">
                                        <a class="remove_zone" data-id="" class="btn"><i class="fa fa-trash"></i>&nbsp;</a>
                                    </td>
                                </tr>
                                @foreach($event->activities as $activity)
                                <tr class="">
                                    <td data-name="activity_name">{{ $activity->name }}</td>
                                    <td class="center">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Puntos</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(json_decode($activity->evaluation_items) as $item)
                                            <tr>
                                                <td data-name="item_name">{{ $item->name }}</td>
                                                <td data-name="item_points">{{ $item->points }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="center">
                                        <a class="remove_activity" data-id="{{ $activity->id }}" class="btn"><i class="fa fa-trash"></i>&nbsp;</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        @endif
    </div>
@endsection


@section('scripts')
    <script>
      $(document).ready(function(){
        $('#data_5 .input-daterange').datepicker({
          keyboardNavigation: false,
          forceParse: false,
          autoclose: true,
          startDate: '+1d'
        });

        var touchspin_config = {
          min: 5,
          max: 1000,
          step: 5,
          boostat: 5,
          maxboostedstep: 10,
          postfix: 'pts.',
          buttondown_class: 'btn btn-white',
          buttonup_class: 'btn btn-white'
        };

        $(".touchspin2").TouchSpin(touchspin_config);

        $('.select2_demo_3').select2({
          placeholder : "Selecciona una alternativa",
          alowClear: true
        })


        $('.btn-plus').click(function () {
          var $forCopy = $(this).parents('.for_copy');
          var $cloned = $forCopy.clone();
          var $pts_input = $cloned.find('.pts_input > .bootstrap-touchspin');
          $cloned.find('input').val("");
          $pts_input.replaceWith('<input class="touchspin2 form-control" type="text" value="5" name="pts" style="display: block;">');
          var $buttons = $cloned.find('.btn-group')
          var $button = $buttons.find('button');
          var $icon = $button.find('i');
          $button.removeClass('btn-plus').addClass('btn-minus');
          $button.removeClass('btn-primary').addClass('btn-danger');
          $icon.removeClass('fa-plus').addClass('fa-minus');
          $cloned.appendTo($forCopy.parent())
          $(".touchspin2").TouchSpin(touchspin_config);
        });

        $(document).on('click','.btn-minus',function () {
          $(this).parent().parent().parent().remove()
        });

        $('#add-activity').click(function () {
          var event_id = $('input[name="event_id"]').val();

          var data = {
            activity_name : $('input[name="activity_name"]').val(),
            activity_category : $('select[name="activity_category"] option:selected').val(),
            items : getItems(),
            _token : $("input[name='_token']").val()
          };

          $.post('/eventos/'+event_id+'/add_activity', data, function (response) {
            if(response.error == false){
              buildActivityTable(response.data);
            }
          })

          //clearActivity();
        });


        @if(isset($event))
            $('.remove_zone').click(function () {
          var zone_id = $(this).data('id');
          var token = $("input[name='_token']").val();
          $element = $(this);

          $.post('{{ route('remove_zone', $event->id) }}', {zone: zone_id, _token: token }, function (response) {

            if (response.error){
              toastr.warning(response.message, 'Cuidado');
            }else {
              toastr.success(response.message, 'Excelente');
              $element.parent().parent().fadeOut(1000);
            }
          })
        })

        $('.remove_activity').click(function () {
          var activity_id = $(this).data('id');
          var event_id = $('input[name="event_id"]').val();
          var token = $("input[name='_token']").val();
          $element = $(this);

          $.post('/eventos/'+event_id+'/remove_activity', {activity: activity_id, _token: token }, function (response) {

            if (response.error){
              toastr.warning(response.message, 'Cuidado');
            }else {
              toastr.success(response.message, 'Excelente');
              $element.parent().parent().fadeOut(1000);
            }
          })
        })
        @endif


        function getItems() {
          var items = [];
          $('.item').each(function (index) {
            items[index] = {
              name: $(this).val(),
              points: $(this).parent().parent().find('.pts_input input').val()
            }
          })
          return items;
        }
        function clearActivity() {
          $('input[name="activity_name"]').val("");
          $('.for_copy input').val("");
          $('.pts_input input').val(5);

          clearClones();
        }
        function clearClones() {
          var count = $('.for_copy').length;

          for (var i =1; i < count; i++){
            $('.for_copy').last().remove();
          }
        }

        function buildActivityTable(data){
          var $cloned = $('.activity_copy').first().clone();
          $cloned.find('td[data-name="activity_name"]').html(data.name)
          $cloned.removeClass('d-none');
          $cloned.appendTo($('.activity_copy').parent())

          var items = $.parseJSON(data.evaluation_items);
          console.log(items)
          items.forEach(function (item) {
            buildItemTable(item)
          });
        }

        function buildItemTable(item) {
          //console.log(item);
          var $cloned = $('.item_copy').first().clone();
          $cloned.find('td[data-name="item_name"]').html(item.name);
          $cloned.find('td[data-name="item_points"]').html(item.points);
          $cloned.removeClass('d-none');
          $cloned.appendTo($('.item_copy').parent());
        }
      });

    </script>
@endsection

@section('style')
    <style>
        .select2-selection{height: 35px !important;}
    </style>
@endsection