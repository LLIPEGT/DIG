<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispenserAcao extends Model
{
    use HasFactory;

    protected $table = 'dispenser_acao';

    protected $fillable = [
        'venda_id',
        'dispenser_id',
        'quantidade_liberada',
        'status_acao',
        'executada_em',
    ];

    public $timestamps = true;

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function dispenser()
    {
        return $this->belongsTo(Dispenser::class);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status_acao', $status);
    }
}
