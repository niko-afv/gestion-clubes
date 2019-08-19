<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/*
 * ParticipationStatus enum
 */
class ParticipationStatus extends Enum
{
    private const INCOMPLETED_INSCRIPTION = 'INCOMPLETA';
    private const COMPLETED_INSCRIPTION = 'CONFIRMADA';


    /**
     * @return ParticipationStatus
     */
    public static function INCOMPLETED_INSCRIPTION() {
        return new ParticipationStatus(self::INCOMPLETED_INSCRIPTION);
    }

    /**
     * @return ParticipationStatus
     */
    public static function COMPLETED_INSCRIPTION() {
        return new ParticipationStatus(self::COMPLETED_INSCRIPTION);
    }

    /**
     * @return ParticipationStatus
     */
    public static function PAYED() {
        return new ParticipationStatus(self::PAYED);
    }

    /**
     * @return ParticipationStatus
     */
    public static function VERIFIED_PAY() {
        return new ParticipationStatus(self::VERIFIED_PAY);
    }

}