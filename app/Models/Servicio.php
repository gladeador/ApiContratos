<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    protected $fillable = [
        'id',
        'servicio_tree_select',
        'fecha_inicio',
        'fecha_fin',
        'tipo_horas',
        'horas_servicio',
        'horas_ocupadas',
        'contrato_texto',
        'pdf_path',
        'renovacion_automatica',
        'contrato_id',
        'estado_servicio'
    ];
    public $timestamps = true;
}
