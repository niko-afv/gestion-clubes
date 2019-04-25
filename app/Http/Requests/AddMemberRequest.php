<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddMemberRequest extends MyClubRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'birthdate' => 'required|date',
            'phone' => 'required',
            'email' => 'email|nullable',
            'dni' => 'required'
        ];
    }
}
