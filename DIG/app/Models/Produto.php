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

    public function vendas() {
        return $this->belongsToMany(Venda::class, 'vendas_produtos', 'produto_id', 'venda_id')
                    ->withPivot('quantidade_retirado', 'valor_total_item')
                    ->withTimestamps()
                    ->withSoftDeletes();
    }

    public function dispenser()
    {
        return $this->hasOne(\App\Models\Dispenser::class);
    }


}
