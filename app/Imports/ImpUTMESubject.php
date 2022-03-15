<?php
namespace App\Imports;
use App\UTMESubject;
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

class ImpUTMESubject implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
  

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   // protected $ses;
   

    public function model(array $row)
    {
             
        ini_set('max_execution_time', 600);  
        #Check for double entry
        $ucounter =0;         $u =0;
       // dd($row);
       // $val = DB::SELECT('CALL ValidateUTMENumber(?)', array($row[0]));
          $val  = DB::SELECT('CALL CheckDuplicateUTMENumber(?)', array($row[0]));
         
        
           if($val)
            { 
              
                if($row[6] &&  $row[5]) 
                {
                    //Get SubjectID
                      $su = DB::SELECT('CALL GetSubjectIDBySubject(?)',array($row[1]));
                     if($su) 
                     {
                        $ck  = DB::SELECT('CALL CheckDuplicateUTMESubject(?,?,?)', array($row[0],$su[0]->subjectid,$row[6]));
                       // dd($ck);
                        if($ck)
                        {
                            DB::UPDATE('CALL UpdateUMTESubject(?,?,?,?)',array($row[0],$row[6],$row[2],$su[0]->subjectid));
                        }
                        else
                        {
                            DB::INSERT('CALL SaveUTMESubjects(?,?,?,?,?,?,?,?)',
                            array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$su[0]->subjectid));
                            return new UTMESubject([
                                'utme'        => $row[0],
                                'subject'     => $row[1],
                                'subjectid'   => $su[0]->subjectid,
                            
                            ]); 
                        }
                    }
                }
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