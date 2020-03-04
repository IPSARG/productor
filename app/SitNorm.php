<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SitNorm extends Model
{
    protected $connection = 'mysql_sit';
    protected $table = 'norms';
    protected $primaryKey = 'id';
    protected $fillable = [	'id','norm_type_id','norm_source_id','update_trivia_id','number','date_norm','date_bo','date_validity','validity_desc','description','news','sender_id','modifier_id','head_harmer_id','body_harmer_id','corrector_id','finalizer_id','state_id','priority','created_at','head_harmed_at','body_harmed_at','corrected_at','modified_at','finalized_at','priority_at'];
    public $timestamps = false;

    public function getNorms()
    {
        $startOfYesterday = Carbon::yesterday();
        $endOfDay = Carbon::today();

        if ($endOfDay->format('N') == 1) { //SI ES LUNES
            $startOfYesterday = Carbon::today()->subDays(3);
        }
        
        $query = $this->setConnection($this->connection)->join('norm_types', 'norms.norm_type_id', '=', 'norm_types.id')
        ->join('jurisdictions', 'norm_types.jurisdiction_id', '=', 'jurisdictions.id')
        ->whereBetween('norms.head_harmed_at', [$startOfYesterday->startOfDay(),$endOfDay->endOfDay()])
        // ->whereDate('norms.head_harmed_at', $today)
        ->select('norms.*', 'norm_types.id as nt_id', 'norm_types.name as nt_name', 'norm_types.jurisdiction_id as nt_jid', 'jurisdictions.acronym as j_acr')
        ->orderBy('norms.created_at', 'desc')
        ->get();

        return $query;
    }
}
