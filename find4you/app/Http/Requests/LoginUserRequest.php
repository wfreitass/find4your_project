<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class LoginUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required|min:3",

        ];
    }


    /**
     * @param Validator $validator
     */
    public function after(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422));
        }
        return function () {};
    }

    public function messages(): array
    {
        return [

            'password.required' => 'senha é um campo obrigatório',
            'password.min' => 'senha tem o tamanho mínimo de :min',

            'email.required' => 'email é um campo obrigatório',
            'email.email' => 'Insira um email válido ',
        ];
    }
}
