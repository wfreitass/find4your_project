<?php

namespace App\Services;

use App\Interfaces\FornecedorRepositoryInterface;
use App\Interfaces\FornecedorServiceInterface;
use App\Models\Fornecedor;

class FornecedorService extends BaseService implements FornecedorServiceInterface
{
    /**
     *
     * @var FornecedorRepositoryInterface
     */
    protected FornecedorRepositoryInterface $fornecedor;


    public function __construct(FornecedorRepositoryInterface $fornecedor)
    {
        $this->fornecedor = $fornecedor;

        parent::__construct($fornecedor);
    }
}
