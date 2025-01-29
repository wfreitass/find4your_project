<?php

namespace App\Repositories;

use App\Interfaces\FornecedorRepositoryInterface;
use App\Models\Fornecedor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FornecedorRepository extends BaseRepository implements FornecedorRepositoryInterface
{
    /**
     *
     * @var Fornecedor
     */
    protected  $fornecedor;

    /**
     *
     * @param Fornecedor $fornecedor
     * 
     */
    public function __construct(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
        parent::__construct($fornecedor);
    }

    public function all()
    {
        return  $fornecedores = Cache::remember('fornecedores', now()->addMinutes(10), function () {
            return $this->fornecedor->with(['telefones', 'enderecos'])->get();
        });
    }

    public function create(array $data)
    {

        DB::beginTransaction();

        try {
            $fornecedor =  $this->fornecedor->create($data);

            if (!empty($data['contatos'])) {
                $fornecedor->telefones()->createMany($data['contatos']);
            }

            if (!empty($data['enderecos'])) {
                $fornecedor->enderecos()->createMany($data['enderecos']);
            }

            DB::commit();
            Cache::forget('fornecedores');
            return $fornecedor;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            // dd($th->getMessage());
            // return false;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $fornecedor = $this->fornecedor->findOrFail($id);
            $fornecedor->update($data);

            if (!empty($data['contatos'])) {
                $fornecedor->telefones()->delete();
                $fornecedor->telefones()->createMany($data['contatos']);
            }

            if (!empty($data['enderecos'])) {
                $fornecedor->enderecos()->delete();
                $fornecedor->enderecos()->createMany($data['enderecos']);
            }

            DB::commit();

            return $fornecedor;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            dd($th->getMessage());
            return false;
        }
    }
}
