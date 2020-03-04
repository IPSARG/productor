<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemNode extends Model
{
    protected $connection = 'mysql';
    protected $table = 'nodotem';
    protected $fillable = ['cod_nodo', 'desc_nodo', 'fecha'];
    public $timestamps = false;
    public $incrementing = false;
}
