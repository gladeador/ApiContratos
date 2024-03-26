<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasAdicionalesContrato extends Model
{
    use HasFactory;
    protected $table = 'horas_adicionales_contrato';
    protected $fillable = ['horas_adicionales', 'fecha', 'observaciones', 'contrato_id'];
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

}
