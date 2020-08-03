<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicativos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id',
    'titulo',
    'novedades',
    'descripcion',
    'categoria_id',
    'nota',
];



public function opciones()
{
    return $this->belongsTo('App\Aplicativos_r', 'id', 'aplicativos_id');
}

}
