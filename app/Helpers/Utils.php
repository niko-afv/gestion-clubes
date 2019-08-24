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
        $paid_amount = $invoice->payments->sum('amount');
        return ($paid_amount >= $total)?true:false;
    }

    function checkVerifiedPayment($invoice){
        $total = $invoice->total;
        $paid_amount = $invoice->payments()->where('verified',1)->get()->sum('amount');
        return ($paid_amount >= $total)?true:false;
    }

    function asMoney($value){
        return '$' . number_format($value, 0,'.',',');
    }

    function getUnits($snapshot){
        $units_list = [];
        $units = __getUnits($snapshot);
        if ($units){
            foreach ($units as $unit){
                $units_list[] = $unit->id;
            }
        }
        return $units_list;
    }
    function getMembers($snapshot){
        $members_list = [];
        $members = __getMembers($snapshot);
        if ($members){
            foreach ($members as $member){
                $members_list[] = $member->id;
            }
        }
        return $members_list;
    }
    function __getMembers($snapshot){
        $snapshot = \GuzzleHttp\json_decode($snapshot);
        if ($snapshot->members) {
            return $snapshot->members;
        }
        return [];
    }
    function __getUnits($snapshot){
        $snapshot = \GuzzleHttp\json_decode($snapshot);
        if ($snapshot->units){
            return $snapshot->units;
        }
        return false;
    }
    function getMembersFromUnits($units){
        $members = [];
        if ($units){
            foreach ($units as $unit){
                $unit_members = $unit->members;
                foreach ($unit_members as $member){
                    $members[] = $member;
                }
            }
        }
        return $members;
    }
    function getAllMembers($snapshot){
        $members = __getMembers($snapshot);
        $unit_members = getMembersFromUnits(__getUnits($snapshot));
        return array_merge($members, $unit_members);
    }
    function getRegistrations($event, $club){
        $participant =$event->participants()->where('eventable_id', $club->id)->where('eventable_type', 'App\Club')->whereNotNull('snapshot');
        $snapshot = $participant->first()->snapshot;
        $members = collect(getAllMembers($snapshot));

        $grouped = $members->mapToGroups(function ($item, $key) use ($event){
            $preference_registrations = $event->registrations()->preference();
            $positions = $item->positions;
            foreach ($positions as $position){
                $registration_position = $preference_registrations->where('position_id', $position->id)->first();
                if($registration_position){
                    return [$position->id => $item->name];
                }
            }
            return [0 => $item->name];
        });

        $grouped_with_price = collect();
        foreach ($event->registrations as $registration){
            foreach ($grouped as $key => $participants) {
                if ($registration->type == 2) {
                    if ($registration->position->id == $key) {
                        $grouped_with_price[$key] = collect([
                            'price' => $registration->price,
                            'count' => $participants->count(),
                            'subtotal' => ($registration->price * $participants->count()),
                            'description' => Position::find($key)->name
                        ]);
                    }
                } else {
                    $grouped_with_price[$key] = collect([
                        'price' => $registration->price,
                        'count' => $participants->count(),
                        'subtotal' => ($registration->price * $participants->count()),
                        'description' => 'General'
                    ]);
                }
            }
        }

        return collect([
            'total' => $grouped_with_price->sum('subtotal'),
            'items' => $grouped_with_price
        ]);
    }