<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrvDoc extends Model
{
    protected $connection = 'mysql';
    protected $table = 'trvdocum';
    protected $primaryKey = 'coddocum';
    protected $fillable = ['coddocum','tipodoc','anio','mes','actividad','descripcion','pregunta','texto','nombredochtm','voces','codimpuesto'];
    public $timestamps = false;
}
