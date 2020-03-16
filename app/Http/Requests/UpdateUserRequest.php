<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends FormRequest
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


    protected function failedValidation(Validator $validator) {
         throw new HttpResponseException(response($validator->errors(), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'alpha_num', 'unique:users,name,'.$this->user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'oldPassword' => ['nullable', 'required_with:newPassword', function ($attribute, $value, $fail) {
                if (! Hash::check($value, $this->user->password)) {
                    return $fail(trans('auth.user_settings.old_password_incorrect'));
                }

                return true;
            }],
            'newPassword' => ['nullable', 'required_with:oldPassword', 'string', 'min:8', 'max:50'],
            'confirmNewPassword' => ['nullable', 'required_with:newPassword', 'same:newPassword'],
        ];
    }
}
