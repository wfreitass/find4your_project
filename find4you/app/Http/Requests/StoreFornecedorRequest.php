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
            'cpf_cnpj' => ['required', 'string', 'max:18', function ($attribute, $value, $fail) {
                if (!$this->validaCpfCnpj($value)) {
                    $fail('O campo CPF/CNPJ não é válido.');
                }
            }],
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

    private function validaCpfCnpj($value): bool
    {
        $cpfCnpj = preg_replace('/\D/', '', $value);

        if (strlen($cpfCnpj) === 11) {
            return $this->validaCpf($cpfCnpj);
        } elseif (strlen($cpfCnpj) === 14) {
            return $this->validaCnpj($cpfCnpj);
        }

        return false;
    }

    private function validaCpf($cpf): bool
    {
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    private function validaCnpj($cnpj): bool
    {
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }

        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        if ($resultado != $digitos[0]) {
            return false;
        }

        $tamanho += 1;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }

        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        return $resultado == $digitos[1];
    }
}
