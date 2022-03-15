<?php

namespace App\Http\Controllers;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use App\Exports\ExportPDSJUPApps;
use App\Exports\ExportRequestLogger;
use Maatwebsite\Excel\Facades\Excel;
use App\LdaapInfo;
use App\LdaapApps;
class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @retur
     *n \Illuminate\Http\Response
     */
    public function UpdateBiodateInfo($mat)
    {
        try
        {
          $client = new \GuzzleHttp\Client();
          $url    = config('paymentUrl.student_biodata_update').$mat;     
          $response =$client->request('GET', $url, ['verify'=>false,'headers' => [ 'token' => 'funda123']]);
          
            if ($response->getStatusCode() == 200) 
            {    
                 $res = json_decode($response->getBody());       
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
           //other errors 
        }
    }
    public function ActiveUsers()
    {

        #LAAP Apps
        try
        {
            $client = new \GuzzleHttp\Client();
            $AppToken ="eyJOPb1aSSJVOlOBpyUo1u2OK9f2phyH4kdK.eyJ4K96nRJEG0Eqr3NotAXNsci49SXPnMEpdsTB87frPgfa4ZdlOorN.UnM2fdjqgltKb5TuuOL4B3b1a72Xh5dBWi1biyTP";
            $AccessToken ="zh8o1sxdIp0xHatJAmeFHQEXmTmGzped6xhTipZ1b72uEGRsafQjvyomIivg43s6";
    
            $url = "https://ldaas.lautech.edu.ng/api/programmes";
            $headers = 
            [
                        'App-token' => $AppToken,    
                        'Access-token'=>$AccessToken,    
                        'Accept'        => 'application/json',
            ];     
            $response =$client->request('GET', $url, [ 'verify'=>false,'headers' =>$headers ]);  
            if ($response->getStatusCode() == 200) 
            {    
                $c=0;
                $res = json_decode($response->getBody()); 
               // dd($res);
                $data = $res->data;
               
                 foreach($data as $item)
                 {
                        //dd($item);
                        $ck = DB::table('ldaapapps')->where('appid',$item->id)
                                                      ->first();
                       // if($item->faculty->programmeid==1)
                       // {
                            if(!$ck)
                            {             
                                    $ldp = new LdaapApps();
                                    $ldp->appid = $item->id;
                                    $ldp->name =$item->name;
                                    $ldp->save();
                                    ++$c;
                            }
                            else
                            {
                               $up = DB::table('ldaapapps')->where('appid',$item->id)
                                                           ->update(['name'=>$item->name
                                                                
                                                               ]);
                                if($up)
                                {
                                    ++$c;
                                }
                            }
                       // }
                 } 
          
                return $c. ' Record Inserted Successfully';
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
        /// Log::error('Error occurred in get request.', ['error' => $error]);
        }
        catch(Exception $e)
        {
        //other errors 
        }
        #LDAAP API Departments
        try
            {
                $client = new \GuzzleHttp\Client();
                $AppToken ="eyJOPb1aSSJVOlOBpyUo1u2OK9f2phyH4kdK.eyJ4K96nRJEG0Eqr3NotAXNsci49SXPnMEpdsTB87frPgfa4ZdlOorN.UnM2fdjqgltKb5TuuOL4B3b1a72Xh5dBWi1biyTP";
                $AccessToken ="zh8o1sxdIp0xHatJAmeFHQEXmTmGzped6xhTipZ1b72uEGRsafQjvyomIivg43s6";
        
                $url = "https://ldaas.lautech.edu.ng/api/departments";
                $headers = 
                [
                            'App-token' => $AppToken,    
                            'Access-token'=>$AccessToken,    
                            'Accept'        => 'application/json',
                ];     
                $response =$client->request('GET', $url, [ 'verify'=>false,'headers' =>$headers ]);  
                if ($response->getStatusCode() == 200) 
                {    
                    $c=0;
                    $res = json_decode($response->getBody()); 
                   // dd($res);
                    $data = $res->data;
                   
                     foreach($data as $item)
                     {
                            //dd($item);
                            $ck = DB::table('ldaasinfo')->where('appid',$item->faculty->programme_id)
                                                        ->where('departmentid',$item->id)
                                                         ->first();
                           // if($item->faculty->programmeid==1)
                           // {
                                if(!$ck)
                                {             
                                        $ldp = new LdaapInfo();
                                        $ldp->appid = $item->faculty->programme_id;
                                        $ldp->departmentid =$item->id;
                                        $ldp->department   =$item->name;
                                        $ldp->facultyid    =$item->faculty_id;
                                        $ldp->faculty      =$item->faculty->name;
                                        $ldp->save();
                                        ++$c;
                                }
                                else
                                {
                                   $up = DB::table('ldaasinfo')->where('departmentid',$item->id)
                                                               ->update(['department'=>$item->name,
                                                                    'faculty'=>$item->faculty->name
                                                                   ]);
                                    if($up)
                                    {
                                        ++$c;
                                    }
                                }
                           // }
                     } 
              
                    return $c. ' Record Inserted Successfully';
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
            /// Log::error('Error occurred in get request.', ['error' => $error]);
            }
            catch(Exception $e)
            {
            //other errors 
            }
  
      
        ##Servicepoint API
        try
            {
            $client = new \GuzzleHttp\Client();
            $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZjdmZDJmY2I1NjQ3MjUwYmUwZDJkOGRjMjlhYjRjMjk3OWE2MGMyMDUwZWRlY2M1YjYxZDg1NGI2MTYxMzJjMWM4ZDdkZDBiY2ZmZGVlNDMiLCJpYXQiOjE2NDYyMzU3NjkuNjAyMDg4LCJuYmYiOjE2NDYyMzU3NjkuNjAyMTAzLCJleHAiOjE2Nzc3NzE3NjkuNDIwNTM1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.OS0b1xDSO3EEwiFtDxr8cbg4gm46gQHDeP0yaly5h6v3stzArg1Kgafun4Zg22Er7jFJJP5HGTBVwZlzJvhOVDaz09O4dgnySAJ4vJVNGgEgAIT-ziVKypOjyYRwjC7V7af_WM8HfAP-Rk0maseunaWku1mMF1A9Scc8y6opmqbJ0qhlnVDfJFNDCBmiu2rMzIymByzOSwG9RwDTJ_PdR_QtXxLN70JxDKeLDUyRpnXKOhvzLIOGKDv911xJ8758HNwD5VouiojPXbkd5NWnfU7bAnrFGyRKDdh4Na1ZZ8_35EbEDRmMTThJ_h3lWN1xdEOByWlZXtbn3UzajlvlOzXFDyJheOeyVylZpuiI2e6rumulFKTHI1b8bsuQFeIOnrrcIRyE_zNnhVF-x16baN3lKB-0oDMQgOtvO-OVvyLT-IHf9rHxeAr0aXxTKvsoUCZwPTctjXTloqn75s-mwpVEE-Cbym8jX7lyk8Trx1757U560qRkHkBcRn07oYU8Pja_ewONLQMeTMlmuqIsdD16sM8xW_QrM96zrHJn3EUuVsSkGhMhhgCXQy-NOGxeHogbocNMLkakZdi478cZZ_VPZyOvHzz9YOt1M3B8K1w7KRmv8aMMXxDAqWhykZ1_n5E_9RLzH-VniOZepWS6pkv21B3RDW45fmunBFSjebo";
            $url    = "http://localhost:8000/api/v1/PTStudent/";
                $headers = 
                [
                            'Authorization' => 'Bearer ' . $token,        
                            'Accept'        => 'application/json',
                ];     
                $response =$client->request('GET', $url, [ 'verify'=>false,'headers' =>$headers ]);  
                if ($response->getStatusCode() == 200) 
                {    
                    $res = json_decode($response->getBody());             
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
            /// Log::error('Error occurred in get request.', ['error' => $error]);
            }
            catch(Exception $e)
            {
            //other errors 
            }
  
       
       
        /*
      $lo = DB::table('loaddata')->get();
      
      $url = "https://apply.lautech.edu.ng/api/v1/UpdateStudentBiodataInfo";
      $ch = curl_init($url);
     
      $payload = json_encode($lo);
      curl_setopt( $ch, CURLOPT_POSTFIELDS,$payload);
    
      curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      
      $result = curl_exec($ch);
      curl_close($ch);
     
      dd($result);
      */

        $users = User::select("*")
                        ->whereNotNull('last_seen')
                        ->orderBy('last_seen', 'DESC')
                        ->paginate(10);
         return view('activeUsers',['data'=>$users]);

    }
    public function SendEmails(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $c=0;
           if($request)
           {
               $apptype = $request->apptype;
               $message = $request->message;
               $subject = $request->subject;
               $result = DB::table('users')->select('email','name')
                                           ->where('apptype',$apptype)
                                           ->where('ispaid',1)
                                           ->get();                                     
              foreach($result as $item)
              {
                 
                             $parameters =
                                '{
                                    "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                                    "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                                    "to": [ { "email_address": { "address": "'.$item->email.'", "name": "'.$item->name.'" }}],
                                    "reply_to":[{"address": "webmaster@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                                    "subject": "'.$subject.'",
                                    "textbody": "Thank you for signifying interest in LAUTECH Admissions.:",
                                    "htmlbody": "<html><body>Dear Sir/Ma, '.strtoupper(Auth::user()->name ).', '.$message.'</h1></body></html>",
                                }';
                            
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,"https://api.zeptomail.com/v1.1/email");
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $headers = array();
                        $headers[] = 'Accept: application/json';
                        $headers[] = 'Content-Type: application/json';
                        $headers[] = 'Authorization:Zoho-enczapikey wSsVR60k+R74Wv11nDOuI+hpyl1UBlv0HEl90FTy4nb1GaiT9sc+xhCaDQX1T/QfFWM4RTEWpLkukB9U2jdc290sw18FDyiF9mqRe1U4J3x17qnvhDzOXW5YkhKBL4gOxgponWhpEMEk+g==';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $server_output = curl_exec ($ch);
                        var_dump($server_output);
                        curl_close ($ch);
               
               }
                   
           
           }
        }  
        else
        {
            return view('logon');
        }
    }
    public function SendEmail()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $data = DB::table('users')
                        ->select('apptype')
                        ->distinct('apptype')
                        ->where('apptype','<>',"")
                        ->whereRaw('LENGTH(apptype) <=3')
                       
                        ->get();
           // dd($data);
            return view('sendEmail',['data'=>$data]);
        }  
        else
        {
            return view('logon');
        }
    }
    public function CanceledTransaction($tid)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            DB::table('u_g_student_accounts as st')->where('transactionid',$tid)->update(['response'=>'Canceled']);
            return redirect()->route('cancelTransactionList');
        }  
        else
        {
            return view('logon');
        }
    }
    public function CancelTransactionList()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
          ///  DB::table('u_g_student_accounts as st')->where('transactionid',$tid)->update(['response'=>'Canceled']);
            return view('cancelTransactionList');
        }  
        else
        {
            return view('logon');
        }
    }
    public function CancelTransactions(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
           $utme = $request->utme;
          
           $data  = DB::table('u_g_student_accounts as st')
                   ->select('st.matricno','st.session','st.description','st.referenceID','st.amount','st.ispaid','st.status',
                   'productID','transactionID','trans_id','response','st.created_at')
                   ->join('users as us','us.matricno','=','st.matricno')
                   ->where('utme',$utme)          
                   ->orderby('created_at','desc')
                   ->get();
            //dd($data);   
                if($data)     
                {
                    return view('cancelTransactionList', ['data' => $data]);
                }
                else
                {
                    return back()->with('error', 'Operation Failed. Please Try Again');
                }
          
        }
        else
        {
            return view('logon');
        }
    }
    public function CancelTransaction()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            return view('cancelTransaction');
        }
        else
        {
           return view('logon');
        }
    }
    public function AssignMatricNo()
    {
        $usr = Auth::user()->usertype;
        $client = new \GuzzleHttp\Client();
        $mat = Auth::user()->matricno;
        $utme = Auth::user()->utme;
        $email="olatemiji@gmail.com";
        $c=0; $n=0;

        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        { 
                 $med = DB::table('ugregistrationprogress')
                           ->select('matricno','utme','status','created_at')
                           ->where('stageid','4')
                           ->where('status','1')
                           ->orderby('created_at','asc')
                           ->get();
            //dd($med);
             #Begin MatricNo Assignment
               foreach($med as $item)
               {
                 // dd($item->matricno);
                 $c++; 
                        $uuid = Str::uuid()->toString() . Str::uuid()->toString();
                        $url = config('paymentUrl.matricno_url');
                 
                        $std= DB::SELECT('CALL GetMatricNoInformation(?)',array($item->matricno));
                       // dd($std);
                        if($std)
                        {
                            if(!$std[0]->matric || $std[0]->matric == null)
                            {
                            //Get Programme ID 
                              $url_prog = config('paymentUrl.programmeid_url').$std[0]->department;
                              //dd($url_prog);
                                $response = $client->request('GET', $url_prog, ['headers' => [ 'Access-Token' => 'zh8o1sxdIp0xHatJAmeFHQEXmTmGzped6xhTipZ1b72uEGRsafQjvyomIivg43s6']]);
                                if($response->getStatusCode() == 200) 
                                {    
                                        $res     = json_decode($response->getBody());
                                       // dd($res);
                                        foreach($res->data as $items)
                                        {
                                            if($items->faculty->programme->name=="Undergraduate")
                                            {
                                                $app_token = $items->faculty->programme->app_token;
                                                $progid = $items->faculty->id; 
                                            }
                                        }
                                         if($std[0]->lga)
                                         {
                                             $lga=$std[0]->lga;
                                         }
                                         else
                                         {
                                            $lga ="None";
                                         }
                                         $phone  = mt_rand(10000000000,99999999999);
                                       //  dd($phone);
                                        $parameters =
                                                '{
                                                    "firstname":"'.$std[0]->firstname.'",
                                                    "surname": "'.$std[0]->surname.'",
                                                    "othername":"'.$std[0]->othername.'",
                                                    "gender" :  "'.$std[0]->gender.'",
                                                    "lga" :"'.$lga.'",
                                                    "state" : "'.$std[0]->state.'",
                                                    "nationality":"Nigeria",
                                                    "department_id":"'.$std[0]->departmentid.'",
                                                    "admission_mode":"UTME",
                                                    "marital_status" : "'.$std[0]->maritalstatus.'",
                                                    "religion":  "'.$std[0]->religion.'",
                                                    "email":     "'."a".$c.$std[0]->email.'",
                                                    "phone":     "'.$phone.'",
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
                                           
                                            DB::INSERT('CALL SaveMatricNoRequestLogger(?,?,?)',array($parameters,$std[0]->utme,$std[0]->matricno));
                                            DB::INSERT('CALL SaveMatricNoRequestLogger(?,?,?)',array(json_encode($server_output),$std[0]->utme,$std[0]->matricno));
                                         
                                          //dd($res);
                                                if($res->status==201)
                                                {
                                                    $matr = $res->data->student->matric_no;
                                                    $this->UpdateMatricNo($item->matricno,$matr);
                                                    //dd($matr);
                                                    $n++;
                                                }   
                                                elseif($res->status==203)
                                                {
                                                    #Pass email address to get matricno
                                                    $urlinfo = config('paymentUrl.student_url').$email;
                                                    $response = $client->request('GET', $urlinfo, ['headers' => [ 'Access-Token' => 'zh8o1sxdIp0xHatJAmeFHQEXmTmGzped6xhTipZ1b72uEGRsafQjvyomIivg43s6']]);
                                                    if($response->getStatusCode() == 200) 
                                                    {    
                                                      $ress = json_decode($response->getBody());
                                                    }
                                                      $mat =$ress->data[0]->student->matric_no;
                                                      $this->UpdateMatricNo($item->matricno,$mat);
                                                      //dd($mat);
                                                      $n++;
                                                    
                                                }
                                                else
                                                {
                                                    $matr=null;
                                                }
                                        
                                            
                                } 
                            }                    
                                
                        }
                   
               } 
               
               return back()->with('success', $n.' Matricno Generated Successfully');

         }               
        else
        {
            return view('logon');
        }
    }
    public function UpdateMatricNo($matold,$mat)
    {
       // $matricno = Auth::user()->matricno;
        DB::table('users')->where('matricno', $matold)->update(['matric'=>$mat]);
        DB::table('u_g_pre_admission_regs')->where('matricno', $matold)->update(['matric'=>$mat]);
    }
    public function LockAccesss(Request $request)
    {
        $usr = Auth::user()->usertype; $p="";
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $apptype =$request->apptype;
            $category = $request->category;
            $lock =$request->lock;
            if($apptype=='All' && $category=='All')
            {
                $p = DB::table('users')->update(['locked'=>$lock]);
            }
            else
            {
              $p = DB::table('users')
                        ->where('apptype', $apptype)
                        ->where('usertype', $category)
                        ->update(['locked'=>$lock]);
            }
            if($p > 0)
            {
                if($lock==1)
                {
                    return back()->with('success', 'Unlocked Successfully');
                }
                else
                {
                    return back()->with('success', 'Locked Successfully');
                }
            }
            else
            {
                return back()->with('error', 'Operation Failed. Please Try Again');
            }
        }
        else
        {
            return view('logon');
        }
    }
    public function LockAccess()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        { 
                 $ap = DB::table('users')->distinct()->select('apptype')->get();
                 $cat = DB::table('users')->distinct()->select('usertype')->get();
                 return view('lockAccess',['ap'=>$ap,'cat'=>$cat]);
        }
        else
        {
            return view('logon');
        }
    }
    public function ReSenderPG()
    {
        $data = DB::SELECT('CALL FetchPGEmailSender()');
        if($data)
        {
            $url ="https:\\apply.lautech.edu.ng\logon";
            foreach($data as $item)
            {
              $parameters =
             '{
                  "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                  "from": { "address": "appman@mailx.lautech.edu.ng","name": "LAUTECH PG Admissions" },
                  "to": [ { "email_address": { "address": "'.$item->email.'", "name": "'.Auth::user()->name.'" }}],
                  "reply_to":[{"address": "webmaster@lautech.edu.ng","name": "LAUTECH Webmaster"}],
             "subject": "Lautech Post Gradurate Application Reference",
             "textbody": "Thank you for signifying interest in LAUTECH Admissions.:",
             "htmlbody": "<html><body>Dear Sir/Ma, '.strtoupper(Auth::user()->name ).'Please kindly visit https:\\apply.lautech.edu.ng\logon to resend email to your reference. When you login, click on Send Referenece from the MENU. Click on RESEND EMAIL for each reference.Please Note, This is very important to admission.   <img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"'.$url.'\">Login</a></h1></body></html>",
             }';
        
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL,"https://api.zeptomail.com/v1.1/email");
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             $headers = array();
             $headers[] = 'Accept: application/json';
             $headers[] = 'Content-Type: application/json';
             $headers[] = 'Authorization:Zoho-enczapikey wSsVR60k+R74Wv11nDOuI+hpyl1UBlv0HEl90FTy4nb1GaiT9sc+xhCaDQX1T/QfFWM4RTEWpLkukB9U2jdc290sw18FDyiF9mqRe1U4J3x17qnvhDzOXW5YkhKBL4gOxgponWhpEMEk+g==';
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             $server_output = curl_exec ($ch); 
            }
         }
    }
    public function CheckPaymentStatus($mat)
    {
        $res ="Pending";
        $client = new \GuzzleHttp\Client();
        $pd  = DB::SELECT('CALL ValidatePendingTransaction(?,?)',array($mat,$res));
        foreach($pd as $pd)
        {
            try
            {
                $url = config('paymentUrl.trans_status_url').$pd->transactionid;
                $response = $client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                $res = json_decode($response->getBody());
                DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($res)));
              
                if ($response->getStatusCode() == 200) 
                {    
                     $res = json_decode($response->getBody());       
                } 
            }
            catch(\GuzzleHttp\Exception\RequestException $e)
            {
            
               $error['error'] = $e->getMessage();
               $error['request'] = $e->getRequest();
               if($e->hasResponse())
               {
                   if ($e->getResponse()->getStatusCode() == '400')
                   {
                       $error['response'] = $e->getResponse(); 
                   }
               }
               Log::error('Error occurred in get request.', ['error' => $error]);
            }
            catch(Exception $e)
            {
               //other errors 
            }

            if($res)
            {
                if($res->status=="Approved Successful")
                    {
                                
                                    #Check if the candidate has a form number before.
                                    $ap = DB::SELECT('CALL GetUserInfoByAppType(?)', array($apptype));
                                    //dd($fnum);
                                    foreach($ap as $ap)
                                    {
                                        $sav = DB::UPDATE('CALL UserIspaidStatus(?,?)',array($pd->transactionid,$res->status));          
                                    }
                    }
                    else 
                    {
                        DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($pd->transactionid, $res->status, $mat));
                    }
            }

        }
    }
    public function DeleteBrochure(Request $request)
    {
        //dd($id);
        if(Auth::check())
         {
            $id = $request->applicant_id;
            //dd($id);
            DB::DELETE('CALL RemoveBrochureByID(?)', array($id));
            return redirect()->route('addBrochure');
         }
        else
        {
            return view('logon');
        }
    }
    public function AddBrochures(Request $request)
    {
        if(Auth::check())
        {
          $subject   =$request->subject;
          $status    = $request->status;
          $programme =$request->programmeid;
          
          $ck   = DB::SELECT('CALL 	CheckDuplicateBrochure(?,?)',array($programme,$subject));
          if($ck)
          {
            return back()->with('error', 'Subject Already Added, Try Again');
          }
          $sav  = DB::INSERT('CALL SaveBrochure(?,?,?)',array($programme,$subject,$status));
          if($sav)
          {
              return back()->with('success', 'Record Saved Successfully');
          }    
          else
          {
              return back()->with('error', 'Operation Failed, Try Again');
          }

          
        }
        else
        {
            return view('logon');
        }
    }
    public function AddBrochure()
    {
        if(Auth::check())
        {
            $sbj  = DB::SELECT('CALL FetchAdmissionSubjects()');
            $data = DB::SELECT('CALL FetchAdmissionProgramme()');
            return view('addBrochure',['data'=>$data,'sbj'=>$sbj]);
          
        }
        else
        {
            return view('logon');
        }
    }
    public function ExportRequestLogs()
    {
         $uuid = Str::uuid()->toString();
         if(Auth::check())
         {
          
             //dd($sess);
             return Excel::download(new ExportRequestLogger, $uuid.'.xlsx');
         }
         else
         {
             return view('logon');
         }
    }
    public function ExportPDSJUPApplication()
    {
        $uuid = Str::uuid()->toString();
       //  if(Auth::check())
        // {
            $a="";
             //dd($sess);
             return Excel::download(new ExportPDSJUPApps, $uuid.'.xlsx');

        // }
        // else
//{
        //     return view('logon');
       //  }
    }
    public function UTMECounter()
    {
        $data = DB::SELECT('CALL UTMECounters()');
        if($data)
        {
            return $data[0]->counter;
        }
    }
    public function UTMERegistrations()
    {
        $data = DB::SELECT('CALL UTMERegistration()');
        if($data)
        {
            return $data[0]->counter;
        }
    }
    public function ExamSets(Request $request)
    {
         //dd($id);
        
            $seaters=0; $batch =0;
            if(Auth::check())
            {
                    $etime =0; $counter =0; $mat=0;
                
                    $examtime1  = $request->input('examtime1');
                    $examtime2  = $request->input('examtime2');
                    $examtime   = $request->input('examtime');
                    $examdate   = $request->input('examdate');
                    $ses        = $request->input('session');
            
                
                    $tim = (strtotime($examtime2) - strtotime($examtime1)) / 60;
                
                    
                    //Get the number of batches by time
                    $i = round($tim/$examtime);
                    #echo $h && $m ? $h.' and '.$m : $h.$m;
                    $cap   = DB::SELECT('CALL FetchHall()');
                    //Get Total Capacity of halls
                  //  $totalseaters = DB:: SELECT('CALL GetTotalCapacityHall()');
                    //dd($i);
                    for($n=1;$n<=$i; $n++)
                    { 
                            $counter=0;
                            $mat=0;
                            $ltime = DB::SELECT('CALL GetLastestBatchingInfo(?,?)',array($examdate,$ses)) ;
                        // $m = DB::SELECT('CALL GetLastMatricNo()');
                        
                            if($ltime)
                            {
                                $rectime = Carbon::parse($ltime[0]->etime);
                                $et      = $rectime->addMinutes($request->input('examtime'));
                                $etime   = Carbon::parse($et)->format('H:i');         
                                $batime  = $ltime[0]->etime.'-'.$etime;    
                            }
                            else
                            {
                                $rectime = Carbon::parse($examtime1);
                                $et     = $rectime->addMinutes($request->input('examtime'));
                                $etime  =Carbon::parse($request->input('examtime1'))->format('H:i'); 
                                $batime =$examtime1 .'-'.Carbon::parse($et)->format('H:iA');
                            }

                            
                            foreach($cap as $item)
                            { 
                                $batch+=1;  
                            
                                //Get each hall total capacity
                            $ck = DB::SELECT('CALL CheckDuplicateExamSetup(?,?,?,?,?)', 
                            array($ses,$examdate,$etime,$n,$item->hallid));
                                            
                                
                            if(!$ck)        
                            {      
                            $sav= DB::INSERT('CALL SaveExamSetup(?,?,?,?,?)',
                            array($ses,$examdate,$etime,$n,$item->hallid));
                            $counter+=1;
                            }
                                            
                                


                            }//end of foreach loop
                    }//end of Number of batches loop
                    if($counter > 0)
                    {
                    return back()->with('success', 'Batching Created Successfully');
                    }
                    else
                    {
                        return back()->with('success', 'Operation Failed');
                    }


            }
            else
            {
                return view('logon');
            }
          
        
    }
   public function ExamSet()
   {
        //dd($id);
        if(Auth::check())
         {
            $ses =  DB::SELECT('CALL FetchSession()');
            $data = DB::SELECT('CALL FetchExamSetup()');
            return view('examSetup',['data'=>$data, 'ses'=>$ses]);
         }
        else
        {
            return view('logon');
        }
   }
    public function UpdateAppActivation($id, Request $request)
    {
         if(Auth::check())
         {
             #Number of days 
             $closedate = $request->input('closedate');
             $ids = DB::SELECT('CALL GetApplicationForClosing(?)', array($id));
             //dd($ids);
             //$date1 = new DateTime("May 3, 2012 10:38:22 GMT");
             //$date2 = new DateTime("06 Apr 2012 07:22:21 GMT");
             $date1=date_create($ids[0]->opendate);
             $date2=date_create($closedate);
             $diff=date_diff($date1,$date2);
             $ads = $diff->format("%a");
             $sav = DB::UPDATE('CALL UpdateAppClosingInfo(?,?,?)',array($closedate,$ads,$id));
             return redirect()->route('appactivation');
         }
         else
         {
 
         }
    }
     public function RemoveAppActivation($id)
     {
         //dd($id);
         if(Auth::check())
          {
            DB::DELETE('CALL DeleteAppActivation(?)', array($id));
            return redirect()->route('appactivation');
          }
         else
         {
             return view('logon');
         }
     }
    public function ActivateApp(Request $request)
    {
         if(Auth::check())
         {
             if($request)
             {
                 $cdate     = $request->input('cdate');
                 $odate     = $request->input('odate');
                 $session   = $request->input('session');
                 $appname   = $request->input('appname');
                 
                 #Get the number of Days
                 $date1=date_create($odate);
                 $date2=date_create($cdate);
                 $diff=date_diff($date1,$date2);
                 $activeday = $diff->format("%a");
 
 
                  $ck =DB::SELECT('CALL CheckDuplicatedAppActivation(?,?)',array($session,$appname));
                  if($ck)
                  {
                     return back()->with('error', 'Record Already Exist, Please Try Again');
                  }
 
                    $sav =DB::INSERT('CALL SaveApplicationOpeningInfo(?,?,?,?,?)',
                                  array($appname,$session,$odate,$cdate,$activeday));
                    if($sav)
                     {
                         return back()->with('success', 'Record Saved Successfully');
                     }
                     else
                     {
                         return back()->with('error', 'Operation Failed, Please Try Again');
                     }       
             }
         }
         else
         {
             return view('logon');
         }
 
    }
    public function OpenApp()
    {
         if(Auth::check())
         {
           $ses  =DB::SELECT('CALL FetchSession()');
           $data =DB::SELECT('CALL FetchApplicationOpenInfo()');
           $lst =DB::SELECT('CALL FetchApplicationList()');
           return view('appactivation',['data'=>$data, 'lst'=>$lst,'ses'=>$ses]);
         }
         else
         {
             return view('logon');
         }
    }
   public function UpdateCutoff($id, Request $request)
   {
        if(Auth::check())
        {
            $cut = $request->input('cutoff');
            //dd($cut);
            //$cut=80;
            $sav = DB::UPDATE('CALL UpdateCuffMake(?,?)',array($id,$cut));
            return redirect()->route('setCutoff');
        }
        else
        {

        }
   }
   public function CreateCutoff(Request $request)
   {
        if(Auth::check())
        {
           $ses    =  $request->input('session');
           $cutoff =  $request->input('cutoff');
           $ck = DB::SELECT('CALL CheckDuplicateCutoff(?)',array($ses));
           if($ck)
           {
             return back()->with('error', 'Cutoff Has Been Set For '.$ses. ' Already, Please Update It');
           }
           $sav = DB::INSERT('CALL SaveCutOffScore(?,?)',array($cutoff,$ses));     
           if($sav)
            {
                return back()->with('success', 'Record Saved Successfully');
            }
            else
            {
                return back()->with('error', 'Operation Failed, Please Try Again');
            }       
        }
        else
        {
            return view('logon');
        }
   }
   public function SetCutOff()
   {
        if(Auth::check())
        {   
            $data = DB::SELECT('CALL FetchCutOffScore()');
            $lst =  DB::SELECT('CALL FetchSession()');
            return view('setCutoff',['lst'=>$lst,'data'=>$data]);
        }
        else
        {
            return view('logon');
        }
   }
   public function ExportApplication($ses)
   {
       
        if(Auth::check())
        {
             $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            //dd($sess);
            return Excel::download(new ExportApplications($sess), $ses.'.xlsx');
        }
        else
        {
            return view('logon');
        }
   }
   public function GetCandidateData()
   {
        if(Auth::check())
        {
            $data   =   DB::SELECT('CALL FetchAllCandidateInformation()');
            return view('getCandidateData',['data'=>$data]);
        }
        else
        {
            return view('logon');
        }
   }
   public function Details($mat)
   {
        if(Auth::check())
        {
            $data   =   DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)',array($mat));
            $result =   DB::SELECT('CALL GetCandidateQualificationByMatricNo(?)', array($mat));
            return view('candidateProfile',['data'=>$data,'result'=>$result]);
        }
        else
        {
            return view('logon');
        }
   }
   public function GetCandidateInfo()
   {
        if(Auth::check())
        {
            $data = DB::SELECT('CALL FetchCandidateInformation()');

            return view('viewCandidateInfo',['data'=>$data]);
        }
        else
        {
            return view('logon');
        }
   }
   public function EnableSession($id,$sta)
   {
        $st =false;        
        if(Auth::check())
        {
            if($sta=='1')
            {
                $st='0';
            }
            else
            {
                $st='1';
            }

            //dd($st);
             $op ="Disactivate session ". $id;
             $this->GetActivity($op);
            DB::UPDATE('CALL EnableSessions(?,?)',  array($id,$st));
            return redirect()->route('createSession');
        }
       else
       {
         return view('logon');
       }
   }
    public function CreateSession(Request $request)
    {
        if(Auth::check())
         {
            if($request)
            {
               $session = $request->input('session');

                $sav = DB::INSERT('CALL SaveSession(?)', array($session));
               if($sav)
               {
                 return back()->with('success', 'Record Saved Successfully');
               }
               else
                {
                    return back()->with('error', 'Operation Failed, Try Again');
                }
            }
            else
            {
                return back()->with('error', 'Operation Failed, Try Again');
            }
         }
        else
        {
            return view('logon');
        }
    }
    public function SetSession()
    {
         if(Auth::check())
         {
            $data = DB::SELECT('CALL GetSessionByStatus()');
            return view('createSession',['data'=>$data]);
         }
        else
        {
            return view('logon');
        }
    }
   public function DeleteUsersAccount($id)
   {
      if(Auth::check())
         {
           //$rec= DB::SELECT('CALL FetchScreenExamInfoByID(?)', array($id));
          
           DB::DELETE('CALL DeleteUserAccount(?)', array($id));
           $op ="Deleted User Record ". $id;
           $this->GetActivity($op);
           return redirect()->route('uploadUserAuth');
         }
        else
        {
            return view('logon');
        }
   }
   public function SuspendUsers($id,$sta)
   {
        $st =false;        
        if(Auth::check())
        {
            if($sta=='1')
            {
                $st='0';
            }
            else
            {
                $st='1';
            }

            //dd($st);
             $op ="Supended User Account ". $id;
             $this->GetActivity($op);
            DB::UPDATE('CALL SuspendUsersAccount(?,?)',  array($id,$st));
            return redirect()->route('uploadUserAuth');
        }
       else
       {
         return view('logon');
       }
   }
    public function DeleteBatching($id)
    {
        if(Auth::check())
         {
           DB::DELETE('CALL DeleteBatchingByID(?)', array($id));
           return redirect()->route('batchingexams');
         }
        else
        {
            return view('logon');
        }
    }

public function addMinutesToTime( $time, $plusMinutes ) {

    $time = DateTime::createFromFormat( 'g:i:s', $time );
    $time->add( new DateInterval( 'PT' . ( (integer) $plusMinutes ) . 'M' ) );
    $newTime = $time->format( 'g:i:s' );

    return $newTime;
}

//$adjustedTime = addMinutesToTime( '9:15:00', 15 );
    public function ExamBatching(Request $request)
    {
        if(Auth::check())
         {
            if($request)
            {
             
                $etime =0; $counter =0;
                $examtime1 = $request->input('examtime1');
                $examtime2 = $request->input('examtime2');
                $examtime = $request->input('examtime');
                $examdate = $request->input('examdate');
                $hall  = $request->input('hall');
                $batch = $request->input('batch');
                $ses   = $request->input('session');
                //$tim = $examtime2 - $examtime1;
                //dd($examtime2);
                $tim = (strtotime($examtime2) - strtotime($examtime1) ) / 60;
                //dd($tim);
                $i = round($tim/$examtime);

               // dd($i);
              
               
                //$t = $examtime;
                //$h = floor($t/60) ? floor($t/60) .' ' : '00';
                //$m = $t%60 ? $t%60 .':00' : '';
                //$examtime = $h.":".$m;
              
                
                #echo $h && $m ? $h.' and '.$m : $h.$m;
                $cap   = DB::SELECT('CALL GetHallByName(?)',array($hall));
                //dd($examtime);
                for($k = 1;$k<=$i; ++$k)
                {
                    $counter+=1;
                  #Get latest batching info
                 $ltime = DB::SELECT('CALL GetLastestBatchingInfo(?,?,?)',array($hall,$examdate,$ses)) ;
                

                 if($ltime)
                  {
                      $rectime = Carbon::parse($ltime[0]->examtime);
                      $et = $rectime->addMinutes($request->input('examtime'));
                      $etime =Carbon::parse($et)->format('H:i');
                     // dd($etime);
                  }
                  else
                  {
                    
                     // $stime = Carbon::parse($examtime1);
                     // $et = $stime->addMinutes($request->input('examtime'));
                      //$etime = Carbon::parse($et)->format('H:i');
                      $etime = $request->input('examtime1');
                      //dd($etime);
                  }
                 
                  //dd($etime);

                  #check for multiple entry
                  $ck =DB::SELECT('CALL CheckBatchingDuplicate(?,?,?,?,?)', 
                    array($hall,
                          $examdate,
                          $etime,
                          $ses,
                          $k));
                 //dd($ck);
                  if($ck[0]->checker > 0)
                  {
                     return back()->with('error', 'Batching Information Already Exist, Try Again');
                  } 
                  $sav= DB::INSERT('CALL SaveBatchingExamination(?,?,?,?,?,?)', array($hall,$examdate,$etime,$k,$ses,$cap[0]->capacity));
                 
              }
              //dd($counter);
              if($counter==$i)
              {
                return back()->with('success', 'Record Saved Successfully');
              }
             else
              {  
                return back()->with('error', 'Operation Failed, Try Again');
              }  
           }
           else
           {
             return back()->with('error', 'Operation Failed, Try Again');
           }

        }
        else
         {
            return view('logon');
         }


    }
    public function Batching()
    {
        if(Auth::check())
         {
             $hal =  DB::SELECT('CALL FetchHall()');
             $ses =  DB::SELECT('CALL FetchSession()');
             $data = DB::SELECT('CALL FetchBatching()');
            return view('batchingexams',['hal'=>$hal, 'data'=>$data, 'ses'=>$ses]);
        }
        else
        {
            return view('logon');
        }
    }
    public function DeleteScreeningRecord($id)
    {
        if(Auth::check())
         {
           $rec= DB::SELECT('CALL FetchScreenExamInfoByID(?)', array($id));
          
           DB::DELETE('CALL DeleteScreenExamInfo(?)', array($id));
           $op ="deleted Examination Screening record id ". $id. " " .$rec[0]->examtype. ' '. $rec[0]->examdate;
           $this->GetActivity($op);
           return redirect()->route('examScreening');
         }
        else
        {
            return view('logon');
        }
    }
     public function CreateExamScreening(Request $request)
     {
        if(Auth::check())
        {
            if($request)
            {
                
                $session    = $request->input('session');
                $examtype   = $request->input('examtype');
                $examdate   = $request->input('examdate');
                $semester   = $request->input('semester');
                //dd($examdate);
                $ck = DB::SELECT('CALL CheckScreenExamInfoDuplication(?,?)', array($examtype,$session));
                if($ck)
                {
                    return back()->with('error', 'Record Already Exist, Try Again');
                }
                     
                $sav = DB::INSERT('CALL SaveScreenExamInfo(?,?,?,?)', array($examtype,$examdate,$session,$semester));
                if($sav)
                {
                    //Get Acivtity log
                    $op ="added Examination Screening record ". $examtype ."  ".$examdate ." ". $session . " ".$semester;
                    $this->GetActivity($op);
                    return back()->with('success', 'Record Saved Successfully');
                }
                else
                {
                    return back()->with('error', 'Operation Failed, Try Again');
                }

            }
        }
        else
        {
            return view('logon');
        }
     
     }
     public function ExamScreening()
     {
        if(Auth::check())
        {
            $ex = DB::SELECT('CALL FetchExaminationType()');
            $ses = DB::SELECT('CALL FetchSession()');
            $data =DB::SELECT('CALL FetchScreenExamInfo()');
          //
            //Get Acivtity log
            $op =" visited Examination Screening Page";
            $this->GetActivity($op);
            return view('examScreening',['data'=>$data, 'ex'=>$ex, 'ses'=>$ses]);
        } 
        else
        {
           return view('logon');
        }
     }
    public function SuspendHalls($id,$sta)
    {
        
        $st =false;
        if(Auth::check())
        {
            if($sta==false)
            {
              $st=true;
            }
            else
            {
                $st=false;
            }
            DB::UPDATE('CALL SuspendHall(?,?)',  array($id,$st));
            return redirect()->route('createhall');
        }
       else
       {
         return view('logon');
       }
    }
    public function DeleteHallByID($id)
    {
        if(Auth::check())
         {
           DB::DELETE('CALL DeleteHallByID(?)', array($id));
           return redirect()->route('createhall');
         }
        else
        {
            return view('logon');
        }
    }
    public function CreateHalls(Request $request)
    {
        $hall = $request->input('hall');
        $capacity = $request->input('capacity');
        if(Auth::check())
        {
          if($request)
           {
             $ck = DB::SELECT('CALL FetchHallByName(?)',array($hall ));
             if($ck)
             {
                 return back()->with('error', 'Hall Name Already Exist, Try Again');
             }
             $sav = DB::INSERT('CALL SaveHallDetails(?,?)', array($capacity, $hall));  
             if($sav)
             {
                 return back()->with('success', 'Record Saved Successfully');
             }    
             else
             {
                 return back()->with('error', 'Operation Failed, Try Again');
             }
           }
    }
    else
    {
    return view('logon');
    }
        

    }
    public function AddHall()
    {
        if(Auth::check())
        {
             $data = DB::SELECT('CALL FetchHall()'); 
             $ses = DB::SELECT('CALL FetchSession()'); 
             $op =" visited Hall Creation Page";
             $this->GetActivity($op);
             return view('createhall', ['data'=>$data, 'ses'=>$ses]);
       }
       else
       {
           return view('logon');
       }
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
        $brow="Chrome";
        $pla_ver ="Window 10.0";
        $ops = Auth::user()->name. $ops;
        $ip = request()->ip();
        $ema = Auth::user()->email;
        $mat = Auth::user()->matricno;
        $mac = exec('getmac');
        $da = Carbon::now();// will get you the current date, time
        $dat= $da->format("Y-m-d:h:m:s");
        DB::INSERT('CALL ActivityTrackerLog(?,?,?,?,?,?,?,?)',array($ops,$ip,$ema,$mat,$mac,$dat,$pla_ver,$brow));
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
