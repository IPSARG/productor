<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    protected $connection = 'mysql';
    protected $table = 'trvdispatch';
    protected $primaryKey = 'codigo';
}
