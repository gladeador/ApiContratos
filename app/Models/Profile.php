<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    //
    protected $table = 'profiles';
    protected $fillable = [
        'id','nombre', 'descripcion', 'condicion'
    ];
    public $timestamps=false;

    public function users(){
        {
            return $this->hasMany('App\User');
        }
    }

    public function permisos(): HasMany
    {
        return $this->hasMany(Permisos::class);
    }
}
