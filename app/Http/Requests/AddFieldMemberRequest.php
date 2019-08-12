<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddFieldMemberRequest extends AsRegionalRequest
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
