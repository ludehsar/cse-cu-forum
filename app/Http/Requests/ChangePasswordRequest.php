<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('old_password')  && !Hash::check($this->old_password, Auth::user()->password)) {
                $validator->errors()->add('old_password', 'Password is not correct');
            }

            if ($this->has('new_password')  && $this->has('password_confirmation') && $this->new_password !== $this->password_confirmation) {
                $validator->errors()->add('new_password', 'Passwords did not match');
                $validator->errors()->add('password_confirmation', 'Passwords did not match');
            }
        });
    }
}
