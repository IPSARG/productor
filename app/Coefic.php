<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coefic extends Model
{
    protected $connection = 'mysql';
    protected $table = 'coefic';
    protected $fillable = [	'cod_padre','cod_hijo'];
    public $timestamps = false;
    public $incrementing = false;
}
