<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;


class StoreFornecedorRequest extends FormRequest
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
            'nome' => 'required|max:255',
            'email' => 'required|unique:fornecedores|max:255',
            'cpf_cnpj' => 'required|unique:fornecedores|max:255',
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
            'nome.required' => 'nome é um campo obrigatório',
            'nome.max' => 'nome tem o tamanho máximo de 255',
            'email.required' => 'email é um campo obrigatório',
            'email.max' => 'email tem o tamanho máximo de 255',
            'email.email' => 'email inválido',
            'email.unique' => 'email já cadastrado',

            'cpf_cnpj.required' => 'cpf_cnpj é um campo obrigatório',
            'cpf_cnpj.max' => 'cpf_cnpj tem o tamanho máximo de 255',
            'cpf_cnpj.unique' => 'cpf_cnpj já cadastrado',

        ];
    }
}
