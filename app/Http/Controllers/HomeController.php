<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Config;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function GetTransaction()
    {
        /*
         $client = new \GuzzleHttp\Client();
        $mat = Auth::user()->matricno;
        $pds  = DB::SELECT('CALL GetTransactions(?)',array($mat));
        foreach($pds as $pd)
        {
         
            $url = config('paymentUrl.trans_status_url').$pd->transactionid;      
            $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
            $res = json_decode($response->getBody());
          
            
                if($res)
                 {
                            if($res->status=="Approved Successful" ||  $res->status=="Transaction Successful")
                             {
                                            #Assign form number and update same
                                                 
                                        
                                                    $l = substr($res->trans_ref,0,2);
                                                    if($l=="CP")
                                                    {
                                                        DB::table('users')->where('matricno', $mat)->update(['isChange'=>1]);
                                                    }
                                                    if($l=="ME")
                                                    {
                                                          $sav = DB::UPDATE('CALL UpdateMedicalStatus(?,?)',array($pd->transactionid,$res->status));
                                                    }
                                                    elseif($l=="AC")
                                                    {
                                                        
                                                        $sav = DB::UPDATE('CALL UpdateAcceptanceStatus(?,?)',array($pd->transactionid,$res->status));
                                                      //   dd($sav);
                                                    }
                                                    elseif($l=="TU") 
                                                    {
                                                        $sav = DB::UPDATE('CALL UpdateTuitionStatus(?,?)',array($pd->transactionid,$res->status));            
                                                    }
                                                    elseif($l=="IC") 
                                                    {
                                                        $sav = DB::UPDATE('CALL UpdateICTStatus(?,?)',array($pd->transactionid,$res->status));            
                                                    }
                                                    else
                                                    {
                                                        DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $mat));
                                                    }
                            }
                                 
                  }
                  
          }
         */
    }
    public function index()
    {
        ///Debit Student Account
        $amnt=0;
        $ses = Auth::user()->activesession;
        $isadm = Auth::user()->isadmitted;
        $mat = Auth::user()->matricno;
        $utme = Auth::user()->utme;
        $usr =Auth::user()->usertype;
        $apptype =  trim(Auth::user()->apptype);
        $op =" Login";
        $frm =Auth::user()->formnumber;
        $accpt =Auth::user()->isacceptance;
        $imed =Auth::user()->ismedical;
        $ict =Auth::user()->isict;
        $istuition =Auth::user()->istuition;
        $ispaid =Auth::user()->ispaid;
        $matric = Auth::user()->matric;
        $client = new \GuzzleHttp\Client();
        $rol = DB::SELECT('CALL GetCurrentUserRole(?)', array($mat));
       // dd($rol);
          #Track log
          //dd(Auth::user()->matricno);
          \App\Helpers\AppHelper::instance()->GetActivity($op);
         // \App\Helpers\AppHelper::instance()->GetActivity($op);
             
                       //  $pds  = DB::SELECT('CALL GetTransactions(?)',array($mat));
                      //  if($pds)
                      //  {
                       //     $this->GetTransaction();
                       // }
               if($usr=="Candidate")
                {

                        if($apptype=="PDS" || $apptype=="JUP" || $apptype=="PG" || $apptype=="PT")
                        {
                          
                            if($ispaid ==true && (!$frm || empty($frm) || $frm==null))
                            {
                                 #Assign form number and update same
                                 DB::UPDATE('CALL GetFormNumber(?,?)',array($mat,$apptype));
                            }
                             $lga = DB::SELECT('CALL CheckLGAExistence(?)',array($mat));
                             $data = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)',array($mat));
                            if($data)
                            {
                                if(!$lga[0]->lga || $lga[0]->lga==null)
                                {
                                    $st = DB::SELECT('CALL FetchStateList');
                                    return view('addLGA',['st'=>$st]);
                                }
                            }
                            // if($apptype=="PDS" || $apptype=="JUP")
                            // {
                            //     return view('ugbiodata');
                            // }
                            // else if($apptype=="PG")
                            // {

                            // }

                        }

                  
                     
                   
                }  
                elseif($usr=="Student" && $apptype=='PDS')
                {
                   /*       
                    $pds  = DB::SELECT('CALL GetTransactions(?)',array($mat));
                    if($pds)
                    {
                            try
                            {
                                foreach($pds as $pd)
                                {
                                
                                
                                    $url = config('paymentUrl.trans_status_url').$pd->transactionid;
                                    $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                                    if ($response->getStatusCode() == 200) 
                                    {    
                                            $res = json_decode($response->getBody());       
                                    } 
                                    if($res)
                                    {
                                        if($res->status=="Approved Successful" ||  $res->status=="Transaction Successful")
                                        {
                                                $l = substr($res->trans_ref,0,2);                               
                                                $this->UpdatePDStageStatus($l);
                                        }
                                        else
                                        {
                                            DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $mat));
                                        }                                 
                                    }
                                        
                                }
                            }
                            catch(\GuzzleHttp\Exception\RequestException $e)
                            {
                            
                                    $error['error'] = $e->getMessage();
                                    $error['request'] = $e->getRequest();
                                    if($e->hasResponse())
                                    {
                                        if ($e->getResponse()->getStatusCode() == '400'){
                                            $error['response'] = $e->getResponse(); 
                                        }
                                    }
                                Log::error('Error occurred in get request.', ['error' => $error]);
                            }
                            catch(Exception $e)
                            {
                            }


                    }
                    */
                    
                    $st = $this->GetCurrentState();
                    return view('admissionHomePDS',['st'=>$st]);
                          
                           
                 
                }
               elseif($usr=="Student" && $apptype=='JUP')
               {
                          if($accpt=='0' || $accpt=='NULL' || empty($accpt))
                           {
                               return redirect()->route('paymentHome');
                           }
                           if($imed=='0' || $imed=='NULL' || empty($imed))
                           {
                               return redirect()->route('paymentHome');
                           }
                           if($istuition=='0' || $istuition=='NULL' || empty($istuition))
                           {
                               return redirect()->route('paymentHome');
                           }
                           if($apptype=="PDS" && ($ict=='0' || $ict=='NULL' || empty($ict)))
                           {
                                return redirect()->route('paymentHome');
                           }
                           if($apptype=="JUP")
                           {
                                 $sum=0; $pid=0; $total=0;$p=0;
                                 $pname ="";
                                 $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($mat));
                                 $cat = DB::SELECT("CALL GetJUPEBFeeCategory(?)",array($dat[0]->category1));
                                 $pay = DB::SELECT("CALL GetTotalAmountByCandidate(?)",array($mat));
                               
                                 if($cat)
                                 {
                                     $pid=18;//Management Sciene
                                     $p=19;
                                     $pname ="JUPEB Part Tuition Fee (MGS)";
                                     $total = DB::SELECT('CALL FetchApplicationListingByID(?)',array($pid));
                                 }
                                 else
                                 {
                                     $pid=20;//Science
                                     $p=21;
                                     $pname ="JUPEB Part Tuition Fee (Science)";
                                     $total = DB::SELECT('CALL FetchApplicationListingByID(?)',array($pid));
                                 }
                               
                                if($pay)
                                {
                                    foreach($pay as $ps)
                                    {
                                        $sum+=$ps->amount;
                                    }  
                                    if($sum < $total[0]->amount)
                                    {

                                        //Redirect to pay balance
                                        return view('paymentBalance',['id'=>$p,'pname'=>$pname]);
                                        //return redirect()->route('paymentBalance');
                                    }        
                                }                  
                           }  
                
               }
               elseif($usr=="Student" && $apptype=='UGD')
               {
                 /*  */ 
                  $matric = Auth::user()->matric;
                  $pds  = DB::SELECT('CALL GetTransactions(?)',array($mat));
                  if($pds)
                  {
                        try
                        {
                          foreach($pds as $pd)
                          {
                            
                            
                             $url = config('paymentUrl.trans_status_url').$pd->transactionid;
                             $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                             if ($response->getStatusCode() == 200) 
                             {    
                                  $res = json_decode($response->getBody());       
                             } 
                               if($res)
                                {
                                  if($res->status=="Approved Successful" ||  $res->status=="Transaction Successful")
                                  {
                                      
                                        $l = substr($res->trans_ref,0,2);
                                        
                                        if($l=="AD" || $l=="NO")
                                        {
                                            
                                             $sav = DB::UPDATE('CALL UpdateAdmissionLetterStatus(?,?)',array($pd->transactionid,$res->status));
                                             $this->UpdateStageStatus($l);
                                        
                                        }
                                        elseif($l=="AC")
                                        {
                                            //dd($pd->transactionid);  
                                           $sav = DB::UPDATE('CALL UpdateAcceptanceStatus(?,?)',array($pd->transactionid,$res->status));
                                          
                                        
                                             $this->UpdateStageStatus($l);
                                          
                                        }
                                        elseif($l=="ME")
                                        {
                                                $sav = DB::UPDATE('CALL UpdateMedicalStatus(?,?)',array($pd->transactionid,$res->status));
                                         
                                                $this->UpdateStageStatus($l);
                                           
                                        }
                                        elseif($l=="TU") 
                                        {
                                            $sav = DB::UPDATE('CALL UpdateTuitionStatus(?,?)',array($pd->transactionid,$res->status));            
                                          
                                          
                                              $this->UpdateStageStatus($l);
                                          
                                        }
                                        elseif($l=="IC") 
                                        {
                                           $sav = DB::UPDATE('CALL UpdateICTStatus(?,?)',array($pd->transactionid,$res->status));
                                           if($sav > 0)
                                           {
                                             $this->UpdateStageStatus($l);
                                           }            
                                        }
                                        else
                                        {
                                            DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $mat));
                                        }
                                    }
                                }
                                    
                           }
                        }
                        catch(\GuzzleHttp\Exception\RequestException $e)
                        {
                        
                        $error['error'] = $e->getMessage();
                        $error['request'] = $e->getRequest();
                        if($e->hasResponse()){
                            if ($e->getResponse()->getStatusCode() == '400'){
                                $error['response'] = $e->getResponse(); 
                            }
                        }
                        Log::error('Error occurred in get request.', ['error' => $error]);
                        }
                        catch(Exception $e)
                        {
                       
                        }


                   }
               
                   // if(Auth::user()->email == "olatemiji@gmail.com")
                   // {
                    if((!$matric || $matric == null) && $isadm=='1' && ($med == true))
                     {
                        $this->MatriculationNumber();
                     
                     }
                 

                     $st = $this->GetCurrentState();
                     return view('admissionHome',['st'=>$st]);
               }
               elseif($usr=="Student" && $apptype=='PG')
               {
                 $pds  = DB::SELECT('CALL GetTransactions(?)',array($mat));
                 if($pds)
                 {
                  try
                  {
                    foreach($pds as $pd)
                    {
                      
                      
                            $url = config('paymentUrl.trans_status_url').$pd->transactionid;
                            $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                            if ($response->getStatusCode() == 200) 
                            {    
                                    $res = json_decode($response->getBody());       
                            } 
                           if($res)
                            {
                                if($res->status=="Approved Successful" ||  $res->status=="Transaction Successful")
                                {
                                       $l = substr($res->trans_ref,0,3);                               
                                       $this->UpdatePGStageStatus($l);
                                }
                                else
                                {
                                    DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $mat));
                                }                                 
                            }
                              
                     }
                  }
                  catch(\GuzzleHttp\Exception\RequestException $e)
                  {
                  
                  $error['error'] = $e->getMessage();
                  $error['request'] = $e->getRequest();
                  if($e->hasResponse()){
                      if ($e->getResponse()->getStatusCode() == '400'){
                          $error['response'] = $e->getResponse(); 
                      }
                  }
                  Log::error('Error occurred in get request.', ['error' => $error]);
                  }
                  catch(Exception $e)
                  {
                 
                  }


                 }
                   return view('admissionPGHome');
               }
               elseif($usr=="Student" && $apptype=='PT')
               {

                   /*
                    $pds  = DB::SELECT('CALL GetTransactions(?)',array($mat));
                    if($pds)
                    {
                            try
                            {
                                foreach($pds as $pd)
                                {
                                
                                
                                    $url = config('paymentUrl.trans_status_url').$pd->transactionid;
                                    $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                                    if ($response->getStatusCode() == 200) 
                                    {    
                                            $res = json_decode($response->getBody());       
                                    } 
                                    if($res)
                                    {
                                        if($res->status=="Approved Successful" ||  $res->status=="Transaction Successful")
                                        {
                                                $l = substr($res->trans_ref,0,3);                               
                                                $this->UpdatePTStageStatus($l);
                                        }
                                        else
                                        {
                                            DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $mat));
                                        }                                 
                                    }
                                        
                                }
                            }
                            catch(\GuzzleHttp\Exception\RequestException $e)
                            {
                            
                                    $error['error'] = $e->getMessage();
                                    $error['request'] = $e->getRequest();
                                    if($e->hasResponse())
                                    {
                                        if ($e->getResponse()->getStatusCode() == '400'){
                                            $error['response'] = $e->getResponse(); 
                                        }
                                    }
                                Log::error('Error occurred in get request.', ['error' => $error]);
                            }
                            catch(Exception $e)
                            {
                            }


                    }
                    */
                    $stag = DB::table('ptregistrationprogress')->where('stageid',3)->where('status',1)->first();
                    if($stag)
                    {
                        $this->MatriculationNumber();
                    }
                     return view('admissionPTHome');
               }
               elseif($usr=="Staff" && $rol && $rol[0]->section=='Bursary')
               {
                  return view('bursaryHome');
               }
           return view('home');
    }
    public function AdmissionPTHome()
    {
       if(Auth::check())
       {
          
           return view('admissionPTHome');
       }
       else
       {
           return view('logon');
       }
    }
    public function AdmissionHomePDS()
    {
       if(Auth::check())
       {
          
           return view('admissionHomePDS');
       }
       else
       {
           return view('logon');
       }
    }
    public function MatriculationNumber()
    {
                       $mat = Auth::user()->matricno;
                       $utme = "";
                     
                       $apptype = Auth::user()->apptype;
                       $isadm = Auth::user()->isadmitted;
                       $progid ="";
                       
                       if($apptype=='PT' || $apptype=='PG')
                       {
                          $utme = Auth::user()->formnumber;
                       }
                       else
                       {
                          $utme = Auth::user()->utme;
                       }
                      //dd($utme);
                           $uuid = Str::uuid()->toString() . Str::uuid()->toString();
                           $url  = config('paymentUrl.matricno_url');
                     
                           $std= DB::SELECT('CALL GetMatricNoInformation(?)',array($mat));
                           if($std)
                           {
                              //Get Programme ID 
                              if($std)  //($response->getStatusCode() == 200) 
                              {    
                                    
                                     
                                     if($std[0]->lga)
                                      {
                                        $lga=$std[0]->lga;
                                     }
                                     else
                                     {
                                      $lga ="None";
                                     }
                                     
                                    //dd($std[0]->email);
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
                                       //dd($res);
                                        if($res->status==201)
                                        {
                                            $matr = $res->data->student->matric_no;
                                            $this->UpdateMatricNo($matr);
                                           //dd($matr);
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
                                              // dd($ress);
                                               $mat =$ress->data[0]->student->matric_no;
                                               $this->UpdateMatricNo(Auth::user()->matricno,$mat);
                                           }
                                           else
                                           {
                                                DB::INSERT('CALL SaveMatricNoRequestLogger(?,?,?)',array(json_encode($ress),$utme,$mat));
                                           }
                                             ///$mat =$ress->data[0]->student->matric_no;
                                             ///$this->UpdateMatricNo($item->matricno,$mat);
                                            
                                           
                                        }
                                        else
                                        {
                                            $matr=null;
                                        }
                                       
                              } 
                                             
                            }
 
                        
    }
    public function UpdateMatricNo($mat)
    {
        $matricno = Auth::user()->matricno;
        DB::table('users')->where('matricno', $matricno)->update(['matric'=>$mat]);
        DB::table('u_g_pre_admission_regs')->where('matricno', $matricno)->update(['matric'=>$mat]);
    }
    public function GetMedicalPaymentStatus($utme)
    {
        
        $mat = Auth::user()->utme;
        $stag = DB::SELECT('CALL GetMedicalPaymentStatus(?)',array($utme));
        if($stag)
        {
          if($stag[0]->status=="1")
          {
             return true;
          }
          else
          {
              return false;
          }
       }
       else
       {
          return 0;
       }
    }
    public function AdmissionHome()
    {
        $st = $this->GetCurrentState();
        return view('admissionHome',['st'=>$st]);
    }
    public function GetCurrentState()
    {
       $matricno = Auth::user()->matricno;
       $s="";
       $sta = DB::SELECT('CALL GetCandidateState(?)',array($matricno));
        if($sta)
        {
            $s= ($sta[0]->state=='Oyo State' || $sta[0]->state=='OYO State' || $sta[0]->state=='OYO');
            if($s)
            {
                return 1;
            }
            else
            {
                 return 0;
            }
    
        }
    }
    public function UpdateStageStatus($l)
    {
        $matricno = Auth::user()->matricno;
        $res = DB::UPDATE('CALL UpdateAcceptanceRegistration(?,?)',
        array($matricno,$l));
        // dd($res);
    }
    public function UpdatePGStageStatus($l)
    {
        $matricno = Auth::user()->matricno;
        DB:: table('pgregistrationprogress')->where('matricno',$matricno)
                                            ->where('paycode',$l)
                                            ->update(['status'=>1]);
    }
    public function UpdatePDStageStatus($l)
    {
        $matricno = Auth::user()->matricno;
        DB:: table('pdsregistrationprogress')->where('matricno',$matricno)
                                            ->where('paycode',$l)
                                            ->update(['status'=>1]);
    }
    public function UpdatePTStageStatus($l)
    {
        $matricno = Auth::user()->matricno;
        DB:: table('ptregistrationprogress')->where('matricno',$matricno)
                                            ->where('paycode',$l)
                                            ->update(['status'=>1]);
                                            
    }
    public function GetActivity($ops)
    {
         //Activitylog
        $agent = new Agent();
        $plat = $agent->platform();
        $ver = $agent->version($plat);
        $pla_ver = $plat." ".$ver;
        $brw =$agent->browser();
        $b_v =$agent->version($brw);
        $brow = $brw.  " ".$b_v;
        //$brow="Chrome";
        //$pla_ver ="Window 10.0";
        $ops = Auth::user()->name. $ops;
        $ip = request()->ip();
        $ema = Auth::user()->email;
        $mat = Auth::user()->matricno;
        $mac = exec('getmac');
        $da = Carbon::now();// will get you the current date, time
        $dat= $da->format("Y-m-d:h:m:s");
        DB::INSERT('CALL ActivityTrackerLog(?,?,?,?,?,?,?,?)',array($ops,$ip,$ema,$mat,$mac,$dat,$pla_ver,$brow));
    }

}