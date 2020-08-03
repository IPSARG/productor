<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurisdiction extends Model
{
    protected $connection = 'mysql';
    protected $table = 'jurisdicciones';
    protected $primaryKey = 'idjurisdiccion';
    protected $fillable = [	'idjurisdiccion','jurisdiccion','siglabuscgral','orden'];
    public $timestamps = false;

    public function getAll()
    {
        $query = $this->setConnection($this->connection)->orderBy('orden', 'asc')->get();
        
        return $query;
    }
}
