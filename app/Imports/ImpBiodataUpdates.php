<?php
namespace App\Imports;
use App\UGRegistrationProgress;
use Auth;
use App\User;
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

class ImpBiodataUpdates implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
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
        $ckBid  = UGRegistrationProgress::where('utme',$row[0])->where('stageid',7)->first();
        $ckBio  = UGRegistrationProgress::where('utme',$row[0])->where('stageid',8)->first();
        $ckMat  = UGRegistrationProgress::where('utme',$row[0])->where('stageid',9)->first();
        
        $mat = User::select('utme','matricno')->where('utme',$row[0])->first();
        
              if(!$ckMat)
              {
                    //dd($ckMat);
                    #Matirc Record
                    $bio = new  UGRegistrationProgress();
                    $bio->utme         = $row[0];
                    $bio->matricno     = $mat->matricno;
                    $bio->stageid      = '9';
                    $bio->status       = '1';
                    $bio->paycode      = 'MA';
                    $bio->save();
              }

              if(!$ckBid)
              {
                  #Biodata Record
                    $bio = new  UGRegistrationProgress();
                    $bio->utme         = $row[0];
                    $bio->matricno     = $mat->matricno;
                    $bio->stageid      = '7';
                    $bio->status       = '1';
                    $bio->paycode      = 'BI';
                    $bio->save();
              }
              
             
              if(!$ckBio)
              {
                  #Biometric
                     return new UGRegistrationProgress([
                         'utme'        => $row[0],
                         'matricno'    => $mat->matricno,
                         'stageid'     => '8',
                         'status'      => '1',
                         'paycode'     => 'BO'     
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
   
}