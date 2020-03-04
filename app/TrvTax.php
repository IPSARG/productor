<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrvTax extends Model
{
    protected $connection = 'mysql';
    protected $table = 'trvimpuesto';
    protected $primaryKey = 'codimpuesto';
    protected $fillable = ['codimpuesto', 'descimpuesto', 'tipoimpuesto', '	codnodoimpuesto', 'codnodoley'];
    public $timestamps = false;
}
