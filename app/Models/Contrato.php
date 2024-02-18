<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $table = 'contratos';
    protected $fillable = [
        'id','organizacion_id', 'fecha_inicio', 'fecha_fin', 'descripcion', 'horas_servicio', 'monto_contrato', 'ejecutivo_id', 'estado_contrato'
    ];
    public $timestamps=true;
}
