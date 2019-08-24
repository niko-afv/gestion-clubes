@if(isset($invoice))
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
                <div class="stream-badge payment-status-label">
                    <i class="fa fa-money {{ ($invoice->participation->isJustPaid())?'bg-primary':'bg-danger' }}"></i>
                </div>
                <div class="stream-panel">
                    Pago Realizado
                </div>
            </div>
            <div class="stream">
                <div class="stream-badge">
                    <i class="fa fa-check-square {{ ($invoice->participation->isFinished())?'bg-primary':'bg-danger' }}"></i>
                </div>
                <div class="stream-panel">
                    Pago Verificado
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <small>Faltan datos para mostrar información</small>
@endif