<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tipodocumento';
    protected $primaryKey = 'idtipodocumento';
    protected $fillable = [	'idtipodocumento','tipodocumento','orden'];
    public $timestamps = false;

    public function getAll()
    {
        $query = $this->setConnection($this->connection)->orderBy('orden', 'asc')->get();
        
        return $query;
    }
}
