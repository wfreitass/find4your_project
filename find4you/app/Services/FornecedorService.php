<?php

namespace App\Services;

use App\Interfaces\FornecedorRepositoryInterface;
use App\Interfaces\FornecedorServiceInterface;
use App\Models\Fornecedor;

class FornecedorService extends BaseService implements FornecedorServiceInterface
{
    /**
     *
     * @var Fornecedor
     */
    protected Fornecedor $fornecedor;


    public function __construct(FornecedorRepositoryInterface $fornecedor)
    {
        $this->fornecedor = $fornecedor;

        parent::__construct($fornecedor);
    }
}
