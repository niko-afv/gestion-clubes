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
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Estado de la inscripción</h5>
                </div>
                <div class="ibox-content">
                    <div class="activity-stream">
                        <div class="stream">
                            <div class="stream-badge">
                                <i class="fa fa-list bg-primary"></i>
                            </div>
                            <div class="stream-panel">
                                Inscripción completada
                            </div>
                        </div>
                        <div class="stream">
                            <div class="stream-badge">
                                <i class="fa fa-money {{ ($participation_status >= 2)?'bg-primary':'bg-danger' }}"></i>
                            </div>
                            <div class="stream-panel">
                                Pago Realizado
                            </div>
                        </div>
                        <div class="stream">
                            <div class="stream-badge">
                                <i class="fa fa-check-square {{ ($participation_status >= 3)?'bg-primary':'bg-danger' }}"></i>
                            </div>
                            <div class="stream-panel">
                                Pago Verificado
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    @include('partials.status_label',['data'=>participationStatusAsLabel($club->paymentStatus($event->id)), 'classes' => 'float-right'])

                    <h5>Total a pagar</h5>
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

                    <h1 class="no-margins">${{ number_format($total,0,'.',',') }}</h1>
                    <div class="stat-percent font-bold text-success">
                        <button onclick="window.location.replace('{{ route('invoice_payment', $participation->invoice->id) }}');" title="Ver Evento" class="btn btn-xs btn-primary" type="button">
                            <i class="fa fa-dollar"></i>&nbsp;{{ ($participation_status <2)?'Registrar Pago':'Ver Pagos' }}
                        </button>
                    </div>
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
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


                @can('crud-events')
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
                @endcan

            </div>
        </div>
    </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Proporción de Participación</h5>

                </div>
                <div class="ibox-content">
                    <div>
                        <div class="d-none">
                            <input name="participate" value="{{ $members_participate }}">
                            <input name="no-participate" value="{{ $members_no_participate }}">
                        </div>
                        <canvas id="doughnutChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        &nbsp;
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


        var participate = $("input[name='participate']").val();
        var noParticipate = $("input[name='no-participate']").val();

        var doughnutData = {
          labels: ["Miembros que no participan","Participantes"],
          datasets: [{
            data: [noParticipate, participate],
            backgroundColor: ["#E76A7A", "#7FCFCA"]
          }]
        };

        var doughnutOptions = {
          responsive: true
        };

        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});
      });

    </script>
@endsection