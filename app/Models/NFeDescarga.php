<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NFeDescarga extends Model
{
    protected $fillable = [
        'info_id', 'chave', 'seg_cod_barras'
    ];
}
