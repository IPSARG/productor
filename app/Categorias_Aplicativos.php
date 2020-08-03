<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias_Aplicativos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','titulo'];



    public function aplicativos()
    {
        return $this->belongsTo('App\Aplicativos', 'id', 'categoria_id');
    }

}
