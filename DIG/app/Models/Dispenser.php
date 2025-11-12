<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispenser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'produto_id',
        'status',
        'codigo_micro',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function dispenserAcao()
    {
        return $this->hasMany(DispenserAcao::class);
    }
}
