<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'name', 'email', 'password','role_id','photo_id', 'is_active',
            'name'=>'required',
            'email' => ['required', 'email', 'unique:users,email,'.$this->route('users')],

        ];
    }
}
