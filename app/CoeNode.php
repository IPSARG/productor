<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoeNode extends Model
{
    protected $connection = 'mysql';
    protected $table = 'nodocoe';
    protected $fillable = ['cod_nodo', 'desc_nodo', 'fecha'];
    public $timestamps = false;
    public $incrementing = false;
}
