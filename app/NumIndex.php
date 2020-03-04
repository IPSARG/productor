<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumIndex extends Model
{
    protected $connection = 'mysql';
    protected $table = 'indnum';
    protected $primaryKey = 'cod_padre';
    protected $fillable = ['cod_padre', 'cod_hijo'];
    public $timestamps = false;
    public $incrementing = false;
}
