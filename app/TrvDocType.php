<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrvDocType extends Model
{
    protected $connection = 'mysql';
    protected $table = 'trvtipodoc';
    protected $primaryKey = 'tipodoc';
    protected $fillable = ['tipodoc', 'desctipodoc'];
    public $timestamps = false;
}
