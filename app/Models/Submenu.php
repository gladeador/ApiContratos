<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;
    protected $table = 'submenu';
    protected $fillable = [
        'id','menu_id','descripcion','ruta','orden','ruta','icono', 'estado', 'observaciones'
     ];
    public $timestamps=false;

    public function menu()
    {
        {
            return $this->hasMany('App\Menu');
        }
    }
}