<?php
namespace App\Imports;
use App\AdmissionList;
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

class ImpAdmissionList implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
  

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $ses;

    public function __construct(String $ses,$ops)
    {
          $this->ses = $ses;
          $this->ops = $ops;
    }
    public function model(array $row)
    {
             
        ini_set('max_execution_time', 600);  
        #Check for double entry
        $status = false;
        $val = DB::SELECT('CALL ValidateUTMENumber(?)', array($row[0]));
        $ck  = DB::SELECT('CALL CheckDuplicateAdmissionList(?)', array($row[0]));
        //dd($val);
        if($val)
        {
            if($this->ops==2)
            {
               $pro = DB::table('programme')->where('programcode',$row[3])->first();
               if($ck)
               {  
                
                    if($pro)
                    {
                      DB::table('admission_lists')->where('utme',$row[0])
                                                ->update(['programme'=>$pro->programme,'departmentcode'=>$row[3]]);
                    }
                }
            }
             else
              {
                  
                        $status =1;
                        DB::UPDATE('CALL UpdateAdmissionStatus(?,?)',array($row[0],$status));
                        #Update registration table
                        $u  = DB::table('users')->where('utme',$row[0])->first();
                        $ld = DB::table('ldaasinfo as la')->select('faculty','la.departmentid','la.department')
                                                    ->join('laasfaculty as fa','fa.faculty','=','la.facultyid')
                                                     ->where('departmentcode', $row[3])->first();
                        if($ld && $u)
                        {
                            $up =DB::table('u_g_pre_admission_regs')->where('matricno',$u->matricno)
                                                                    ->update(['programme'   =>$row[2],
                                                                        'department'  =>$ld->department,
                                                                        'departmentid'=>$ld->departmentid,
                                                                        'faculty'     =>$ld->faculty,
                                                                        'model'       =>$row[4]]);
                            if($up)  
                            {
                                return new AdmissionList([
                                    'utme'               => $row[0],
                                    'name'               => $row[1],
                                    'programme'          => $row[2],
                                    'departmentcode'     => $row[3],
                                    'session'            => $this->ses,  
                                    'departmentid'       =>$ld->departmentid,     
                                ]); 
                            }
                        }                 
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