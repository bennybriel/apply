<?php
namespace App\Imports;
use App\UTMEInfo;
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

class ImpUTMEInfo implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
  

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   // protected $ses;
   
    public function __construct(String $ses)
    {
        
        $this->ses = $ses;
       // $this->to = $to;
    }
    public function model(array $row)
    {
             
        ini_set('max_execution_time', 600);  
        #Check for double entry
        $ucounter =0;         $u =0;
       // dd($row);
       // $val = DB::SELECT('CALL ValidateUTMENumber(?)', array($row[0]));
        $ck  = DB::SELECT('CALL CheckDuplicateUTMENumber(?)', array($row[0]));
        $encoding = mb_detect_encoding($content, 'UTF-8, ISO-8859-1, WINDOWS-1252, WINDOWS-1251', true);
        if ($encoding != 'UTF-8') {
            $string = iconv($encoding, 'UTF-8//IGNORE', $row[1]);
        }
        
           if($ck)
             { 
                   
               DB::UPDATE('CALL UpdateUMTEInformation(?,?)',array($row[0],$row[5]));
               $ucounter++;
             

             }
             else
             {
                 $u++;
               //dd($u);
                 DB::INSERT('CALL SaveUTMEInformation(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                 array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],
                 $row[8],$row[9],$row[10],$row[11], $row[12], $row[14], $row[13],'UTME'));
                
                 
                return new UTMEInfo([
                    'utme'        => utf8_encode($row[0]),
                    'name'        => $row[1],
                    'gender'      => $row[2],   
                    'state'       => $row[3],
                    'totalscore'  => $row[4],
                    'programme'    => $row[5],
                    'lga'          => $row[6],
                    'subject1'     => $row[7],
                    'score1'       => $row[8],
                    'subject2'     => $row[9],
                    'score2'      => $row[10],
                    'subject3'    => $row[11],
                    'score3'      => $row[12],
                    'score4'      => $row[13],
                    'subject4'    => $row[14],
                    'status'      => '1',
                    'created_at'  => date('d-m-Y'),
                    'apptype'     => 'UTME'    
                ]); 

                dd($ucounter);
             }

             //dd($row[0].$ucounter. ' Updated. Insertion is '.$u);
       
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