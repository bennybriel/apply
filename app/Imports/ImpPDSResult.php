<?php
namespace App\Imports;
use App\PDSScores;
use Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImpPDSResult implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
  

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $ses;

    public function __construct(String $ses)
    {
        $this->ses = $ses;
       // $this->to = $to;
    }
    public function model(array $row)
    {
             
        ini_set('max_execution_time', 600);  
        #Check for double entry
        $status = false;
        $val = DB::SELECT('CALL ValidateFormNumber(?)', array($row[0]));
        $ck  = DB::SELECT('CALL CheckDuplicateResults(?,?)', array($this->ses,$row[0]));
        //dd($ck);
        if($val)
        {
           if(!$ck)
             {
                // dd($row[1]);
                    if( $row[1]>=40)
                    {
                        $status =true;
                        DB::UPDATE('CALL UpdateAdmissionStatus(?,?)',array($row[0],$status));
                    }
                     return new PDSScores([
                         'formnumber' => $row[0],
                         'score'      => $row[1],
                         'type'       =>'PDS',
                         'status'       =>'1',
                         'session'    => $this->ses        
                     ]); 
                 
             }
        }
    }
   
    public function chunkSize(): int
    {
        return 1000;
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
   
}