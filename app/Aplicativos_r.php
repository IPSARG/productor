<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicativos_r extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
'aplicativos_id',
'posicion',
'titulo',
'version',
'link',
    ];
}
