<?php

namespace App\Services;

use App\Enums\BrasilApiEnum;
use App\Interfaces\BuscaCnpjServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BuscaCnpjService  implements BuscaCnpjServiceInterface
{
    public function buscaCnpj($cnpj)
    {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            return ['error' => 'CNPJ inválido'];
        }

        try {
            $response = Http::get(BrasilApiEnum::CNPJ_URL->value . $cnpj);

            if ($response->failed()) {
                return ['error' => 'CNPJ não encontrado'];
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ['error' => 'Erro ao buscar CNPJ'];
        }
    }
}
