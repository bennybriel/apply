<?php
namespace App\Imports;
use App\Curriculum;
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
class CurriculumImport implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
  

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
               ini_set('max_execution_time', 600);  
               #Check for double entry
               $ck = DB::SELECT('CALL CheckCurriculumDuplicate(?,?,?,?)', array($row[3],$row[1],$row[0],$row[2]));
              // dd($ck);
               //$dat = Carbon\Carbon::now();
              // $todayDate = Carbon::now()->format('d-m-Y:h-m:i');
      //if(!$ck)
      //{                    
           
            return new Curriculum([
                'programid'    => $row[0],
                'level'        => $row[1],
                'semester'     => $row[2],
                'coursecode'   => $row[3],
                'iscore'       => $row[4],
                'status'       => 1
        
          
            ]); 
      //}

   
       
    }
   
    public function chunkSize(): int
    {
        return 1000;
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
    /* */
    /*
    public function rules(): array
    {
        return [
            '1' => Rule::in(['patrick@maatwebsite.nl']),

             // Above is alias for as it always validates in batches
             '*.1' => Rule::in(['patrick@maatwebsite.nl']),
             
             // Can also use callback validation rules
             '0' => function($attribute, $value, $onFailure) {
                  if ($value !== 'Patrick Brouwers') {
                       $onFailure('Name is not Patrick Brouwers');
                  }
              }
        ];
    }
    */
}