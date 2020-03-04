<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SitUser extends Model
{
    protected $connection = 'mysql_sit';
    protected $table = 'users';
    protected $primaryKey = 'id';
}
