<?php

namespace App\Http\Controllers;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Paystack;
use App\PGAdmissionRegistration;
use App\PTAdmissionRegistration;
use App\PDSRegistrationProgress;
class MyPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function PDSPayNow($id, $prod,$sid,$prefix)
    {
       //dd($id);
        if (Auth::check()) {
            $ispd = Auth::user()->ispaid;
            $isadm = Auth::user()->isadmitted;
            $client = new \GuzzleHttp\Client();
            $matricno = Auth::user()->matricno;
            $apptype = "";
            $transID = "";
           // dd($id.$prod);
            // {
                try 
                {
                    //$res = "";
                    //create payment record
                    if ($id && $prod)
                    {
                        $pt = explode(" ", $prod);
                        $pty = $prod;
                        $apptype = Auth::user()->apptype;
                        $pre = $prefix;
                        $pred = date('y')."APP";
                        $transID = $pre.$pred.strtoupper($this->randomPassword()).substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                         //Create Registration Stages
                         $ckg  = DB::table('pdsregistrationprogress')->select('matricno','stageid')
                                            ->where('matricno',$matricno)
                                            ->where('stageid',$sid)
                                            ->where('status',0)
                                            ->first();     //DB::SELECT('CALL CheckDuplicateRegistrationStatge(?,?)',array($matricno,$sid));

                         if(!$ckg)
                         {
                             $pgpro = new PDSRegistrationProgress();
                             $pgpro->matricno = $matricno;
                             $pgpro->formnumber = Auth::user()->formnumber;
                             $pgpro->stageid = $sid;
                             $pgpro->paycode = $pre;
                             $pgpro->productid = $id;
                             $pgpro->save();
                            // $stag = DB::INSERT('CALL SaveRegistrationStages(?,?,?,?)',
                           /// array($matricno,Auth::user()->utme,$sid,$pre));
                         }
                    }  
                                  
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));

                    if($prod) //($res)
                     {
                        $p = "Pending";
                       // $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno, $prod[0]->session, $id));
                       $ck = DB::table('u_g_student_accounts')
                                                            ->where('matricno',$matricno)
                                                            ->where('session',$prod[0]->session)
                                                            ->where('productid',$id)
                                                            ->where('ispaid',0)
                                                            ->first();       

                        if (!$ck) 
                        {
                            $sav = DB::INSERT(
                                'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                            );
                            
                        } 
                        else
                         {
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?,?)', array($matricno, $prod[0]->session, $p));

                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                               
                            } else {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                                );
                                
                            }
                        }

                      
                    } else {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }
                } catch (RequestException $re) {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
          //  }
            //dd($transID);
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
           // dd($id);
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->name,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );

            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
                'User-Agent:PostmanRuntime/7.29.0'
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            //dd($res);
            // dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    public  function PTPayNow($id, $prod,$sid,$prefix)
    {
       //dd($id);
        if (Auth::check()) {
            $ispd = Auth::user()->ispaid;
            $isadm = Auth::user()->isadmitted;
            $client = new \GuzzleHttp\Client();
            $matricno = Auth::user()->matricno;
            $apptype = "";
            $transID = "";
            //if ($ispd == false)
            // {
                try 
                {
                    //$res = "";
                    //create payment record
                    if ($id && $prod)
                    {
                        $pt = explode(" ", $prod);
                        $pty = $prod;
                        $apptype = Auth::user()->apptype;
                        $pre = $prefix;
                        $pred = date('y')."AP";
                        $transID = $pre.$pred.strtoupper($this->randomPassword()).substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                         //Create Registration Stages
                         $ckg  = DB::table('ptregistrationprogress')->select('matricno','stageid')
                                            ->where('matricno',$matricno)
                                            ->where('stageid',$sid)
                                            ->first();     //DB::SELECT('CALL CheckDuplicateRegistrationStatge(?,?)',array($matricno,$sid));

                         if(!$ckg)
                         {
                             $pgpro = new PTAdmissionRegistration();
                             $pgpro->matricno = $matricno;
                             $pgpro->formnumber = Auth::user()->formnumber;
                             $pgpro->stageid = $sid;
                             $pgpro->paycode = $pre;
                             $pgpro->save();
                            // $stag = DB::INSERT('CALL SaveRegistrationStages(?,?,?,?)',
                           /// array($matricno,Auth::user()->utme,$sid,$pre));
                         }
                    }  
                                  
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));

                    if($prod) //($res)
                     {
                        $p = "Pending";
                        $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno, $prod[0]->session, $id));

                        if (!$ck == "Pending") {
                            $sav = DB::INSERT(
                                'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                            );
                            
                        } 
                        else
                         {
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?,?)', array($matricno, $prod[0]->session, $p));

                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                               
                            } else {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                                );
                                
                            }
                        }

                      
                    } else {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }
                } catch (RequestException $re) {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
          //  }
            //dd($transID);
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
           // dd($id);
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->name,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );

            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            //var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            //dd($res);
            // dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    
    public  function PGPayNow($id, $prod,$sid,$prefix)
    {
       //dd($id);
        if (Auth::check()) {
            $ispd = Auth::user()->ispaid;
            $isadm = Auth::user()->isadmitted;
            $client = new \GuzzleHttp\Client();
            $matricno = Auth::user()->matricno;
            $apptype = "";
            $transID = "";
            //if ($ispd == false)
            // {
                try 
                {
                    //$res = "";
                    //create payment record
                    if ($id && $prod)
                    {
                        $pt = explode(" ", $prod);
                        $pty = $prod;
                        $apptype = Auth::user()->apptype;
                        $pre = $prefix;
                        $pred = date('y')."AP";
                        $transID = $pre.$pred.strtoupper($this->randomPassword()).substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                         //Create Registration Stages
                         $ckg  = DB::table('pgregistrationprogress')->select('matricno','stageid')
                                            ->where('matricno',$matricno)
                                            ->where('stageid',$sid)
                                            ->first();     //DB::SELECT('CALL CheckDuplicateRegistrationStatge(?,?)',array($matricno,$sid));

                         if(!$ckg)
                         {
                             $pgpro = new PGAdmissionRegistration();
                             $pgpro->matricno = $matricno;
                             $pgpro->formnumber = Auth::user()->formnumber;
                             $pgpro->stageid = $sid;
                             $pgpro->paycode = $pre;
                             $pgpro->save();
                            // $stag = DB::INSERT('CALL SaveRegistrationStages(?,?,?,?)',
                           /// array($matricno,Auth::user()->utme,$sid,$pre));
                         }
                    }  
                                  
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));

                    if($prod) //($res)
                     {
                        $p = "Pending";
                        $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno, $prod[0]->session, $id));

                        if (!$ck == "Pending") {
                            $sav = DB::INSERT(
                                'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                            );
                            
                        } 
                        else
                         {
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?,?)', array($matricno, $prod[0]->session, $p));

                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                               
                            } else {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                                );
                                
                            }
                        }

                      
                    } else {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }
                } catch (RequestException $re) {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
          //  }
            //dd($transID);
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
           // dd($id);
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->name,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );

            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            //var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            //dd($res);
            // dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    
    public function CancelMyTransaction($tid)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check())
        {
            DB::table('u_g_student_accounts as st')->where('transactionid',$tid)->update(['response'=>'Canceled']);
            return redirect()->route('payhistory');
        }
        else
        {
            return view('logon');
        }
    }
    public function PaymentBiodatas(Request $request)
    {
       $usr = Auth::user()->usertype;
       if(Auth::check() && $usr=='Staff' || $usr=='Admin')
       {
          $utme =$request->utme;
           
          if($utme)
          {
              $ck = DB::SELECT('CALL ChekBiodataUpdatePayment(?)',array($utme));
              if($ck)
              {
                return back()->with('error', $utme. ' Already Paid');
              }
              $up =DB::UPDATE('CALL BiodataPayment(?)',array($utme));
              if($up)
              {
                return back()->with('success', 'Payment Received, Thanks!!!');
              }
              else
              {
                return back()->with('error', 'Payment Not Received, Please Retry');
              }
          }
          else
          {
              return redirect()->route('paymentBiodata');
          }
       }
       else
       {
           return view('logon');
       }
    }
    public function PaymentBiodata()
    {
       $usr = Auth::user()->usertype;
       if(Auth::check() && $usr=='Staff' || $usr=='Admin')
       {
           return  view('paymentBiodata');
       }
       else
       {
           return view('logon');
       }
    }
    public function TuitionPay(Request $request)
    {
        
        if(Auth::check())
        {
           
              if($request)
              {
                $matricno = Auth::user()->matricno;
                $prod     = $request->prod;
                $paytype  = $request->paytype;
                $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
                if($dat)
                 {
                     
                            #Tuitin Fee JUP
                      if(Auth::user()->apptype=='JUP')
                       {
                           
                            $mgsfull =18;    #FULL MGS =18
                            $msgpart =19;    #PART MSG =19
                            $sciencefull=20; #FULL SCIENCE = 20
                            $sciencepart=21; #PART SCIENCE = 21
                            $cat = DB::SELECT("CALL GetJUPEBFeeCategory(?)",array($dat[0]->category1));                 
                            if($cat && $paytype==1)
                            {
                                return redirect()->route('PayingNow',['id'=>$mgsfull,'prod'=>$prod]);
                            }
                            elseif($cat && $paytype==0)
                            {
                                return redirect()->route('PayingNow',['id'=>$msgpart,'prod'=>$prod]);
                            }
                            elseif(!$cat && $paytype==1)
                            {
                                return redirect()->route('PayingNow',['id'=>$sciencefull,'prod'=>$prod]);
                            }
                            elseif(!$cat && $paytype==0)
                            {
                            // dd($sciencepart);
                                return redirect()->route('PayingNow',['id'=>$sciencepart,'prod'=>$prod]);
                            }
                            else
                            {
                                return view('paymentHome');
                            }
                        }
                        else
                        {
                            $indfull =75;      #FULL IND =18
                            $indgpart =87;     #PART IND =87
                            $nonfull=76;       #NONIND = 20
                            $nonpart=88;       #PART NON = 88
                            $sta = DB::SELECT("CALL GetStateForPayment(?)",array($matricno));                 
                            if($sta && $paytype==1)
                            {
                                return redirect()->route('PayingNow',['id'=>$indfull,'prod'=>$prod]);
                            }
                            elseif($sat && $paytype==0)
                            {
                                return redirect()->route('PayingNow',['id'=>$indgpart,'prod'=>$prod]);
                            }
                            elseif(!$sat && $paytype==1)
                            {
                                return redirect()->route('PayingNow',['id'=>$nonfull,'prod'=>$prod]);
                            }
                            elseif(!$sat && $paytype==0)
                            {
                            // dd($sciencepart);
                                return redirect()->route('PayingNow',['id'=>$nonpart,'prod'=>$prod]);
                            }
                            else
                            {
                                return view('paymentHome');
                            }
                        }
                 }
                 
               }
               else
                {
                    return back()->with('error', ' Record Not Found, Please Try Again');
                }
        }
        else
        {
            return view('logon');
        }
    }

    public function PDSPaymentList()
    {
        $usr = Auth::user()->usertype;
       if(Auth::check() && $usr=='Staff' || $usr=='Admin')
         {
           
            $data = DB::SELECT('CALL PdsPaymentList()');
            return view('pdsPaymentList', ['data' => $data]);
        } else {
            return view('logon');
        }
    }
    public function GetPaymentRecord($id)
    {
       
        if(Auth::check())
        {
            //$data =DB::SELECT('CALL GetCategoryType(?)',array($id));
             $empData['data'] = DB::SELECT('CALL FetchPaymentHistory(?)', array($id));
             return response()->json($empData);
            
        }
        else
        {
            return view('index');
        }
    }
    public function QueryTransactAdmin($id)
    {
        if (Auth::check()) {
            $matricno = Auth::user()->matricno;

            $client = new \GuzzleHttp\Client;
            $yr =date("Y");
           // dd($id);
            try {
                $client = new \GuzzleHttp\Client();
                $url = config('paymentUrl.trans_status_url') . $id;
                DB::INSERT('CALL SaveRequestLogger(?)',array($url));
                //dd($url);
                $response = $client->request('GET', $url, ['verify' => false, 'headers' => ['token' => 'funda123']]);

              
                if ($response->getStatusCode() == 200) {
                    // $response = json_decode($guzzleResponse->getBody(),true);
                    $res = json_decode($response->getBody());

                    DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($res)));
                    //perform your action with $response 
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // you can catch here 400 response errors and 500 response errors
                // You can either use logs here use Illuminate\Support\Facades\Log;
                $error['error'] = $e->getMessage();
                $error['request'] = $e->getRequest();
                if ($e->hasResponse()) {
                    if ($e->getResponse()->getStatusCode() == '400') {
                        $error['response'] = $e->getResponse();
                    }
                }
                // Log::error('Error occurred in get request.', ['error' => $error]);
            } catch (Exception $e) {
                //other errors 
            }
           // dd($res);
        
            if ($res->status == "Approved Successful") 
            {
                 $l = substr($id,0,2);
                 if($l=="ME")
                 {
                      DB::UPDATE('CALL UpdateMedicalStatus(?,?)', array($id, $res->status));  
                     // dd("OK");

                 }
                 elseif($l=="AC")
                 {
                      DB::UPDATE('CALL UpdateAcceptanceStatus(?,?)', array($id, $res->status));  
                     // dd("OK");

                 }
                 elseif($l=="TU") 
                 {
                     DB::UPDATE('CALL UpdateTuitionStatus(?,?)',array($id,$res->status));            
                 }
                 else
                 {
                     DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($id, $res->status, $matricno));
                 }
                 
                return  redirect()->route('getTransaction');
                    
            
            } 
            else 
            {
                DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($id, $res->status, $matricno));
            }
            //$amount = ($res[0]->amount);
            return redirect()->route('getTransaction');
        } else {
            return view('logon');
        }
    }
    public function GetTransactions(Request $request)
    {
        if (Auth::check()) 
        { 
            $matricno = $request->matricno;    
            $data = DB::SELECT('CALL FetchPaymentHistory(?)', array($matricno));
            if($data)
            {
                return view('transactionList', ['data' => $data]);
            }
            else
            {
                return back()->with('error', 'Payment Details Not Found');
            }
           
        } else {
            return view('logon');
        } 
    }
    public function GetTransaction()
    {
        if (Auth::check()) 
        {     
           return view('getTransaction');
        } else {
            return view('logon');
        } 
    }
    public  function UGDPayNow($id, $prod,$sid)
    {
       //dd($id);
        if (Auth::check()) {
            $ispd = Auth::user()->ispaid;
            $isadm = Auth::user()->isadmitted;
            $client = new \GuzzleHttp\Client();
            $matricno = Auth::user()->matricno;
            $apptype = "";
            $transID = "";
            //if ($ispd == false)
            // {
                try 
                {
                    //$res = "";
                    //create payment record
                    if ($id && $prod)
                    {
                        $pt = explode(" ", $prod);
                        $pty = $pt[0];
                        $apptype = $prod;
                        $pre = strtoupper(substr($prod,0,2));
                        $pred = date('y')."APP";
                        $transID = $pre.$pred.strtoupper($this->randomPassword()).substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                         //Create Registration Stages
                         $ckg = DB::SELECT('CALL CheckDuplicateRegistrationStatge(?,?)',array($matricno,$sid));
                         if(!$ckg)
                         {
                            $stag = DB::INSERT('CALL SaveRegistrationStages(?,?,?,?)',
                            array($matricno,Auth::user()->utme,$sid,$pre));
                         }
                    }  
                    else
                    {

                    }
             
               
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));


                    if($prod) //($res)
                     {
                        $p = "Pending";
                        $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno, $prod[0]->session, $id));

                        if (!$ck == "Pending") {
                            $sav = DB::INSERT(
                                'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                            );
                            
                        } 
                        else
                         {
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?,?)', array($matricno, $prod[0]->session, $p));

                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                               
                            } else {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                                );
                                
                            }
                        }

                      
                    } else {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }
                } catch (RequestException $re) {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
          //  }
            //dd($transID);
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
           // dd($id);
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->name,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );

            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            //var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            //dd($res);
            // dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    
    public function BalancePayment()
    {
        if (Auth::check()) 
        {     
           return view('paymentBalance');
        } else {
            return view('logon');
        } 
    }
    public function PaymentList()
    {
        if (Auth::check()) {
           
            $data = DB::SELECT('CALL JupebPaymentList()');
            return view('jupebPaymentList', ['data' => $data]);
        } else {
            return view('logon');
        }
    }
    public function TuitionPayss(Request $request)
    {
        
        if(Auth::check())
        {
           
              $mgsfull =18;    #FULL MGS =18
              $msgpart =19;    #PART MSG =19
              $sciencefull=20; #FULL SCIENCE = 20
              $sciencepart=21; #PART SCIENCE = 21
              if($request)
              {
                $matricno = Auth::user()->matricno;
                $prod     = $request->prod;
                $paytype  = $request->paytype;
                $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
                if($dat)
                 {
                     
                    #Tuitin Fee
                    $cat = DB::SELECT("CALL GetJUPEBFeeCategory(?)",array($dat[0]->category1));
                   
                    if($cat && $paytype==1)
                    {
                        return redirect()->route('PayingNow',['id'=>$mgsfull,'prod'=>$prod]);
                    }
                    elseif($cat && $paytype==0)
                    {
                        return redirect()->route('PayingNow',['id'=>$msgpart,'prod'=>$prod]);
                    }
                    elseif(!$cat && $paytype==1)
                    {
                        return redirect()->route('PayingNow',['id'=>$sciencefull,'prod'=>$prod]);
                    }
                    elseif(!$cat && $paytype==0)
                    {
                       // dd($sciencepart);
                        return redirect()->route('PayingNow',['id'=>$sciencepart,'prod'=>$prod]);
                    }
                    else
                    {
                        return view('paymentHome');
                    }
                 }
                
                
               }
               else
                {
                    return back()->with('error', ' Record Not Found, Please Try Again');
                }
        }
        else
        {
            return view('logon');
        }
    }
    public function QueryTransactioning($id)
    {
        if (Auth::check()) 
        {
            $id = len($id);
            if($id > 15 || $id < 15)
            {
                  return view('logon');
            }

            $matricno = Auth::user()->matricno;
            $client = new \GuzzleHttp\Client;
            $yr =date("Y");
            try 
            {
                $client = new \GuzzleHttp\Client();
                $url = config('paymentUrl.trans_status_url') . $id;
                DB::INSERT('CALL SaveRequestLogger(?)',array($url));
                //dd($url);
                $response = $client->request('GET', $url, ['verify' => false, 'headers' => ['token' => 'funda123']]);
                if ($response->getStatusCode() == 200) 
                {
                    $res = json_decode($response->getBody());
                    DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($res)));
                    //perform your action with $response 
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // you can catch here 400 response errors and 500 response errors
                // You can either use logs here use Illuminate\Support\Facades\Log;
                $error['error'] = $e->getMessage();
                $error['request'] = $e->getRequest();
                if ($e->hasResponse()) {
                    if ($e->getResponse()->getStatusCode() == '400') {
                        $error['response'] = $e->getResponse();
                    }
                }
                // Log::error('Error occurred in get request.', ['error' => $error]);
            } catch (Exception $e) {
                //other errors 
            }
           // dd($res);
        
            if ($res->status == "Approved Successful") 
            {
                 $l = substr($id,0,2);
                 if($l=="ME")
                 {
                      DB::UPDATE('CALL UpdateMedicalStatus(?,?)', array($id, $res->status));  
                     // dd("OK");

                 }
                 elseif($l=="AC")
                 {
                      DB::UPDATE('CALL UpdateAcceptanceStatus(?,?)', array($id, $res->status));  
                     // dd("OK");

                 }
                 elseif($l=="TU") 
                 {
                     DB::UPDATE('CALL UpdateTuitionStatus(?,?)',array($id,$res->status));            
                 }
                 else
                 {
                     DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($id, $res->status, $matricno));
                 }
                 
                return  redirect()->route('paymentHome');
                    
            
            } 
            else 
            {
                DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($id, $res->status, $matricno));
            }
            //$amount = ($res[0]->amount);
            return redirect()->route('home');
        } else {
            return view('logon');
        }
    }
    public  function PayingNow($id, $prod)
    {
       //dd($id);
        if (Auth::check()) {
            $ispd = Auth::user()->ispaid;
            $isadm = Auth::user()->isadmitted;
            $client = new \GuzzleHttp\Client();
            $matricno = Auth::user()->matricno;
            $apptype = "";
            $transID = "";
            //if ($ispd == false)
            // {
                try 
                {
                    //$res = "";
                    //create payment record
                    if ($id == 15)
                    {
                        $pty = "Medical";
                        $apptype = "Medical Fee";
                        $transID = "ME21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    } 
                    elseif ($id == 17)
                    {
                        $apptype = "Acceptance Fee";
                        $pty = "Acceptance";
                        $transID = "AC21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    } 
                    elseif ($id == 18) {
                        $apptype = "Tuition Fee";
                        $pty = "Full";
                        $transID = "TU21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    }
                   elseif ($id == 19)
                    {
                        $apptype = "MSG Part Tuition Fee";
                        $pty = "Part";
                        $transID = "TUP21AP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    }
                    elseif ($id == 20)
                    {
                        $apptype = "Science Full Tuition Fee";
                        $pty = "Full";
                        $transID = "TUF21AP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    }
                    elseif ($id == 21)
                    {
                        $apptype = "Part Tuition Fee";
                        $pty = "Part";
                        $transID = "TUP21AP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    }
                    else
                    {

                    }
             
               
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));


                    if($prod) //($res)
                     {
                        $p = "Pending";
                        $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno, $prod[0]->session, $id));

                        if (!$ck == "Pending") {
                            $sav = DB::INSERT(
                                'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                            );
                            
                        } 
                        else
                         {
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?,?)', array($matricno, $prod[0]->session, $p));

                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                               
                            } else {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                                );
                                
                            }
                        }

                      
                    } else {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }
                } catch (RequestException $re) {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
          //  }
            //dd($transID);
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
           // dd($id);
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->name,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );

            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
           // dd($resp);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            //var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            //dd($res);
            // dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    public function PayHome()
    {
        if (Auth::check()) {
          
            $matricno = Auth::user()->matricno;
            $status ="Student";
            DB::UPDATE('CALL UpdateCandidateStatus(?,?)',array($matricno,$status));
            return view('paymentHome');
        } else 
        {
            return view('logon');
        }
    }
    public  function PayNow($id, $prod)
    {
       
        if (Auth::check()) {
            $ispd = Auth::user()->ispaid;
            $isadm = Auth::user()->isadmitted;
            $client = new \GuzzleHttp\Client();
            $matricno = Auth::user()->matricno;
            $apptype = "";
            $transID = "";
            if ($ispd == false) {
                try {
                    //$res = "";
                    //create payment record
                    if ($id == 1) {
                        $apptype = "PDS";
                        $pty="PDS-App";
                        $transID = "PD21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    } elseif ($id == 6) {
                        $apptype = "JUP";
                         $pty="JUP-App";
                        $transID = "JP21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
                    }
                    elseif($id=="10")
                    {
                         $apptype = "UGD";
                         $pty="UGD-App";
                         $transID = "UGD21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
               
                    }
                    elseif($id=="14")
                    {
                        //dd($id);
                        $apptype = "DE";
                        $pty="DE-App";
                        $transID = "DE21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
               
                    }
                    elseif($id=="12")
                    {
                        $apptype = "TRF";
                        $pty="TRF-App";
                        $transID = "TRF22APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
               
                    }
                    elseif($id=="8")
                    {
                        $apptype = "PT";
                        $pty="PT-App";
                        $transID = "PT21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
               
                    }
                    elseif($id=="9")
                    {
                        $apptype = "PG";
                        $pty="PG-App";
                        $transID = "PG21APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
               
                    }
                    elseif($id=="92")
                    {
                        $apptype = "UGD";
                        //$apptype = "CHP";
                        $pty="Change Perogramme";
                        $transID = "CP22APP" . strtoupper($this->randomPassword()) . substr(mt_rand(1111, 99999999) . mt_rand(1111, 9999) . mt_rand(1111, 9999), 1, 2);
               
                    }
                    /*
                        $url   = config('paymentUrl.product_id_url');   
                        $response =$client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
                        $res = json_decode($response->getBody());
                        $amount = ($res[0]->amount);
                        */
                    $prod    = DB::SELECT('CALL GetApplicationListByID(?)', array($id));


                    if ($prod) //($res)
                    {
                        $p = "Pending";
                        $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno, $prod[0]->session, $id));

                        if (!$ck == "Pending") {
                            $sav = DB::INSERT(
                                'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                            );
                            
                            
                           // DB::UPDATE('CALL UpdateAppTypeStatus(?,?)', array($matricno, $apptype));
                            DB::table('users')
                                        ->where('matricno', $matricno)
                                        ->update(['apptype'       => $apptype]);
                            
                            
                        } else {
                            #Get Pending Transaction ID
                            $tra     = DB::SELECT('CALL GetPendingTransactionID(?,?,?)', array($matricno, $prod[0]->session, $p));

                            if ($tra) 
                            {
                                $transID = $tra[0]->transactionid;
                                //DB::UPDATE('CALL UpdateAppTypeStatus(?,?)', array($matricno, $apptype));
                                  DB::table('users')
                                        ->where('matricno', $matricno)
                                        ->update(['apptype'       => $apptype]);
                            } else {
                                # code...
                                $sav = DB::INSERT(
                                    'CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?,?)',
                                    array($matricno, $prod[0]->session, $prod[0]->name, $prod[0]->amount, $id, $transID, $apptype,$pty)
                                );
                                
                                //DB::UPDATE('CALL UpdateAppTypeStatus(?,?)', array($matricno, $apptype));
                                  DB::table('users')
                                        ->where('matricno', $matricno)
                                        ->update(['apptype'       => $apptype]);
                            }
                        }

                        /*
                             $ck = DB::SELECT('CALL CheckDuplicatedStudentPaymentAccount(?,?,?)', array($matricno,$res[0]->session,1));
                             if(!$ck)
                             {
                                $sav = DB::INSERT('CALL CreateStudentPaymentAccount(?,?,?,?,?,?,?)', 
                                array($matricno,$res[0]->session,$res[0]->name,$res[0]->amount,1,$transID,$apptype));
                                 DB::UPDATE('CALL UpdateAppTypeStatus(?,?)',array($matricno,$apptype));
                             }
                             */
                    } else {
                        //return redirect()->route('home');
                        return back()->with('error', 'Payment Details Not Found,
                             Invalid Payment Parameters Supplied For ' . $prod);
                    }
                } catch (RequestException $re) {
                    return back()->with('error', 'Payment Gateway Temporarily Not Available For ' . $prod .
                        '. Please Try Again Later!');
                }
            }

            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');
            //dd($url);
            //dd(config('paymentUrl.returning_url'));
            $parameters = array(
                "product_id" => $id,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->name,
                "user_number_desc" => "Full Name",
                "returning_url" => config('paymentUrl.returning_url') . $uuid,
            );
           //dd($parameters);
            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($parameters)));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
           
            //var_dump($resp);
            DB::INSERT('CALL SaveRequestLogger(?)',array($resp));
            $res = json_decode($resp);
            //dd($res);
            // dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    public function PaymentTracker()
    {
        if (Auth::check()) {
            $matricno = Auth::user()->matricno;
            $data = DB::SELECT('CALL 	FetchPaymentHistory(?)', array($matricno));
            return view('payhistory', ['data' => $data]);
        } else {
            return view('logon');
        }
    }
    public function QueryTransaction($id)
    {
        if (Auth::check()) {
            $matricno = Auth::user()->matricno;
            $client = new \GuzzleHttp\Client;
            $yr =date("Y");
           // dd($id);
            try {
                $client = new \GuzzleHttp\Client();
                $url = config('paymentUrl.trans_status_url') . $id;
                DB::INSERT('CALL SaveRequestLogger(?)',array($url));
                //dd($url);
                $response = $client->request('GET', $url, ['verify' => false, 'headers' => ['token' => 'funda123']]);

              
                if ($response->getStatusCode() == 200) {
                    // $response = json_decode($guzzleResponse->getBody(),true);
                    $res = json_decode($response->getBody());

                    DB::INSERT('CALL SaveRequestLogger(?)',array(json_encode($res)));
                    //perform your action with $response 
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // you can catch here 400 response errors and 500 response errors
                // You can either use logs here use Illuminate\Support\Facades\Log;
                $error['error'] = $e->getMessage();
                $error['request'] = $e->getRequest();
                if ($e->hasResponse()) {
                    if ($e->getResponse()->getStatusCode() == '400') {
                        $error['response'] = $e->getResponse();
                    }
                }
                // Log::error('Error occurred in get request.', ['error' => $error]);
            } catch (Exception $e) {
                //other errors 
            }
           // dd($res);
        
            if ($res->status == "Approved Successful") 
            {
               
                $apptype = Auth::user()->apptype;
                $frm =Auth::user()->formnumber;

                $sav = DB::UPDATE('CALL UserIspaidStatus(?,?)', array($res->trans_ref, $res->status));
                
                
                if ($sav) 
                {
                     if(!$frm || $frm==null)
                     {
                        #Assign form number and update same
                        DB::UPDATE('CALL GetFormNumber(?,?)',array($matricno,$apptype));
                        return  redirect()->route('ugbiodata');
                     }
                }
            } 
            else 
            {
                DB::UPDATE('CALL UpdatePaymentQueryResponse(?,?,?)', array($id, $res->status, $matricno));
            }
            //$amount = ($res[0]->amount);
            return redirect()->route('home');
        } else {
            return view('logon');
        }
    }
    public function MakePayment(Request $request)
    {
        if (Auth::check()) {
            $transID = $request->input('transID');
            //dd($transID);
            //dd($transID);
            $uuid = Str::uuid()->toString();
            $url = config('paymentUrl.make_request_url');    //"http://qualitouchaviation.com/app/api/request/";
            /*
	    $client = new \GuzzleHttp\Client();
            $URL ='http://qualitouchaviation.com/app/api/request/';   
            $res = $client->request('POST', $url, ['allow_redirects' => true,
                                                 'headers' => [ 'token' => 'funda123'],
                                                 'json' => [
                                                             'returning_url' => 'https://pds.unified.education/confirmPay',
                                                             'trans_ref'=>12312312312312,
                                                             'product_id' =>1,
                                                             'user_number'=>Auth::user()->matricno,
                                                             'user_email'=>Auth::user()->email
                                                             ]
                                                            ]);
                                                        
         dd($res->getStatusCode());
         $res1 = json_decode($res);
         dd($res1);
		*/
            $ul = config('paymentUrl.returning_url');
            //dd($ul);
            $parameters = array(
                "product_id" => 1,
                "trans_ref" => $transID,
                "user_email" => Auth::user()->email,
                "user_number" => Auth::user()->matricno,
                "returning_url" => $ul,
            );
            $p = http_build_query($parameters);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $p);

            $headers = array(
                "token: funda123",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $resp = curl_exec($curl);
            curl_close($curl);
            //var_dump($resp); die();
            $res = json_decode($resp);
            //dd($res->trans_ref);
            //Update With Transaction ID
            $sav  = DB::UPDATE('CALL UpdateReturningTransactionID(?,?,?)', array($res->trans_ref, $res->trans_id, $uuid));
            //dd($sav);
            $URL = config('paymentUrl.payment_url');
            //dd($URL);
            if ($sav > 0) {
                return redirect()->away($URL . $res->trans_id);
            } else {
                return redirect()->away($URL . $res->trans_id);
            }
        } else {
            return view('logon');
        }
    }
    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        //return implode($pass); //turn the array into a string
        return implode($pass);
    }
    public function confirmPay(Request $request)
    {
        $sta = false;

        try {

            $transID = $request->input('trans_ref');
            $response = $request->input('status');
            if ($response == "Successful") {
                $sta = true;
            } else {
                $sta = false;
            }

            $ups = DB::SELECT('CALL UpdateStudentPaymentAccount(?,?,?)', array($transID, $response, $sta));
            if ($ups) {
                return view('confirmPay', ['transID' => $transID, 'response' => $response]);
            } else {
                return view('confirmPay', ['transID' => $transID, 'response' => $response, 'sta' => $sta]);
            }
        } catch (RequestException $re) {
        }
    }
    public function redirectToGateway()
    {
        // $o="ok";
        //dd($o);
        return Paystack::getAuthorizationUrl()->redirectNow();
    }
    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        //dd($paymentDetails);      
        ///Update payment record
        if ($paymentDetails['data']['status'] == "success") {
            // $amt =
            $up = DB::Table('payment_subscriptions')->where('paymentRef', $paymentDetails['data']['reference'])
                ->update([
                    'IsSuccess' => "1",
                    'IsPaid' => '1',
                    'reference' => $paymentDetails['data']['reference'],
                    'customer_ID' => $paymentDetails['data']['customer']['id'],
                    'credit' => ($paymentDetails['data']['amount']) / 100,
                    'amount' => ($paymentDetails['data']['amount']) / 100
                ]);
            //dd($paymentDetails['data']['customer']['id']);

            return  redirect()->route('home');
            // Now you have the payment details,
            // you can store the authorization_code in your db to allow for recurrent subscriptions
            // you can then redirect or do whatever you want
        } else {

            $up = DB::Table('payment_subscriptions')->where('paymentRef', $paymentDetails['data']['reference'])
                ->update([
                    'IsSuccess' => "0",
                    'IsPaid' => '1',
                    'reference' => $paymentDetails['data']['reference'],
                    'customer_ID' => $paymentDetails['data']['customer']['id'],
                    'credit' => ($paymentDetails['data']['amount']) / 100,
                    'amount' => ($paymentDetails['data']['amount']) / 100
                ]);
        }
    }
    public function ViewWalletDetails($id)
    {
    }
    public function WalletDeposit(Request $request)
    {
        if (Auth::check()) {
        } else {
            return view('logon');
        }
    }
    public function wallet()
    {
        if (Auth::check()) {
            $matricno = Auth::user()->matricno;
            $data  =  DB::SELECT('CALL FetchWalletDeposit(?)', array($matricno));
            return view('wallet', ['data' => $data]);
        } else {
            return view('logon');
        }
    }
    public function Tuitions()
    {
        if (Auth::check()) {
            $ses = DB::SELECT('CALL FetchSession()');
            $lev = DB::SELECT('CALL FetchLevel()');
            $prog = DB::SELECT('CALL FetchProgramme()');
            return view('payfee', ['ses' => $ses, 'lev' => $lev, 'prog' => $prog]);
        } else {
            return view('logon');
        }
    }
    public function Paying(Request $request)
    {
        $amt = 0;
        $cat = "";
        if (Auth::check()) {
            $mat = Auth::user()->matricno;

            $ses = $request->input('session');
            $lev = $request->input('level');
            $pro = $request->input('programme');
            $opt = $request->input('payoption');
            $pty = $request->input('paymenttype');

            $qry = DB::SELECT('CALL GetStudentInfoByState(?)', array($mat));
            // dd($qry);
            if ($qry[0]->state == 'OYO' || $qry[0]->state == 'Oyo'  || $qry[0]->state == 'oyo') {
                $cat = "Indigene";
            } else {
                $cat = "General";
            }

            //dd($pty);
            $rec = DB::SELECT('CALL GetPaymentInfo(?,?,?)', array($ses, $pty, $cat));

            //dd($rec[0]->amount);
            if ($rec) {
                if ($rec[0]->paymenttype == 'Tuition') {
                    if ($opt == 0) {
                        $amt = $rec[0]->amount;
                    } else {
                        $amt = ($rec[0]->amount) / 2;
                    }
                } else {
                    //dd($opt);
                    $amt = $rec[0]->amount;
                }

                // dd($amt);

                return view('payfee', [
                    'amt' => $amt,
                    'pty' => $pty,
                    'pro' => $pro,
                    'lev' => $lev,
                    'ses' => $ses,
                    'opt' => $opt,
                    'cat' => $cat
                ]);
            } else {
            }
        } else {
            return view('logon');
        }
    }
    public function PrePayment()
    {
        if (Auth::check()) {
            $pro = session('Dept');
            $prog = DB::SELECT('CALL GetProgrammeByProgramme(?)', array($pro));
            $lev = DB::SELECT('CALL FetchLevel()');
            $ses = DB::SELECT('CALL FetchSession()');
            $pty = DB::SELECT('CALL GetDistinctPaymentType()');
            $pt = DB::SELECT('CALL FetchPaymentOptions()');
            return view('prePay', ['ses' => $ses, 'lev' => $lev, 'prog' => $prog, 'pty' => $pty, 'pt' => $pt]);
        } else {
            return view('logon');
        }
    }
    public function DeletePayment($id)
    {

        if (Auth::check()) {
            DB::DELETE('CALL DeletePaymentSetup(?)', array($id));
            return redirect()->route('paymentSetup');
        } else {
            return view('logon');
        }
    }
    public function PayingHome(Request $request)
    {
        if (Auth::check()) {
            $cat = $request->input('category');
            $ses = $request->input('session');
            $pty = $request->input('paymenttype');
            $des = $request->input('description');
            $amt = $request->input('amount');

            if ($request) {
                $sav = DB::INSERT('CALL SavePaymentSetup(?,?,?,?,?)', array($ses, $cat, $des, $pty, $amt));
                if ($sav) {
                    return back()->with('success', 'Record Saved Successfully');
                }
            } else {
                return back()->with('error', 'Operation Failed, Please Try Again');
            }
        } else {
            return view('logon');
        }
    }
    public function PayHomes()
    {
        if (Auth::check()) {
            $ses = DB::SELECT('CALL FetchSession()');
            $cat = DB::SELECT('CALL FetchPaymentCategory()');
            $pty = DB::SELECT('CALL FetchPaymentType()');
            $data = DB::SELECT('CALL FetchPaymentSetup()');
            return view('paymentSetup', ['data' => $data, 'ses' => $ses, 'cat' => $cat, 'pty' => $pty]);
        } else {
            return view('logon');
        }
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
