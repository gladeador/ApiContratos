<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejecutivos extends Model
{
    use HasFactory;
    protected $table = 'ejecutivos';
    protected $fillable = [
        'id','nombre', 'apellido', 'descripcion', 'estado'
    ];
    public $timestamps=true;
}
