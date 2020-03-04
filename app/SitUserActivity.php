<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SitUserActivity extends Model
{
    protected $connection = 'mysql_sit';
    protected $table = 'user_activities';
    protected $primaryKey = 'id';
}
