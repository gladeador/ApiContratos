<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasAdicionalesServicios extends Model
{
    use HasFactory;
    protected $table = 'horas_adicionales_servicio';
    protected $fillable = ['horas_adicionales', 'fecha', 'observaciones', 'servicio_id'];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

}
