<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horasxcontrato extends Model
{
    use HasFactory;
    protected $table = 'horas_contrato_x_ticket';
    protected $fillable = ['id', 'ticket_id', 'contrato_id', 'organizacion_id', 'horas_ocupadas', 'created_at_ticket', 'updated_at_ticket'];
}
