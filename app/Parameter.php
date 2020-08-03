<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $connection = 'mysql';
    protected $table = 'parametros';
    protected $fillable = ['codigo_tem', 'codigo_num', 'codigo_coe', 'codigo_sum', 'codigo_doc', 'codigo_mer'];
    public $timestamps = false;
    public $incrementing = false;

    public function getNodeCode($code_type)
    {
        $query = $this->setConnection($this->connection)->select($code_type)->pluck($code_type)->first();

        return $query;
    }

    public function incrNodeCode($code_type)
    {
        $query = $this->setConnection($this->connection)->increment($code_type);

        return $query;
    }
}
