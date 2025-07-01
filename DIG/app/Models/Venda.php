<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function produtos(){
        return $this->belongsToMany(Produto::class, 'vendas_produtos');
    }
}
