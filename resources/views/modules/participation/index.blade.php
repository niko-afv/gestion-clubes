@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content">

        <div class="row">
            <div class="col-lg-4">
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
                                    <i class="fa fa-money bg-danger"></i>
                                </div>
                                <div class="stream-panel">
                                    Pago Realizado
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-check-square bg-danger"></i>
                                </div>
                                <div class="stream-panel">
                                    Pago Verificado
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-danger float-right">Pendiente</span>
                        <h5>Total a pagar</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">${{ number_format($total,0,'.',',') }}</h1>
                        <div class="stat-percent font-bold text-success">
                            <button disabled="" onclick="" title="Ver Evento" class="btn btn-xs btn-primary" type="button"><i class="fa fa-dollar"></i>&nbsp;Registrar Pago</button>
                        </div>
                        <small>{{ $members_participate }} Participantes</small>
                    </div>
                </div>
            </div>
<!--
        </div>
        <div class="row">
-->

            <div class="col-lg-6">
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

        @if (session('error_message'))
            <span id="error_message">{{ session('error_message') }}</span>
    @endif
    </div>

@endsection


@section('scripts')
    <script>
      $(document).ready(function(){
        if( $('#error_message').length )
          toastr.warning($('#error_message').html(), 'Cuidado');

        var participate = $("input[name='participate']").val();
        var noParticipate = $("input[name='no-participate']").val();

        var doughnutData = {
          labels: ["Miembros que no participan","Participantes"],
          datasets: [{
            data: [noParticipate, participate],
            backgroundColor: ["#E76A7A", "#7FCFCA"]
          }]
        } ;

        var doughnutOptions = {
          responsive: true
        };

        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});
      });
    </script>
@endsection
