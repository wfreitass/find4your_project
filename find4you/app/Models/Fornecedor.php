<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fornecedor extends Model
{

    /**
     *
     * @var string
     */
    protected $table = "fornecedores";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'cpf_cnpj',
        'email',
    ];

    /**
     *
     * @return HasMany
     * 
     */
    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class);
    }

    /**
     *
     * @return HasMany
     * 
     */
    public function telefones(): HasMany
    {
        return $this->hasMany(Telefone::class);
    }
}
