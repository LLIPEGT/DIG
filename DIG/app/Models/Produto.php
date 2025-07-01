<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    public function marca(){
        return $this->belongsTo(Marca::class);
    }

     public function vendas(){
        return $this->belongsToMany(Venda::class, 'vendas_produtos');
    }

}
