<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/*
 * PaymentStatus enum
 */
class PaymentStatus extends Enum
{
    private const PENDING = 'PENDIENTE';
    private const PAYED = 'PAGADO';
    private const VERIFIED = 'VERIFICADO';

    /**
     * @return ParticipationStatus
     */
    public static function PENDING() {
        return new PaymentStatus(self::PENDING);
    }

    /**
     * @return ParticipationStatus
     */
    public static function PAYED() {
        return new PaymentStatus(self::PAYED);
    }

    /**
     * @return ParticipationStatus
     */
    public static function VERIFIED() {
        return new PaymentStatus(self::VERIFIED);
    }

}