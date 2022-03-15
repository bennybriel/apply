<?php
namespace App\Imports;
use App\User;
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
class UsersImport implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
  

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         ini_set('max_execution_time', 600);
        //dd($row);
              $sta = Auth::user()->matricno;
              //check for student 
               $matricno = $row[3];
               $email    = $row[1];
               $name     = $row[0];
               $ses ="2020/2021";
               #Check for double entry
               $ck = DB::SELECT('CALL CheckAccountSignupDuplicateByMatricNo(?)', array($matricno));
             //  dd($ck);
                //Set Parameters
               /*
                       if($ck[0]->Mat==0)
                        { 
                           
                            $pass = Hash::make($row[2]); //encrpt password
                            $uuid = Str::uuid()->toString();//generate unique id
                            $usr ="Student";

                            $sav = DB::INSERT('CALL SaveUserAuthentication(?,?,?,?,?,?,?,?,?)', 
                             array($row[0],$email,$pass,$uuid,$matricno,$usr,$row[4],$row[5],$ses));
                                  
                           
                        }
                */
        //dd($row);
      if($ck[0]->Mat==0)
      {                    
            $uuid = Str::uuid()->toString();//generate unique id
            $usr ="Student";
            return new User([
                'name'         => $row[4]. ' '. $row[5],
                'email'        => $row[1],
                'matricno'     => $row[3],
                'surname'      => $row[4],
                'firstname'    => $row[5],
                'guid'         => $uuid,
                'usertype'     => $usr,
                'activesession'=> $ses,
                'status'       => 1,
                'iscomplete'   => 1,
                'isadmitted'   => 1,
                'isactive'     => 1,
                'password' => Hash::make($row[2])
            ]); 
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