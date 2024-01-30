<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Menu extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'menu';
    protected $fillable = [
        'id','descripcion','orden','icono','hijo','ruta','estado', 'observaciones'
     ];
    public $timestamps=false;

    public function submenu()
    {
        {
            return $this->hasMany('App\Submenu');
        }
    }
}