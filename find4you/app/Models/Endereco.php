<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cep',
        'fornecedor_id',
        'estado',
        'cidade',
        'bairro',
        'numero',
        'logradouro',
    ];
}
