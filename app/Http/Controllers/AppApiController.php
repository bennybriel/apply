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


  
    public function UpdateMatriculationNumber($mat)
    {
        if($a<=1 || $a>0)
        {

        }
        return $mat;
                       $utme = "";    
                       $apptype = "UGD";
                       $isadm = 1;
                       $progid ="";
                       $uuid = Str::uuid()->toString().Str::uuid()->toString();
                       $url  = config('paymentUrl.matricno_url'); 
                       $std  = DB::SELECT('CALL GetMatricNoInformation(?)',array($mat));
                       if($std)
                       {
                          //Get Programme ID 
                          if($std)  //($response->getStatusCode() == 200) 
                          {    
                                $utme  = $std[0]->utme; 
                               
                                if($std[0]->lga)
                                 {
                                    $lga=$std[0]->lga;
                                 }
                                 else
                                 {
                                  $lga ="None";
                                 }
                                 
                                //dd($std[0]->phone);
                                 $parameters =
                                   '{
                                        "firstname":"'.$std[0]->firstname.'",
                                        "surname": "'.$std[0]->surname.'",
                                        "othername":"'.$std[0]->othername.'",
                                        "gender" :  "'.$std[0]->gender.'",
                                        "lga" :"'.$std[0]->lga.'",
                                        "state" : "'.$std[0]->state.'",
                                        "nationality":"Nigeria",
                                        "department_id":"'.$std[0]->departmentid.'",
                                        "admission_mode":"UTME",
                                        "marital_status" : "'.$std[0]->maritalstatus.'",
                                        "religion":  "'.$std[0]->religion.'",
                                        "email":     "'.$std[0]->email.'",
                                        "phone":     "'.$std[0]->phone.'",
                                        "admission_yr":"'.$std[0]->admissionyear.'",
                                        "level":"'.$std[0]->level.'"   
                                    }';
                            
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL,"https://ldaas.lautech.edu.ng/api/students/generate-matric-no");
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $headers = array();
                                $headers[] = 'Accept: application/json';
                                $headers[] = 'Content-Type: application/json';
                                $headers[] = 'Access-Token:zh8o1sxdIp0xHatJAmeFHQEXmTmGzped6xhTipZ1b72uEGRsafQjvyomIivg43s6';
                                $headers[] = 'App-Token:eyJOPb1aSSJVOlOBpyUo1u2OK9f2phyH4kdK.eyJ4K96nRJEG0Eqr3NotAXNsci49SXPnMEpdsTB87frPgfa4ZdlOorN.UnM2fdjqgltKb5TuuOL4B3b1a72Xh5dBWi1biyTP';
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                $server_output = curl_exec($ch); 
                               // dd($server_output);
                                  $res = json_decode($server_output);   
                                  DB::INSERT('CALL SaveMatricNoRequestLogger(?,?,?)',array($parameters,$utme,$mat));
                                  DB::INSERT('CALL SaveMatricNoRequestLogger(?,?,?)',array(json_encode($server_output),$utme,$mat));
                              
                                    //$res->status==203
                                   // dd($res);
                                    if($res->status==201)
                                    {
                                           $matrs = $res->data->student->matric_no;
                                           $ck1 = DB::table('users')->where('matric', $res->data->student->matric_no)->first();
                                           if($ck1)
                                            {
                                               $matr=0;
                                            }
                                            else
                                            {
                                               $this->UpdateMatricNo($res->data->student->matric_no);
                                            }
                                     
                                    }   
                                    elseif($res->status==203)
                                    {
                                       $client = new \GuzzleHttp\Client();
                                       #Pass email address to get matricno
                                       $urlinfo = config('paymentUrl.student_url').$std[0]->email;
                                       $response = $client->request('GET', $urlinfo, ['headers' => [ 'Access-Token' => 'zh8o1sxdIp0xHatJAmeFHQEXmTmGzped6xhTipZ1b72uEGRsafQjvyomIivg43s6']]);
                                       if($response->getStatusCode() == 200) 
                                       {   
                                              $ress = json_decode($response->getBody());
                                              $mat =$ress->data[0]->student->matric_no;
                                              $this->UpdateMatricNo(Auth::user()->matricno, $ress->data[0]->student->matric_no);
                                       }
                                       else
                                       {
                                            DB::INSERT('CALL SaveMatricNoRequestLogger(?,?,?)',array(json_encode($ress),$utme,$mat));
                                       }
                                     
                                    }
                                    else
                                    {
                                        $matr=null;
                                    }
                                   
                          } 
                                         
                        } 
                                     
                    
    }
    public function UpdateStudentBiodataInfo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {  


           $counter =0;  $status_zero_counter=0; $status_one_counter=0; $status ="";
           $data = file_get_contents("php://input");
           //return $data;
           $res = json_decode($data); 
          // return $res; 
           // DB::INSERT('CALL SaveBiodataRequestLogger(?)',array(json_encode($res)));
           $nc=0; $status_zero_counter=0; $status_one_counter=0;
           if($res)
           {
               $sta = $res[0]->status;
              // DB::INSERT('CALL SaveBiodataRequestLogger(?)',array(json_encode($res)));
               foreach($res as $item)
               {
                    // return $item->matric;
                    ini_set('max_execution_time', 600);  
                    #Check for double entry
                    $status = false;
                    $mat = User::select('utme','matricno')->where('matric', $item->matricno)->first();
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
                            $this->SaveLogger($item->matricno,$item,$mat->utme,$sta);
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
                            $this->SaveLogger($item->matricno,$item,$mat->utme,$sta);
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
                    if($item->kinName && $item->kinName && $item->kinName  && $item->kinrelatationship &&
                       $item->kinphone &&  $item->kinemail && $item->kinaddress && $mat->matricno
                    )
                    {
                       $pa = DB::table('u_g_parent_infos')->where('matricno', $mat->matricno)
                                                      ->update(['surname'=>$item->kinName,
                                                                'othername'=>$item->kinName,
                                                                'relation'=>$item->kinrelatationship,
                                                                'phone'=>$item->kinphone,
                                                                'email'=>$item->kinemail,
                                                                'address'=>$item->kinaddress                                              
                                                ]);
                    }
                   #save school

                   //return $item->school;
                   if($item->school)
                   {
                       return true;
                   }
                   if(count($item->school) > 0)
                    {
                        foreach($item->school as $schs)
                        {
                            //return $schs->name;
                        
                            if($mat->matricno && $schs->name && $schs->from_date &&  $schs->to_date)
                            {
                                    $ck = DB::table('schoolinfo')
                                                            ->where('matricno', $mat->matricno)
                                                            ->where('name', $schs->name)
                                                            ->where('startdate', $schs->from_date)
                                                            ->first();
                                    if(!$ck)
                                    {
                                    // return $sch->name;
                                        $sch = new SchoolInfo();
                                        $sch->matricno  =    $mat->matricno;
                                        $sch->name      =    $schs->name;
                                        $sch->startdate =    $schs->from_date;
                                        $sch->enddate   =    $schs->to_date;
                                        $sch->save();
                                    }
                            }
                        }
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
