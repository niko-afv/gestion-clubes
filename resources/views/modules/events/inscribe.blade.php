@extends('layouts.app')

@section('title', 'Lista de Clubes')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
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
        <div class="col-lg-4">
            &nbsp;
            &nbsp;
            <a href="{{ route('finish_registration',$event->id) }}" class="btn btn-block btn-lg btn-dark finish d-none" style="color: #fff;">COMPLETAR INSCRIPCIÓN</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Detalle de Pago </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive m-t">
                        <table class="table invoice-table">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($participants->has('items'))
                                <tr class="for_copy d-none">
                                    <td>
                                        <div class="registration-description"><strong></strong></div>
                                        <small class="registration-text"></small>
                                    </td>
                                    <td class="registration-count"></td>
                                    <td class="registration-price"></td>
                                    <td class="registration-subtotal"></td>
                                </tr>
                                @foreach($participants->get('items') as $key => $registration)
                                <tr class="item-{{ $key }}">
                                    <td>
                                        <div class="registration-description"><strong>Inscripción {{ $registration['description'] }}</strong></div>
                                        <small class="registration-text">Valor {{ ($key == 0)?'General':'Preferencial' }}</small>
                                    </td>
                                    <td class="registration-count">{{ $registration['count'] }}</td>
                                    <td class="registration-price">$ {{ number_format($registration['price'],0,'.',',') }}</td>
                                    <td class="registration-subtotal">$ {{ number_format( ($registration['subtotal']),0,'.',',') }}</td>
                                </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <table class="table invoice-total">
                        <tbody>
                        <tr>
                            <td><strong>Sub Total :</strong></td>
                            <td class="registration-total">${{ number_format($participants->get('total'),0,'.',',') }}</td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL :</strong></td>
                            <td class="registration-total">${{ number_format($participants->get('total'),0,'.',',') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Inscribir Unidades </h5>
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
                                        <input type="checkbox" {{ ($unit->participate($event->id))?'checked':'' }} class="onoffswitch-checkbox" id="unit-{{ $unit->id }}">
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
                    <h5>Inscribir Directiva / Apoyo </h5>
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
                                            <input type="checkbox" {{ ($member->participate($event->id))?'checked':'' }} class="onoffswitch-checkbox" id="member-{{ $member->id }}">
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
                                            <input type="checkbox" {{ ($member->participate($event->id))?'checked':'' }} class="onoffswitch-checkbox" id="member-{{ $member->id }}">
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
    <input hidden name="club" value="{{ $club->id }}">
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
              updatePaymentDetail(response.participants);
            }else {
              $element.parent().children('input').attr('checked','checked');
              toastr.success(response.message, 'Excelente');
              updatePaymentDetail(response.participants);
            }
          })
        });

        function updatePaymentDetail(participants) {
          clearPaymentDetail();
          addRows(participants);
          updateTotal(participants.total);
        }

        function addRows(participants) {
          for (item in participants.items){
            var group = participants.items[item];
            $tr = $('.item-'+item);
            if($tr.length > 0){
              addRow($tr, group)
            }else{
              var $table = $('.invoice-table');
              var $cloned = $table.find('tr.for_copy').clone();
              addRow($cloned, group)
              var _class = $cloned.attr('class');
              $cloned.removeClass(_class);
              $cloned.addClass('item-'+item);
              $cloned.appendTo($table);
            }
          }
        }

        function clearPaymentDetail() {
          $("tr[class^='item-']").remove();
        }
        function addRow($element, item) {
          $element.find('.registration-description').html('<strong>Inscripción '+ item.description + '</strong>');
          $element.find('.registration-count').html(item.count);
          var description = (item.description == 'General')? 'General': 'Preferencial';
          $element.find('.registration-text').html("Valor " + description);
          $element.find('.registration-price').html('$ '+item.price);
          $element.find('.registration-subtotal').html('$ '+item.subtotal);
        }
        function updateTotal(total) {
          $('.registration-total').html(total);
        }


        $('.finish').click(function (e) {
          e.preventDefault();
          swal({
            title: "¿Estas seguro?",
            text: "Estas a punto de completar y cerrar la inscripción de tu Club para este evento!. Esto generará la orden de pago.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, quiero completar!",
            closeOnConfirm: false,
            closeOnEsc: false,
          }, function (confirmation) {
            if (confirmation){
                var event = $('input[name="event"]').val();
                var club = $('input[name="club"]').val();
                var url = '/eventos/' + event + '/completar';
                var token = $("input[name='_token']").val();
                $.post(url, {
                  confirmation: confirmation,
                  _token: token,
                  event: event,
                  club: club
                }, function (response) {
                    if(response.error == false){
                        swal("Felicidades!", "Tu club ya está nscrito en este evento.", "success");
                        setTimeout(function(){
                            window.location.replace("{{ route('participation_event_list',[$event, $club]) }}");
                        }, 2500)
                 }else{
                    alert("hubo un problema");
                    }
                 })

            }

          });
        });
      });
    </script>
@endsection