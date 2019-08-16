<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/*
 * ProfileLevel enum
 */
class ProfileLevel extends Enum
{
    private const ADMINISTRATOR = -1;
    private const UNION_LEADER = 0;
    private const FIELD_LEADER = 1;
    private const ZONE_LEADER = 2;
    private const CLUB_LEADER = 3;

    /**
     * @return ProfileLevel
     */
    public static function ADMINISTRATOR() {
        return new ProfileLevel(self::ADMINISTRATOR);
    }

    /**
     * @return ProfileLevel
     */
    public static function CLUB_LEADER() {
        return new ProfileLevel(self::CLUB_LEADER);
    }

    /**
     * @return ProfileLevel
     */
    public static function ZONE_LEADER() {
        return new ProfileLevel(self::ZONE_LEADER);
    }

    /**
     * @return ProfileLevel
     */
    public static function FIELD_LEADER() {
        return new ProfileLevel(self::FIELD_LEADER);
    }

    /**
     * @return ProfileLevel
     */
    public static function UNION_LEADER() {
        return new ProfileLevel(self::UNION_LEADER);
    }

}