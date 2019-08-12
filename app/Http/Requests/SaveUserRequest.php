<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends AsRegionalRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:5|max:30|alpha_num',
            'password_confirmation' => 'required',
            'profile' => 'required|exists:profiles,id'
        ];
    }
}
