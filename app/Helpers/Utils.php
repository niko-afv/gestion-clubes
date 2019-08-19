<?php

    function participationStatusAsLabel($status)
    {
        switch ($status){
            case \App\Enums\ParticipationStatus::INCOMPLETED_INSCRIPTION():
                $type = 'danger';
                break;
            case \App\Enums\ParticipationStatus::COMPLETED_INSCRIPTION():
                $type = 'primary';
                break;
            case \App\Enums\PaymentStatus::PENDING():
                $type = 'danger';
                break;
            case \App\Enums\PaymentStatus::PAYED():
                $type = 'warning';
                break;
            case \App\Enums\PaymentStatus::VERIFIED():
                $type = 'primary';
                break;
        }

        return ['type'=> $type, 'status' => $status];
    }

    function checkPayment($invoice){
        $total = $invoice->total;
        $payed = $invoice->payments->sum('amount');
        return ($payed >= $total)?true:false;
    }