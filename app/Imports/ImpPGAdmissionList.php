<?php
namespace App\Imports;
use App\PGAdmissionList;
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

class ImpPGAdmissionList implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue, WithHeadingRow
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
     
        $val = DB::table('users')->where('formnumber',$row["formnumber"])->first(); //DB::SELECT('CALL ValidateUTMENumber(?)', array($row[0]));
        $ck  = DB::table('pgadmissionlist')->where('formnumber',$row["formnumber"])->first(); //DB::SELECT('CALL CheckDuplicateAdmissionList(?)', array($row[0]));
      
        if($val)
        {
           
          
             
                    if(!$ck)
                    {
                        $status =1;
                        DB::UPDATE('CALL UpdateAdmissionStatus(?,?)',array($row["formnumber"],$status));
                        return new PGAdmissionList([
                            'formnumber'         => $row["formnumber"],
                            'name'               => $row["name"],
                            'programme'          => $row["department"],
                            'course'             => $row["programme"],
                            'degree'             => $row["degree"],
                            'session'            => $this->ses        
                        ]); 
                    }
                    
            
        }
    }
    public function headingRow(): int
    {
        return 1;
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