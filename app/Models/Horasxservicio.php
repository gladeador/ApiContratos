<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horasxservicio extends Model
{
    use HasFactory;
    protected $table = 'horas_servicio_x_ticket';
    protected $fillable = ['id', 'ticket_id', 'contrato_id', 'organizacion_id', 'idservicio', 'horas_ocupadas', 'created_at_ticket', 'updated_at_ticket'];
}