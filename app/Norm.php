<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class Norm extends Model
{
    use HasCompositePrimaryKey;

    protected $connection = 'mysql';
    protected $table = 'normas';
    protected $primaryKey = ['id_norma','id_tipo_norma','texto_norma'];
    protected $fillable = [	'id_norma','id_tipo_norma','texto_norma', 'carpeta_texto' ,'fec_norma','fec_carga', 'fec_prod','prod_active', 'desc_norma','idjurisdiccion','idtema','idtipodocumento'];
    public $timestamps = false;
    public $incrementing = false;

    public function getTodayNorms()
    {
        // $today = Carbon::now();
        
        $query = $this->setConnection($this->connection)->select('normas.*','tipo_norma.id_tipo_norma as nt_id', 'tipo_norma.desc_tipo_norma as nt_desc', 'tipo_norma.idjurisdiccion as nt_jid', 'jurisdicciones.siglabuscgral as j_acr')
        ->join('tipo_norma', 'normas.id_tipo_norma', '=', 'tipo_norma.id_tipo_norma')
        ->join('jurisdicciones', 'tipo_norma.idjurisdiccion', '=', 'jurisdicciones.idjurisdiccion')
        // ->whereDate('normas.fec_prod', $today)
        ->where('normas.prod_active', 1)
        ->orderBy('normas.fec_carga', 'desc')
        ->get()
        ->groupBy('fec_carga');

        return $query;
    }

    public function getNorm($id_norma, $id_tipo_norma)
    {
        $query = $this->setConnection($this->connection)->where(['id_norma' => $id_norma, 'id_tipo_norma' => $id_tipo_norma])->first();

        return $query;
    }

    public function getNormByArchive($texto_norma)
    {
        $query = $this->setConnection($this->connection)->where(['texto_norma' => $texto_norma])->select('id_norma', 'id_tipo_norma', 'texto_norma', 'carpeta_texto')->first();

        return $query;
    }
}
