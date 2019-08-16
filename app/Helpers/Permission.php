<?php

    function hasProfile(\App\Enums\ProfileLevel $profileLevel, \App\User $user)
    {
        return ($user->profile->level == $profileLevel->getValue())?true: false;
    }

    function isAdmin(\App\User $user)
    {
        return hasProfile(\App\Enums\ProfileLevel::ADMINISTRATOR(), $user);
    }

    function isClubLeader(\App\User $user)
    {
        return hasProfile(\App\Enums\ProfileLevel::CLUB_LEADER(), $user);
    }

    function isZoneLeader(\App\User $user)
    {
        return hasProfile(\App\Enums\ProfileLevel::ZONE_LEADER(), $user);
    }

    function isFieldLeader(\App\User $user)
    {
        return hasProfile(\App\Enums\ProfileLevel::FIELD_LEADER(), $user);
    }

    function isUnionLeader(\App\User $user)
    {
        return hasProfile(\App\Enums\ProfileLevel::UNION_LEADER(), $user);
    }
