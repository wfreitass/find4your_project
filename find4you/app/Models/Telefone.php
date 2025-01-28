<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dd',
        'fornecedor_id',
        'telefone',
    ];
}
