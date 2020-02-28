<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Reply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'name' => ['nullable','sometimes', 'string', 'max:255', 'unique:users'],
            'email' => ['nullable', 'sometimes', 'string', 'email', 'max:255', 'unique:users'],
            'oldPassword' => ['nullable', 'sometimes','required_with:newPassword', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The old password is incorrect.'));
                }
            }],
            'newPassword' => ['nullable', 'sometimes','required_with:oldPassword','string','min:8'],
            'confirmNewPassword' => ['nullable', 'sometimes','required_with:newPassword,', 'same:newPassword'],
        ];
    }


}
