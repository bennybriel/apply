<?php
namespace App\Imports;
use App\PTAdmissionList;
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

class ImpPTAdmissionList implements ToModel,  WithBatchInserts, WithChunkReading, ShouldQueue, WithHeadingRow
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
       //dd($row);
        $status = false;
        $val = DB::table('users')->where('formnumber',$row["formnumber"])->first(); //DB::SELECT('CALL ValidateUTMENumber(?)', array($row[0]));
        $ck  = DB::table('ptadmissionlist')->where('formnumber',$row["formnumber"])->first(); //DB::SELECT('CALL CheckDuplicateAdmissionList(?)', array($row[0]));
        //dd($val);
        if($val)
        {
           
          
             
                   if(!$ck)
                    {
                        $status =1;
                        DB::UPDATE('CALL UpdateAdmissionStatus(?,?)',array($row["formnumber"],$status));
                        return new PTAdmissionList([
                            'formnumber'         => $row["formnumber"],
                            'name'               => $row["name"],
                            'programme'          => $row["programme"],
                            'slevels '           => $row["studentlevel"],
                            'session'            => $this->ses        
                        ]); 
                    }
            
        }
    }
   
    public function chunkSize(): int
    {
        return 1000;
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function batchSize(): int
    {
        return 1000;
    }
   
}