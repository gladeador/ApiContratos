<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    use HasFactory;
    protected $table = 'permisos';
    protected $fillable = [
        'id','profile_id','menu_id','submenu_id','lee','graba','borra', 'estado'
     ];
    public $timestamps=false;

    public function menu()
    {
        {
            return $this->hasMany('App\Menu');
        }
    }

    public function submenu()
    {
        {
            return $this->hasMany('App\Submenu');
        }
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }
}