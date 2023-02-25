<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = [
        'id',
        'numeroCPF',
        'nomeCliente',
        'dataNascimento',
        'sexoCliente',
        'nomeRua',
        'estado_id',
        'cidade_id',
    ];
}
