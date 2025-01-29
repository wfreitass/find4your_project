<?php

namespace App\Repositories;

use App\Interfaces\FornecedorRepositoryInterface;
use App\Models\Fornecedor;

class FornecedorRepository extends BaseRepository implements FornecedorRepositoryInterface
{
    /**
     *
     * @var Fornecedor
     */
    protected Fornecedor $fornecedor;

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
}
