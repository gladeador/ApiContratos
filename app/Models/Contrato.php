<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $table = 'contratos';
    protected $fillable = [
        'id',
        'organizacion_id',
        'organizacion_name',
        'fecha_inicio',
        'fecha_fin',
        'contrato_o_servicio',
        'tipo_horas',
        'descripcion',
        'horas_contrato',
        'horas_adicionales',
        'horas_ocupadas',
        'contrato_texto',
        'pdf_path',
        'renovacion_automatica',
        'ejecutivo_id',
        'estado_contrato'
    ];
    public $timestamps = true;
}
