<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $connection = 'mysql';
    protected $table = 'temas';
    protected $primaryKey = 'idtema';
    protected $fillable = [	'idtema','tema'];
    public $timestamps = false;

    public function getAll()
    {
        $query = $this->setConnection($this->connection)->orderBy('tema', 'asc')->get();

        return $query;
    }
}
