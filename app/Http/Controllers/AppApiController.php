<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Config;
use App\User;
use App\SchoolInfo;
use App\BiodataUpdateLogger;
use App\Interfaces\DocumentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\UGRegistrationProgress;
class AppApiController extends Controller
{
    public function UpdateStudentBiodataInfo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {  


           $counter =0;  $status_zero_counter=0; $status_one_counter=0; $status ="";
           $data = file_get_contents("php://input");
           //return $data;
           $res = json_decode($data); 
          // return $res; 
            DB::INSERT('CALL SaveBiodataRequestLogger(?)',array(json_encode($res)));
           $nc=0; $status_zero_counter=0; $status_one_counter=0;
           if($res)
           {
               $sta = $res[0]->status;
               DB::INSERT('CALL SaveBiodataRequestLogger(?)',array(json_encode($res)));
               foreach($res as $item)
               {
                    // return $item->matric;
                    ini_set('max_execution_time', 600);  
                    #Check for double entry
                    $status = false;
                    $mat = User::select('utme','matricno')->where('matric', $item->matric)->first();
                    if($mat)  
                    {
                        $ckBid  = UGRegistrationProgress::select('matricno')->where('utme', $mat->utme)->where('stageid',7)->first();
                        $ckBio  = UGRegistrationProgress::select('matricno')->where('utme', $mat->utme)->where('stageid',8)->first();
                        $ckMat  = UGRegistrationProgress::select('matricno')->where('utme', $mat->utme)->where('stageid',9)->first();
                        
                        //return $ckMat;
                        //$mat = User::select('utme','matricno')->where('utme',$row[0])->first();
                        if($item->status ==0)
                        {
                            #Update Batching Status
                            DB::table('biodatabatching')->where('utme', $mat->utme)->update(['isbio'=>'1']); 
                            $this->SaveLogger($item->matric,$item,$mat->utme,$sta);
                            ++$status_zero_counter;
                        }
                        else
                        {
                            if(!$ckMat)
                            {
                                    //dd($ckMat);
                                    #Matirc Record
                                    $bio = new  UGRegistrationProgress();
                                    $bio->utme         = $mat->utme;
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
                                    $bio->utme         = $mat->utme;
                                    $bio->matricno     = $mat->matricno;
                                    $bio->stageid      = '7';
                                    $bio->status       = '1';
                                    $bio->paycode      = 'BI';
                                    $bio->save();
                            }
                            if(!$ckBio)
                            {
                                #Biometric
                                    $bio = new  UGRegistrationProgress();
                                    $bio->utme         = $mat->utme;
                                    $bio->matricno     = $mat->matricno;
                                    $bio->stageid      = '8';
                                    $bio->status       = '1';
                                    $bio->paycode      = 'BO';
                                    $bio->save();
                                   
                            } 
                            #Update Batching Status
                            DB::table('biodatabatching')->where('utme', $mat->utme)->update(['isbio'=>'1']); 
                            ++$status_one_counter;
                            $this->SaveLogger($item->matric,$item,$mat->utme,$sta);
                        }
                         
                    }
                    else
                    {
                        ++$nc;
                    }
                    #Update Biodata Informatio
                    $mat = DB::table('users')->where('matric', $item->matricno)->first();

                    $up = DB::table('u_g_pre_admission_regs')->where('matric', $item->matricno)
                              ->update(['surname'=>$item->surname,
                                        'firstname'=>$item->firstname,
                                        'othername'=>$item->othername,
                                        'dob'=>$item->dob,
                                        'state'=>$item->state,
                                        'lga'=>$item->lga,
                                        'town'=>$item->town,
                                        'address'=>$item->address
                                       ]);
                    #Parent info
                    $pa = DB::table('u_g_parent_infos')->where('matricno', $mat->matricno)
                                                      ->update(['surname'=>$item->kinName,
                                                                'othername'=>$item->kinName,
                                                                'relation'=>$item->kinrelationship,
                                                                'phone'=>$item->kinphone,
                                                                'email'=>$item->kinemail,
                                                                'address'=>$item->kinaddress                                              
                                                ]);
                $ck = DB::table('schoolinfo')
                                            ->where('matricno', $mat->matricno)
                                            ->where('name', $item->school->name)
                                            ->where('startdate', $item->school->from_date)
                                            ->first();
                   if(!$ck)
                    {
                        $sch = new SchoolInfo();
                        $sch->matricno  =    $mat->matricno;
                        $sch->name      =    $item->school->name;
                        $sch->startdate =    $item->school->from_date;
                        $sch->enddate   =    $item->school->to_date;
                        $sch->save();
                    }

                }
               
               
                 if($sta==0)
                 {
                    $message= 'Data Received and Updated';
                    $response = [
                    'success' => true,
                    'affectedRecords'=>$status_zero_counter,
                    'operation'=>'Batching Status Update',
                    'message' => $message,
                    ];
                    return response()->json($response, 200);
                 }
                else
                {
                   $message= 'Data Received and Inserted';
                   $response = [
                   'success' => true,
                   'affectedRecords'=>$status_one_counter,
                   'operation'=>'New Record Creation',
                   'message' => $message,
                   ];
                   return response()->json($response, 200);
                 }
           }
           else
            {
                $message= $counter. 'Invalid Data Supplied';
                $response = [
                'error' => true,
                'message' => $message,
                ];
               return response()->json($response, 201);
            }


      
        } 
        else 
        {
           $message='Unable to Save Record';
           $response = [
             'success' => false,
             'message' => $message,
           ];
           return response()->json($response, 201);
        }    
    }
     public function SaveLogger($mat,$payload,$utme,$status)
     {
        $m = DB::table('biodataupdatelogger')->where('matricno',$mat)->where('status',$status)->first();
        if(!$m)
        {
            $bloger = new BiodataUpdateLogger();
            //return $bloger;
            $bloger->matricno = $mat;
            $bloger->utme = $utme;
            $bloger->status = $status;
            $bloger->payload = json_encode($payload);
            $bloger->save();
        }
    }
    public function GetStudentPaymentInfoByMatricno($mat)
    {
               // $email ="shiddo121@gmail.com";
                $data = DB::SELECT('CALL GetStudentPaymentInfoByMatricno(?)',array($mat));
                if($data)
                {
                    $message='User signed in';
                    $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => $message,
                    ];
            
                    return response()->json($data, 200);
                    
                }
                else
                {    $msg = "Fetching Failed...";
                    // return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    $code = 404;
                    $response = [
                        'success' => false,
                        'message' => $msg,
                    ];
            
                    if(!empty($msg)){
                        $response['data'] = $msg;
                    }
            
                    return response()->json($data, $code);
                
                }
    }
    public function GetStudentPaymentInfo()
    {
               // $email ="shiddo121@gmail.com";
                $data = DB::SELECT('CALL FetchStudentPaymentInfo()');
                if($data)
                {
                    $message='User signed in';
                    $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => $message,
                    ];
            
                    return response()->json($data, 200);
                    
                }
                else
                {    $msg = "Fetching Failed...";
                    // return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    $code = 404;
                    $response = [
                        'success' => false,
                        'message' => $msg,
                    ];
            
                    if(!empty($msg)){
                        $response['data'] = $msg;
                    }
            
                    return response()->json($data, $code);
                
                }
    }
    public function GetBiodataInfoByMatricNo($mat)
    {
               // $email ="shiddo121@gmail.com";
                $data = DB::SELECT('CALL GetBiodataInfoByMatricNo(?)',array($mat));;
                if($data)
                {
                    $message='User signed in';
                    $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => $message,
                    ];
            
                    return response()->json($data, 200);
                    
                }
                else
                {    $msg = "Fetching Failed...";
                    // return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    $code = 404;
                    $response = [
                        'success' => false,
                        'message' => $msg,
                    ];
            
                    if(!empty($msg)){
                        $response['data'] = $msg;
                    }
            
                    return response()->json($data, $code);
                
                }
    }
    public function GetBiodataInfo()
    {
               // $email ="shiddo121@gmail.com";
                $data = DB::SELECT('CALL FetchBiodataInfo()');
                if($data)
                {
                    $message='User signed in';
                    $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => $message,
                    ];
            
                    return response()->json($data, 200);
                    
                }
                else
                {    $msg = "Fetching Failed...";
                    // return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    $code = 404;
                    $response = [
                        'success' => false,
                        'message' => $msg,
                    ];
            
                    if(!empty($msg)){
                        $response['data'] = $msg;
                    }
            
                    return response()->json($data, $code);
                
                }
    }
    public function GetBiodataPayment()
    {
               // $email ="shiddo121@gmail.com";
                $data = DB::SELECT('CALL FetchBiodataPayemnt()');
                if($data)
                {
                    $message='User signed in';
                    $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => $message,
                    ];
            
                    return response()->json($data, 200);
                    
                }
                else
                {    $msg = "Fetching Failed...";
                    // return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    $code = 404;
                    $response = [
                        'success' => false,
                        'message' => $msg,
                    ];
            
                    if(!empty($msg)){
                        $response['data'] = $msg;
                    }
            
                    return response()->json($data, $code);
                
                }
    }
    public function DocumentUpload($guid)
    {
               // $email ="shiddo121@gmail.com";
                $data = DB::table('users')->where('guid',$guid)
                                         ->first();
                if($data)
                {
                    $message='User signed in';
                    $response = [
                        'success' => true,
                        'data'    => $data,
                        'message' => $message,
                    ];
            
                    return response()->json($data, 200);
                    
                }
                else
                {    $msg = "Fetching Failed...";
                    // return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    $code = 404;
                    $response = [
                        'success' => false,
                        'message' => $msg,
                    ];
            
                    if(!empty($msg)){
                        $response['data'] = $msg;
                    }
            
                    return response()->json($data, $code);
                
                }
    }
}
