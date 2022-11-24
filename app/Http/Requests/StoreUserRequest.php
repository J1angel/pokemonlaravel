<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users,username|regex:/^([a-z])+?(-|_)([a-z])+$/i|',
            'first_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'required|date',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'username.regex' => 'username should contain only one word.',
            'username.unique' => 'Cannot use username.'
        ];
    }
}
