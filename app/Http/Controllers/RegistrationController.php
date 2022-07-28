<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use PDF;
use Carbon\Carbon;
use App\Mail\RegEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Sponsorship;
use App\UGParentInfo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Mail\ReferenceEmail;
use App\TrackUserApplication;
use App\TrackApplications;

//use Illuminate\Support\Facades\Validator;
//use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $batched = false;
    public function ValidatePDSJUPEB(Request $request)
    {
        if(Auth::check())
        {
            $apptype      = $request->apptype;
            $matricno     = Auth::user()->matricno;
            $formnumber   = $request->formnumber;
            $utme         = $request->utme;
            if($apptype =="UTME")
            {
                         $ck = DB::table('users')->where('utme',$utme)->first();
                         if($ck)
                         {
                            return back()->with('error','Sorry UTME No ' . $utme . ' Has Used By '. $ck->name .', Please Try Again');
                         }
                $data= DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
                if($data)
                {
                    #Update the Users 
                   
                       
                  
                            DB::table('users')
                                                    ->where('matricno', $matricno)
                                                    ->update(['utme'         => $utme,
                                                              'formnumber'   => $utme,
                                                              'apptype'      =>'UGD']);
                                                    
                            return redirect()->route('pdsjupebDataPage');
                   
                }
                else
                {
                   return back()->with('error', $utme. ' Record Not Found, Please Try Again');
                }
            }
            elseif($apptype == 'PDS')
            {
                    $cks = DB::table('utmeinfo')->where('utme',$utme)->first();
                    if(!$cks)
                    {
                      return back()->with('error','Sorry UTME No ' . $utme . ' Not Valid OR Not Found, Please Try Again');
                    }
               $data  = DB::SELECT('CALL ValidatePDS(?,?)',array($formnumber,$utme));
               $cut  = DB::SELECT('CALL ConfirmUTMECuttoff(?)',array(Auth::user()->activesession));
               if($data)
               {
                   if($cut)
                    {
                        if($data[0]->utmescore < $cut[0]->cutoff)
                        {
                            return back()->with('error','Sorry, You Do Not Have Cuttoff of '.$cut[0]->cutoff. ', Please Try Again Later');
                        }
                    }
                    else
                    {
                        return back()->with('error','Sorry, Cuttoff Cannot Be Confirmed, Please Try Again');
                    }
                    $app ="PD";
                    //$data = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
                   
                    DB::UPDATE('CALL UpdatePDSUserInfo(?,?,?)',array($matricno,$formnumber,$utme));
                    DB::UPDATE('CALL UpdateAppTypeStatus(?,?)', array($matricno, $app));
                    return redirect()->route('pdsjupebDataPage');

               }
              else
              {
                return back()->with('error', $utme . ' and  '.$formnumber. ' No Record Found, Please Try Again');
              }
           }
           elseif($apptype == 'TRF')
           {
              
                    $cks = DB::table('transferlist')->where('utme',$utme)->first();
                    if(!$cks)
                    {
                      return back()->with('error','Sorry UTME No ' . $utme . ' Not Valid OR Not Found, Please Try Again');
                    }
                   
                        $data  = DB::table('transferlist')->where('utme',$utme)->first();
                     // dd($formnumber);
                   
                        $ck = DB::table('users')->where('utme',$utme)->first();
                         if($ck)
                         {
                            return back()->with('errors','Sorry UTME No ' . $utme . ' Has Used By '. strtoupper($ck->name) .', Please Click To ');
                         }
                      if($data)
                       {
                        $app ="TRF";
                        //$data = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
                        $rec = DB::SELECT('CALL FetchStateList()');
                        $ses = DB::SELECT('CALL FetchSession()');
                        $pro = DB::SELECT('CALL FetchProgramme()');
                        $pros = DB::SELECT('CALL FetchProgramme()');
                        $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array($matricno));
                        $item = DB::SELECT('CALL FetchParentsData(?)',array($matricno));
                        //DB::UPDATE('CALL UpdatePDSUserInfo(?,?,?)',array($matricno,$formnumber,$utme));
                        DB::UPDATE('CALL UpdateAppTypeStatus(?,?)', array($matricno, $app));
                        DB::table('users')->where('matricno', $matricno)->update(['utme'=>$utme,'ispaid'=>1]);
                        DB::table('transferlist')->where('utme', $utme)->update(['status'=>1]);  
                        return redirect()->route('ugbiodata');

                      }
                       else
                       {
                        return back()->with('error', $utme . ' and  '.$formnumber. ' No Record Found, Please Try Again');
                       }
           }
            else
            {
             
                    $cks = DB::table('directentryinfo')->where('utme',$utme)->first();
                    if(!$cks)
                    {
                      return back()->with('error','Sorry UTME No ' . $utme . ' Not Valid OR Not Found, Please Try Again');
                    }
                        $data  = DB::SELECT('CALL ValidateJUPEB(?)',array($formnumber));
                     // dd($formnumber);
                        $ck = DB::table('users')->where('utme',$utme)->first();
                         if($ck)
                         {
                            return back()->with('errors','Sorry UTME No ' . $utme . ' Has Used By '. strtoupper($ck->name) .', Please Click To ');
                         }
                    if($data)
                    {
                        $app ="DE";
                        //$data = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
                        $rec = DB::SELECT('CALL FetchStateList()');
                        $ses = DB::SELECT('CALL FetchSession()');
                        $pro = DB::SELECT('CALL FetchProgramme()');
                        $pros = DB::SELECT('CALL FetchProgramme()');
                        $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array($matricno));
                        $item = DB::SELECT('CALL FetchParentsData(?)',array($matricno));
                        DB::UPDATE('CALL UpdatePDSUserInfo(?,?,?)',array($matricno,$formnumber,$utme));
                        DB::UPDATE('CALL UpdateAppTypeStatus(?,?)', array($matricno, $app));
                        DB::table('jupeblist')->where('formnumber', $formnumber)->update(['utme'=>$utme,'status'=>1]);
                        return redirect()->route('pdsjupebDataPage');

                    }
                   else
                   {
                    return back()->with('error', $utme . ' and  '.$formnumber. ' No Record Found, Please Try Again');
                   }
           }

        }
        else
        {
            return view('logon');
        }

    }
    public function PdsJupebs(Request $request)
    {
        if(Auth::check())
        {
          
            //Student Personal Biodata
            $surname = $request->input('surname');
            $session = $request->input('session');
            $firstname = $request->input('firstname');
            $othername = $request->input('othername');
            $matricno = Auth::user()->matricno;
            $email = $request->input('email');

            $dob = $request->input('dob');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $gender = $request->input('gender');
            $marital = $request->input('maritalstatus');
            $state = $request->input('state');
            $town = $request->input('town');
            $faculty = $request->input('faculty');
            $photo = $request->input('photo');
            $religion = $request->input('religion'); 
            $admissiontype = $request->input('admissiontype');
            $uuid = Str::uuid()->toString();
            $file_path = $request->file('photo');
            $file_tmp = $_FILES['photo']['tmp_name'];
            $category1 = $request->input('category1');
            $category2 = $request->input('category1');
            $size = filesize($file_tmp);
            //SESSION VARIABLES
            session(['dob' => $dob]);
            session(['phone' => $phone]);
            session(['address' => $address]);
            session(['gender' => $gender]);
            session(['marital' => $marital]);
            session(['town' => $town]);
            session(['state' => $state]);
            session(['faculty' => $faculty]);
            session(['photo' => $photo]);
            session(['religion' => $religion]);
            session(['admissiontype' => $admissiontype]);
            session(['category1' => $category1]);
            session(['category2' => $category1]);
            $usrt = "Student";
            //Parent Biodata
            $psurname = $request->input('psurname');
            $pfirstname = $request->input('pfirstname');
            $pemail = $request->input('pemail');
            $relation = $request->input('relation');
            $pphone = $request->input('pphone');
            $paddress = $request->input('paddress');
            //Session Variables
             session(['psurname' => $psurname]);
             session(['pfirstname' => $pfirstname]);
             session(['pemail' => $pemail]);
             session(['relation' => $relation]);
             session(['pphone' => $pphone]);
             session(['paddress' => $paddress]);
            //Check against duplicate records
             ///checks
             $st_email  = DB::SELECT('CALL CheckBiodataDuplicateRecordByEmail(?)',array($email));
             $st_phone  = DB::SELECT('CALL CheckBiodataDuplicateRecordByPhone(?)',array($phone));
             $st_matric = DB::SELECT('CALL CheckBiodataDuplicateRecordByMatricNo(?)',array($matricno));
             //parent info
                $ck_email  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByEmailAndMatricNo(?,?)',array($email,$matricno));
                $ck_phone  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByPhoneAndMatricNo(?,?)',array($phone,$matricno));

            // dd($ck_email);
            
            if($size>20000)
            {
                return back()->with('error', 'Photo Must Not Greater Than 20K, Please Retry');
            }
            if($st_email[0]->Email== 1)
            {
                return back()->with('error', 'Email Address Already Exist, Please Try Another Email Address');
            }
            if($st_phone[0]->Phone== 1)
            {
                return back()->with('error', 'Phone Number Already Exist, Please Try Again');
            }
            if($st_matric[0]->Mat== 1)
            {
                return back()->with('error', 'MatricNo Already Exist, Please Try Again');
            }

               /* if($ck_email[0]->Mat== 1)
                {
                    return back()->with('error', 'Email Address and MatricNo Already Exist, Please Try Another Email Address');
                }

                if($ck_phone[0]->Mat== 1)
                {
                    return back()->with('error', 'Phone Number and UTME Reg/MatricNo Already Exist, Please Try Again');
                }
                */
            //Save a copy of the uploaded file
           
            $input['imagename'] = $matricno.'.'.$file_path->getClientOriginalExtension();
            $destinationPath = public_path('/Passports');
            $file_path->move($destinationPath, $input['imagename']);
            $imgP=$input['imagename'];
            $photo=$imgP;

         
       
           $sav = DB::INSERT('CALL SavePreAdmissionInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                             array($matricno,
                                   $firstname,
                                   $surname,
                                   $othername,
                                   $email,
                                   $phone,
                                   $gender,
                                   $dob,
                                   $marital,$town,
                                   $state,$address,
                                   $photo,$category1,
                                   $category1,$session,
                                   $admissiontype,$religion));
            if($sav)
            {
                //Update student usertype and photo
                DB::UPDATE('CALL UpdatePDSListStatus(?)',array(Auth::user()->formnumber));
                DB::UPDATE('CALL UpdateJUPEBListStatus(?)',array(Auth::user()->formnumber));
                $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));
                ///Insert record to UG Parent Biodata
                $pat = DB::INSERT('CALL UGSaveParentsData(?,?,?,?,?,?,?,?)',
                       array($matricno,$psurname,$pfirstname,$pemail,$pphone,$paddress,$relation,$uuid));
                if($pat)
                {
                   
                    return redirect()->route('UTMEPrintScreening');
                }
                else
                {       //Remove record from UG Biodata
                      DB::DELETE('CALL RemoveRecordFromUGBiodataByMatricno(?)', array($matricno));
                      return back()->with('error', 'Operation Failed, Please Retry Again');
                }


            }

        }
        else
        {
            return view('logon');
        }

    }
    public function PdsJupeb()
    {
        if(Auth::check())
        {
            $data ="";
            $mat = Auth::user()->matricno;
            $utme =Auth::user()->utme;
            $formnumber = Auth::user()->formnumber;
            $data = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
            $rec = DB::SELECT('CALL FetchStateList()');
            $ses = DB::SELECT('CALL FetchSession()');
            $pro = DB::SELECT('CALL FetchProgramme()');
            $pros = DB::SELECT('CALL FetchProgramme()');
            $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array($mat));
            $item = DB::SELECT('CALL FetchParentsData(?)',array($mat));
            $ulist  = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
            $frm = substr($formnumber,0,2);
          //  dd($frm);
            if($frm=="PD")
            {
               $data  = DB::SELECT('CALL ValidatePDS(?,?)',array($formnumber,$utme));
            }
            else
            {
                $data  = DB::SELECT('CALL ValidateJUPEB(?)',array($formnumber));
            }
          // dd($data);
            return view('pdsjupebDataPage', ['data'=>$data,'item'=>$item, 'rec'=>$rec, 'pro'=>$pro,'pros'=>$pros, 'ses'=>$ses,'result'=>$result,'mynames'=>$ulist,'ulist'=>$ulist]);
           //return view('');
        }
        else
        {
           return view('logon');
        }
    }


    public function RegConfirmation()
    {
       
       // dd($ip);
        if(Auth::check())
        {
           return view('registrationConfrimationPage');
        }
        else
        {
           return view('logon');
        }
    }
    public function DeleteResendReferenceInfo($id)
    {
        if(Auth::check())
        {
           DB::DELETE('CALL RemovePGEmailSentList(?) ',array($id));
           return redirect()->route('pgResendReference');
        }
        else
        {
           return view('logon');
        }
    }
    public function ResendRefEmails(Request $request)
    {
         if(Auth::check())
         {
             $matricno = Auth::user()->matricno;
           //  $email = Auth::user()->email;
             $email = $request->email;
             $ck = DB::SELECT('CALL CheckDuplicatePGEmailSentList(?,?)', array($matricno,$email));
            if($ck)
            {
                return back()->with('error', 'Record Already Exist, Please Try Again');
            }
            $uuid = Str::uuid()->toString().Str::uuid()->toString();
            $sav = DB::INSERT('CALL SavePGEmailSentList(?,?,?)',
            array($matricno,$email,$uuid));
            $url = config('paymentUrl.reference_url');
/*
            $details =
                   [   'title'=>"",
                       'body'=>"Lautech Post Gradurate Application Reference",
                       'header'=>"Dear Sir/Ma,", 
                       'parts'=>strtoupper(Auth::user()->name ). " has submitted your email as a reference. Please kindly click on the link below to complete the reference form. ".$url.$uuid,
                       'team' =>"Lautech Post Graduate Admission Team."

                   ];
                   Mail::to($email)->send(new ReferenceEmail($details));
    */
                  $parameters =
                             '{
                                "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                                "from": { "address": "appman@mailx.lautech.edu.ng","name": "LAUTECH PG Admissions" },
                                "to": [ { "email_address": { "address": "'.$email.'", "name": "'.Auth::user()->name.'" }}],
                                "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                                "subject": "Lautech Post Gradurate Application Reference",
                                "textbody": "Thank you for signifying interest in LAUTECH Admissions.:",
                                "htmlbody": "<html><body>Dear Sir/Ma, '.strtoupper(Auth::user()->name ).' has submitted your email as a reference. Please kindly click on the link below to complete the reference form. <img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"'.$url.$uuid.'\">Reference Form</a></h1></body></html>",
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
            if($sav)
            {
                return back()->with('success', 'Record Added Successfully');
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
    public function ResendRefEmail()
    {
        if(Auth::check())
        {   
             $matricno =Auth::user()->matricno;
             $data = DB::SELECT('CALL GetPGEmailSentListByMatricNo(?)',array($matricno));
             return view('pgResendReference', ['data'=>$data]);
        }
        else
        {
            return view('logon');
        }
    }
    public function ResendReference($id,$uid)
    {
      if(Auth::check())
       {
           $url = config('paymentUrl.reference_url');
           //dd($url);
         /*  $details =
           [   'title'=>"",
               'body'=>"Lautech Post Gradurate Application Reference",
               'header'=>"Dear Sir/Ma,", 
               'parts'=>strtoupper(Auth::user()->name ). " has submitted your email as a reference. Please kindly click on the link below to complete the reference form. ".$url.$uid,
               'team' =>"Lautech Post Graduate Admission Team."

           ];
           */
          
                $parameters =
                             '{
                                "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                                "from": { "address": "appman@mailx.lautech.edu.ng","name": "LAUTECH PG Admissions" },
                                "to": [ { "email_address": { "address": "'.$id.'", "name": "'.Auth::user()->name.'" }}],
                                "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                                "subject": "Lautech Post Gradurate Application Reference",
                                "textbody": "Thank you for signifying interest in LAUTECH Admissions.:",
                                "htmlbody": "<html><body>Dear Sir/Ma, '.strtoupper(Auth::user()->name ).' has submitted your email as a reference. Please kindly click on the link below to complete the reference form. <img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"'.$url.$uid.'\">Reference Form</a></h1></body></html>",
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
                
                return back()->with('success', 'Email Sent Successfully');
         
           return redirect()->route('pgResendReference');

        }
        else
        {
            return view('logon');
        }

    }
     public function PGApplication(Request $request)
     {
        if(Auth::check())
        {
            $id    = $request->id;
            //dd($id);
            $prod  = $request->prod;
            //$utme  = $request->utme;
            //$data     = DB::SELECT('CALL GetDirectEntryInfo(?)',array($utme));
             $matricno = Auth::user()->matricno;
             if($request)
             {
               #Update the Users 
               
                // DB::UPDATE('CALL UpdateUTMEUsers(?,?)',array($matricno,$utme));
                 return redirect()->route('PayNow',['id'=>$id,'prod'=>$prod]);
              }
                else
                {
                    return back()->with('error', $utme. ' Record Not Found, Please Try Again');
                }
        }
        else
        {
            return view('logon');
        }
    }
    public function CheckDE(Request $request)
    {
        if(Auth::check())
        {
            $id    = $request->id;
            //dd($id);
            $prod  = $request->prod;
            $utme  = $request->utme;
            $data     = DB::SELECT('CALL GetDirectEntryInfo(?)',array($utme));
            $matricno = Auth::user()->matricno;
             if($data)
             {
               #Update the Users 
               
                 DB::UPDATE('CALL UpdateUTMEUsers(?,?)',array($matricno,$utme));
                 return redirect()->route('PayNow',['id'=>$id,'prod'=>$prod]);
              }
                else
                {
                    return back()->with('error', $utme. ' Record Not Found, Please Try Again');
                }
        }
        else
        {
            return view('logon');
        }
     }
    public function CheckUTME(Request $request)
    {
         if(Auth::check())
         {
             $id    = $request->id;
             $prod  = $request->prod;
             $utme  = $request->utme;
             $data     = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
             $matricno = Auth::user()->matricno;
              if($data)
              {
                #Update the Users 
                
                  DB::UPDATE('CALL UpdateUTMEUsers(?,?)',array($matricno,$utme));
                  return redirect()->route('PayNow',['id'=>$id,'prod'=>$prod]);
               }
                 else
                 {
                     return back()->with('error', $utme. ' Record Not Found, Please Try Again');
                 }
         }
         else
         {
             return view('logon');
         }
    }
    public function DeleteReferenceInfo($id)
    {
        if(Auth::check())
        {
           DB::DELETE('CALL RemovePGEmailSentList(?) ',array($id));
           return redirect()->route('pgsendreferencePage');
        }
        else
        {
           return view('logon');
        }
    }

    public function PGSendReferences(Request $request)
    {
        if(Auth::check())
        {
           $matricno =Auth::user()->matricno;
           //$matricno ="PDS20219123614";
           $email =$request->input('email');
                   
            $ck = DB::SELECT('CALL 	CheckDuplicatePGEmailSentList(?,?)', array($matricno,$email));
            if($ck)
            {
                return back()->with('error', 'Record Already Exist, Please Try Again');
            }
            $uuid = Str::uuid()->toString().Str::uuid()->toString();
              $sav = DB::INSERT('CALL SavePGEmailSentList(?,?,?)',
              array($matricno,$email,$uuid));
            //Send Email
            $url = config('paymentUrl.reference_url');
          /*  $details =
                   [   'title'=>"",
                       'body'=>"Lautech Post Gradurate Application Reference",
                       'header'=>"Dear Sir/Ma,", 
                       'parts'=>strtoupper(Auth::user()->name ). " has submitted your email as a reference. Please kindly click on the link below to complete the reference form. ".$url.$uuid,
                       'team' =>"Lautech Post Graduate Admission Team."

                   ]; 
            */
                     $parameters =
                             '{
                                "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                                "from": { "address": "appman@mailx.lautech.edu.ng","name": "LAUTECH PG Admissions" },
                                "to": [ { "email_address": { "address": "'.$email.'", "name": "'.Auth::user()->name.'" }}],
                                "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                                "subject": "Lautech Post Gradurate Application Reference",
                                "textbody": "Thank you for signifying interest in LAUTECH Admissions.:",
                                "htmlbody": "<html><body>Dear Sir/Ma, '.strtoupper(Auth::user()->name ).' has submitted your email as a reference. Please kindly click on the link below to complete the reference form. <img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"'.$url.$uuid.'\">Reference Form</a></h1></body></html>",
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
                       //// var_dump($server_output);
                 
                 
                 
                 
                 
                 
                 
            if($sav)
            {
                return back()->with('success', 'Record Added Successfully');
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
    public function PGSendReference()
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            $matricno = Auth::user()->matricno;
            $counter = DB::SELECT('CALL 	CounterPGEmailSentList(?)', array($matricno));
            if($counter && $counter[0]->num == 3)
            {
                #Update Completion Status
                DB::UPDATE('CALL UpdateCompleteStatus(?)',array($matricno));  
            }
            #Fetch Country
           // $matricno ="PDS20219123614";
            $data = DB::SELECT('CALL GetPGEmailSentListByMatricNo(?)',array($matricno));
            return view('pgsendreferencePage',['data'=>$data]);

        }
        else
        {
            return view('logon');
        }
    }
 
    public function DeletePGOtherInfo($id)
    {
        if(Auth::check())
        {
           DB::DELETE('CALL RemovePGOtherInfo(?) ',array($id));
           return redirect()->route('pgotherinfoPage');
        }
        else
        {
           return view('logon');
        }
    }
    public function PGOtherInfos(Request $request)
    {
        if(Auth::check())
        {
           $matricno =Auth::user()->matricno;
           //$matricno ="99439349";
           $description =$request->input('description');
           $content     =$request->input('content');
           $year        =$request->input('year');
      
            
            $ck = DB::SELECT('CALL CheckDuplicatePGOtherInfo(?,?,?)', array($matricno,$description,$content));
            if($ck)
            {
                return back()->with('error', 'Record Already Exist, Please Try Again');
            }
           
            $sav = DB::INSERT('CALL SavePGOtherInfo(?,?,?,?)',
            array($description,$content,$year,$matricno,));
            
            if($sav)
            {
                return back()->with('success', 'Record Added Successfully');
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
    public function PGOtherInfo()
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
            return redirect()->route('home');
            }
            $matricno = Auth::user()->matricno;
            #Fetch Country
            //$matricno ="99439349";
            $oth = DB::SELECT('CALL FetchPGOtherDetails()');
            $data = DB::SELECT('CALL GetPGOtherInfoByMatricNo(?)',array($matricno));
            return view('pgotherinfoPage',['data'=>$data,'oth'=>$oth]);

        }
        else
        {
            return view('logon');
        }
    }
    public function DeletePGPublication($id)
    {
        if(Auth::check())
        {
           DB::DELETE('CALL RemovePublicationInfoByID(?) ',array($id));
           return redirect()->route('pgpublicationPage');
        }
        else
        {
           return view('logon');
        }
    }
    public function PGPublications(Request $request)
    {
        if(Auth::check())
        {
           $matricno =Auth::user()->matricno;
          // $matricno ="99439349";
           $publication =$request->input('publication');
           $title       =$request->input('title');
           $year        =$request->input('year');
      
            
            $ck = DB::SELECT('CALL CheckDuplicatePGPublication(?,?,?)', array($matricno,$title,$publication));
            if($ck)
            {
                return back()->with('error', 'Record Already Exist, Please Try Again');
            }
           
            $sav = DB::INSERT('CALL SavePGPublication(?,?,?,?)',
            array($matricno,$publication,$title,$year));
            
            if($sav)
            {
                return back()->with('success', 'Record Added Successfully');
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
    public function PGPublication()
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
            return redirect()->route('home');
            }
            $matricno = Auth::user()->matricno;
            #Fetch Country
            //$matricno ="99439349";
            $data = DB::SELECT('CALL GetPGPublicationByMatricNo(?)',array($matricno));
            return view('pgpublicationPage',['data'=>$data]);

        }
        else
        {
            return view('logon');
        }
    }
    public function DeleteAppointment($id)
    {
        if(Auth::check())
        {
           DB::DELETE('CALL RemoveAppointmentInfoByID(?) ',array($id));
           return redirect()->route('pgappointmentPage');
        }
        else
        {
           return view('logon');
        }
    }
    public function PGAppointments(Request $request)
    {
        if(Auth::check())
        {
           $matricno =Auth::user()->matricno;
          // $matricno ="99439349";
           $employer =$request->input('employer');
           $post       =$request->input('post');
           $startyear  =$request->input('startyear');
           $endyear =$request->input('endyear');
            
            $ck = DB::SELECT('CALL CheckDuplicateAppointments(?,?,?)', array($matricno,$post,$employer));
            if($ck)
            {
                return back()->with('error', 'Record Already Exist, Please Try Again');
            }
            if($startyear > $endyear)
            {
                return back()->with('error', 'Wrong Start Year Selected, Please Try Again');
            }
            $sav = DB::INSERT('CALL SaveAppointmentInfo(?,?,?,?,?)',
            array($post,$employer,$startyear,$endyear,$matricno));
            
            if($sav)
            {
                return back()->with('success', 'Record Added Successfully');
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
    public function PGAppointment()
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            $matricno = Auth::user()->matricno;
            #Fetch Country
            //$matricno ="99439349";
            $data = DB::SELECT('CALL GetAppointmentsByMatricNo(?)',array($matricno));
            return view('pgappointmentPage',['data'=>$data]);

        }
        else
        {
            return view('logon');
        }
    }
    public function DeleteQualification($id)
    {
      if(Auth::check())
      {
         DB::DELETE('CALL RemoveQualificationInfoByID(?) ',array($id));
         return redirect()->route('pgqualificationPage');
      }
      else
      {
         return view('logon');
      }
    }
    public function PGQualifications(Request $request)
    {
    if(Auth::check())
    {
       $matricno =Auth::user()->matricno;
       //$matricno ="99439349";
       $degree            =$request->input('degree');
       $degreeclass       =$request->input('degreeclass');
       $award             =$request->input('award');
       $year              =$request->input('year');
       //dd($year);
        
        $ck = DB::SELECT('CALL 	CheckDuplicatePGQualification(?,?,?)', array($matricno,$year,$degree));
        if($ck)
        {
            return back()->with('error', 'Record Already Exist, Please Try Again');
        }
        
        $sav = DB::INSERT('CALL SavePGQualification(?,?,?,?,?)',
        array($matricno,$degree,$year,$award,$degreeclass));
        
        if($sav)
        {
            return back()->with('success', 'Record Added Successfully');
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
  public function PGQualification()
  {
    if(Auth::check())
    {
        $ispd = Auth::user()->ispaid;
        if($ispd==false)
        {
          return redirect()->route('home');
        }
        $matricno = Auth::user()->matricno;


        #Fetch Country
       // $matricno ="99439349";
        $data = DB::SELECT('CALL GetPGQualificationByMatricNo(?)',array($matricno));
        //dd($matricno);
        $deg = DB::SELECT('CALL FetchDegrees()');
        $cla = DB::SELECT('CALL FetchClassofDegree()');
        return view('pgqualificationPage',['data'=>$data,'deg'=>$deg,'cla'=>$cla]);

    }
    else
    {
        return view('logon');
    }
  }
  public function DeleteEducation($id)
  {
    if(Auth::check())
    {
       DB::DELETE('CALL RemoveEducationInfoByID(?) ',array($id));
       return redirect()->route('pgeducationPage');
    }
    else
    {
       return view('logon');
    }
  }
  public function PGEducationForms(Request $request)
  {
    if(Auth::check())
    {
       $matricno =Auth::user()->matricno;
       //$matricno ="99439349";
       $schoolname =$request->input('schoolname');
       $town       =$request->input('town');
       $country    =$request->input('country');
       $startyear  =$request->input('startyear');
       $endyear =$request->input('endyear');
        
        $ck = DB::SELECT('CALL CheckDuplicateEducationInfo(?,?)', array($matricno,$schoolname));
        if($ck)
        {
            return back()->with('error', 'Record Already Exist, Please Try Again');
        }
        if($startyear > $endyear)
        {
            return back()->with('error', 'Wrong Start Year Selected, Please Try Again');
        }
        $sav = DB::INSERT('CALL SaveEducationInfo(?,?,?,?,?,?)',array($matricno,$town,$schoolname,$country,$startyear,$endyear));
        
        if($sav)
        {
            return back()->with('success', 'Record Added Successfully');
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
  public function PGEducationForm()
  {
    if(Auth::check())
    {
        $ispd = Auth::user()->ispaid;
        if($ispd==false)
        {
          return redirect()->route('home');
        }
        $matricno = Auth::user()->matricno;
        #Fetch Country
        //$matricno ="99439349";
        $data = DB::SELECT('CALL GetEducationInfoByMatricNo(?)',array($matricno));
        $cou = DB::SELECT('CALL FetchCountry()');
        return view('pgeducationPage',['data'=>$data,'cou'=>$cou]);

    }
    else
    {

    }
  }
  public function PGDataForms(Request $request)
  {
    if(Auth::check())
    {
        $ispd = Auth::user()->ispaid;
        if($ispd==false)
        {
          return redirect()->route('home');
        }
        //Student Personal Biodata
        $surname = $request->input('surname');
        $session = $request->input('session');
        $firstname = $request->input('firstname');
        $othername = $request->input('othername');
        $matricno = Auth::user()->matricno;
        $email = $request->input('email');
        $department = $request->input('department');
        $dob = $request->input('dob');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $gender = $request->input('gender');
        $marital = $request->input('maritalstatus');
        $state = $request->input('state');
        $town = $request->input('town');
        $faculty = $request->input('faculty');
        $photo = $request->input('photo');
        $religion = $request->input('religion'); 
        $admissiontype = $request->input('admissiontype');
        $uuid = Str::uuid()->toString();
        $file_path = $request->file('photo');
        $file_tmp = $_FILES['photo']['tmp_name'];
        $category1 = $request->input('category1');
        $category2 = $request->input('category2');
        $size = filesize($file_tmp);
        //Sponsorship Data
        $sname    = $request->input('sname');
        $sphone   = $request->input('sphone');
        $saddress = $request->input('saddress');
        $semail    = $request->input('semail');
         session(['sname'    => $sname]);
         session(['sphone'   => $sphone]);
         session(['saddress' => $saddress]);
         session(['semail'   => $semail]);
        //SESSION VARIABLES
        session(['dob' => $dob]);
        session(['phone' => $phone]);
        session(['address' => $address]);
        session(['gender' => $gender]);
        session(['marital' => $marital]);
        session(['town' => $town]);
        session(['state' => $state]);
        session(['faculty' => $faculty]);
        session(['photo' => $photo]);
        session(['religion' => $religion]);
        session(['admissiontype' => $admissiontype]);
        session(['category1' => $category1]);
        session(['category2' => $category2]);
        session(['department' => $department]);
        $usrt = "Student";
        //Parent Biodata
        $psurname = $request->input('psurname');
        $pfirstname = $request->input('pfirstname');
        $pemail = $request->input('pemail');
        $relation = $request->input('relation');
        $pphone = $request->input('pphone');
        $paddress = $request->input('paddress');
        //Session Variables
         session(['psurname' => $psurname]);
         session(['pfirstname' => $pfirstname]);
         session(['pemail' => $pemail]);
         session(['relation' => $relation]);
         session(['pphone' => $pphone]);
         session(['paddress' => $paddress]);
        //Check against duplicate records
         ///checks
         $st_email  = DB::SELECT('CALL CheckBiodataDuplicateRecordByEmail(?)',array($email));
         $st_phone  = DB::SELECT('CALL CheckBiodataDuplicateRecordByPhone(?)',array($phone));
         $st_matric = DB::SELECT('CALL CheckBiodataDuplicateRecordByMatricNo(?)',array($matricno));
        // dd($st_matric);
         //parent info
            $ck_email  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByEmailAndMatricNo(?,?)',array($email,$matricno));
            $ck_phone  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByPhoneAndMatricNo(?,?)',array($phone,$matricno));

       
        if($size>20000)
        {
            return back()->with('error', 'Photo Must Not Greater Than 20K, Please Retry');
        }
        /*
        if($st_email[0]->Email== 1)
        {
            return back()->with('error', 'Email Address Already Exist, Please Try Another Email Address');
        }*/
       // if($st_phone[0]->Phone== 1)
     //   {
     //       return back()->with('error', 'Phone Number Already Exist, Please Try Again');
     //   }
        
         //Save a copy of the uploaded file
       
        if($sname=="" || $semail=="" || $sphone=="" || $saddress=="")
        {
            return back()->with('error', 'Please Fill Sponsorship Information, Please Try Again');
        }
        $input['imagename'] = $matricno.'.'.$file_path->getClientOriginalExtension();
        $destinationPath = public_path('/Passports');
        $file_path->move($destinationPath, $input['imagename']);
        $imgP=$input['imagename'];
        $photo=$imgP;
        if($st_matric[0]->Mat== 1)
        {
                 #Update Records
                 
                 $da = DB::table('u_g_pre_admission_regs')->where('matricno', $matricno)
                                  ->update(['firstname'=>$firstname,'surname'=>$surname,'othername'=>$othername,
                                       'phone'=>$phone,'gender'=>$gender,'dob'=>$dob,
                                       'maritalstatus'=>$marital,'town'=>$town,'state'=>$state,'address'=>$address,
                                       'photo'=>$photo,'category1'=>$category1,'category2'=>$category1,'session'=>$session,
                                       'admissiontype'=>$admissiontype,'religion'=>$religion,'department'=>$department]);

                $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));

                $pck = DB::table('u_g_parent_infos')->where('matricno', $matricno)->first();
                if($pck)
                 {
                   $parent = DB::table('u_g_parent_infos')->where('matricno', $matricno)
                                                       ->update(['surname'=>$psurname,'othername'=>$pfirstname,'email'=>$pemail,
                                                                 'phone'=>$pphone,'address'=>$paddress,'relation'=>$relation]);
                 }
                 else
                 {
                     //dd(Auth::user()->matricno);
                   // $pat = DB::INSERT('CALL UGSaveParentsData(?,?,?,?,?,?,?,?)',
                   // array($matricno,$psurname,$pfirstname,$pemail,$pphone,$paddress,$relation,$uuid));
                        $parent = new UGParentInfo();
                        $parent->utme   = "Null";
                        $parent->surname   = $psurname;
                        $parent->othername = $pfirstname;
                        $parent->email     = $pemail;
                        $parent->phone     = $pphone;
                        $parent->address   = $paddress;
                        $parent->relation  = $relation;
                        $parent->guid      = $uuid;
                        $parent->status      = 1;
                        $parent->matricno   = Auth::user()->matricno;
                        $parent->save();
                 }
                 #Check Sponsorship info
                $sck =  DB::table('sponsorship')->where('matricno', $matricno)->first();
                if($sck)
                {
                   $spor = DB::table('sponsorship')->where('matricno', $matricno)
                                                 ->update(['sname'=>$sname,'semail'=>$semail,'sphone'=>$sphone,'saddress'=>$saddress]);                                         
                }
                else
                {
                    #
                    $sponsors = new Sponsorship;
                    $sponsors->sname      = $sname;
                    $sponsors->sphone     = $sphone;
                    $sponsors->saddress   = $saddress;
                    $sponsors->semail     = $semail;
                    $sponsors->matricno   = $matricno;
                    $sponsors->save();
                    
                    //$spor = DB::INSERT('CALL SaveSponsorship(?,?,?,?,?)',
                    //array($matricno,$sname,$semail,$sphone,$saddress));
                }
                return redirect()->route('ugpreQ');

        }

          
       

     
       //Get Student Info from users table and preload on the form
      //  $sav = DB::INSERT('CALL UGSaveBiodata(?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
      //                      array($email,$surname,$firstname,$othername,$uuid,$matricno,
       //                      $phone,$gender,$dob,$marital,$town,$state,$address,$photo));
       $sav = DB::INSERT('CALL SavePGPreAdmissionInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                         array($matricno,
                               $firstname,
                               $surname,
                               $othername,
                               $email,
                               $phone,
                               $gender,
                               $dob,
                               $marital,$town,
                               $state,$address,
                               $photo,$category1,
                               $category1,$session,
                               $admissiontype,$religion,$department));
        if($sav)
        {
            //Update student usertype and photo
            $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));
            ///Insert record to UG Parent Biodata
                    $parent = new UGParentInfo();
                    $parent->surname    = $psurname;
                    $parent->matricno   = Auth::user()->matricno;
                    $parent->othername = $pfirstname;
                    $parent->email     = $pemail;
                    $parent->phone     = $pphone;
                    $parent->address   = $paddress;
                    $parent->relation  = $relation;
                    $parent->guid      = $uuid;
                    $parent->utme   = "Null";
                    $parent->save();
           // $pat = DB::INSERT('CALL UGSaveParentsData(?,?,?,?,?,?,?,?)',
            ///       array($matricno,$psurname,$pfirstname,$pemail,$pphone,$paddress,$relation,$uuid));
            //$spor = DB::INSERT('CALL SaveSponsorship(?,?,?,?,?)',
            //      array($matricno,$sname,$semail,$sphone,$saddress));
                    $data = $request->input();
                    $sponsors = new Sponsorship;
                    $sponsors->sname      = $data['sname'];
                    $sponsors->sphone     = $data['sphone'];
                    $sponsors->saddress   = $data['saddress'];
                    $sponsors->semail     = $data['semail'];
                    $sponsors->matricno   = $matricno;
                    $sponsors->save();
            if($pat)
            {
               //return back()->with('success', 'Record Saved Successfully');
               // return redirect()->route('ugpreQ');
            }
            else
            {       //Remove record from UG Biodata
                  DB::DELETE('CALL RemoveRecordFromUGBiodataByMatricno(?)', array($matricno));
                  return back()->with('error', 'Operation Failed, Please Retry Again');
            }


        }

    }
    else
    {
        return view('logon');
    }
  }
  public function PGDataForm()
  {
    if(Auth::check())
    {
        $ispd = Auth::user()->ispaid;
        if($ispd==false)
        {
          return redirect()->route('home');
        }
        $mat = Auth::user()->matricno;
        $data = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
        $rec = DB::SELECT('CALL FetchStateList()');
        $ses = DB::SELECT('CALL FetchSession()');
        //$pro = DB::SELECT('CALL FetchProgramme()');
        $dep = DB::SELECT('CALL FetchPGDepartments()');
       // $pros = DB::SELECT('CALL FetchProgramme()');
        $result = DB::SELECT('CALL FetchPGPreAdmissionInfo(?)',array($mat));
        $item = DB::SELECT('CALL FetchParentsData(?)',array($mat));
        $spor = DB::SELECT('CALL GetSponorshipByMatricNo(?)',array($mat));
        $rel  = DB::SELECT('CALL FetchRelations()');
      // dd($data);
        return view('pgdataPage', ['data'=>$data,
                                   'item'=>$item, 
                                   'rec'=>$rec, 
                                  
                                   'ses'=>$ses,
                                   'result'=>$result,
                                   'rel'=>$rel,
                                   'spor'=>$spor,
                                   'dep'=>$dep
                                   ]);
    }
    else
    {
        return view('logon');
    }
  }
    public function DEDatas(Request $request)
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            //Student Personal Biodata
            $surname = $request->input('surname');
            $session = $request->input('session');
            $firstname = $request->input('firstname');
            $othername = $request->input('othername');
            $matricno = Auth::user()->matricno;
            $email = $request->input('email');

            $dob = $request->input('dob');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $gender = $request->input('gender');
            $marital = $request->input('maritalstatus');
            $state = $request->input('state');
            $town = $request->input('town');
            $faculty = $request->input('faculty');
            $photo = $request->input('photo');
            $religion = $request->input('religion'); 
            $admissiontype = $request->input('admissiontype');
            $uuid = Str::uuid()->toString();
            $file_path = $request->file('photo');
            $file_tmp = $_FILES['photo']['tmp_name'];
            $size = filesize($file_tmp);
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
          
            //SESSION VARIABLES
            session(['dob' => $dob]);
            session(['phone' => $phone]);
            session(['address' => $address]);
            session(['gender' => $gender]);
            session(['marital' => $marital]);
            session(['town' => $town]);
            session(['state' => $state]);
            session(['faculty' => $faculty]);
            session(['photo' => $photo]);
            session(['religion' => $religion]);
            session(['admissiontype' => $admissiontype]);
            session(['category1' => $category1]);
            session(['category2' => $category2]);
            $usrt = "Student";
            //Parent Biodata
            $psurname = $request->input('psurname');
            $pfirstname = $request->input('pfirstname');
            $pemail = $request->input('pemail');
            $relation = $request->input('relation');
            $pphone = $request->input('pphone');
            $paddress = $request->input('paddress');
            //Session Variables
             session(['psurname' => $psurname]);
             session(['pfirstname' => $pfirstname]);
             session(['pemail' => $pemail]);
             session(['relation' => $relation]);
             session(['pphone' => $pphone]);
             session(['paddress' => $paddress]);
            //Check against duplicate records
             ///checks
             $st_email  = DB::SELECT('CALL CheckBiodataDuplicateRecordByEmail(?)',array($email));
             $st_phone  = DB::SELECT('CALL CheckBiodataDuplicateRecordByPhone(?)',array($phone));
             $st_matric = DB::SELECT('CALL CheckBiodataDuplicateRecordByMatricNo(?)',array($matricno));
             //parent info
                $ck_email  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByEmailAndMatricNo(?,?)',array($email,$matricno));
                $ck_phone  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByPhoneAndMatricNo(?,?)',array($phone,$matricno));

            // dd($ck_email);
            /*if($category1 == $category2)
            {
              return back()->with('error', 'Pleae Select Different Categories, Please Try Again');
            }
            */
            
            if($size>20000)
            {
                return back()->with('error', 'Photo Must Not Greater Than 20K, Please Retry');
            }
            if($st_email[0]->Email== 1)
            {
                return back()->with('error', 'Email Address Already Exist, Please Try Another Email Address');
            }
            if($st_phone[0]->Phone== 1)
            {
                return back()->with('error', 'Phone Number Already Exist, Please Try Again');
            }
            if($st_matric[0]->Mat== 1)
            {
                return back()->with('error', 'MatricNo Already Exist, Please Try Again');
            }

 /*
                if($ck_email[0]->Mat== 1)
                {
                    return back()->with('error', 'Email Address and MatricNo Already Exist, Please Try Another Email Address');
                }

                if($ck_phone[0]->Mat== 1)
                {
                    return back()->with('error', 'Phone Number and UTME Reg/MatricNo Already Exist, Please Try Again');
                }
                */
            //Save a copy of the uploaded file
           
            $input['imagename'] = $matricno.'.'.$file_path->getClientOriginalExtension();
            $destinationPath = public_path('/Passports');
            $file_path->move($destinationPath, $input['imagename']);
            $imgP=$input['imagename'];
            $photo=$imgP;

         
           //Get Student Info from users table and preload on the form
          //  $sav = DB::INSERT('CALL UGSaveBiodata(?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
          //                      array($email,$surname,$firstname,$othername,$uuid,$matricno,
           //                      $phone,$gender,$dob,$marital,$town,$state,$address,$photo));
           $sav = DB::INSERT('CALL SavePreAdmissionInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                             array($matricno,
                                   $firstname,
                                   $surname,
                                   $othername,
                                   $email,
                                   $phone,
                                   $gender,
                                   $dob,
                                   $marital,$town,
                                   $state,$address,
                                   $photo,$category1,
                                   $category1,$session,
                                   $admissiontype,$religion));
            if($sav)
            {
                //Update student photo
                $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));
                ///Insert record to UG Parent Biodata
                $pat = DB::INSERT('CALL UGSaveParentsData(?,?,?,?,?,?,?,?)',
                       array($matricno,$psurname,$pfirstname,$pemail,$pphone,$paddress,$relation,$uuid));
                if($pat)
                {
                   //return back()->with('success', 'Record Saved Successfully');
                    return redirect()->route('UTMEPrintScreening');
                }
                else
                {       //Remove record from UG Biodata
                      DB::DELETE('CALL RemoveRecordFromUGBiodataByMatricno(?)', array($matricno));
                      return back()->with('error', 'Operation Failed, Please Retry Again');
                }


            }

        }
        else
        {
            return view('logon');
        }
    }
    public function DEData()
    {

        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            $mat    = Auth::user()->matricno;
            $utme    = Auth::user()->utme;
            $data   = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
           // dd($mat);
            $rec    = DB::SELECT('CALL FetchStateList()');
            $ses    = DB::SELECT('CALL FetchSession()');
            $pro    = DB::SELECT('CALL FetchProgramme()');
            $pros   = DB::SELECT('CALL FetchProgramme()');
            $ulist =  DB::SELECT('CALL GetDirectEntryInfo(?)',array($utme));
            $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array($mat));
            $item   = DB::SELECT('CALL FetchParentsData(?)',array($mat));
            //dd($result);
            return view('directEntryDataPage', ['data'=>$data,'item'=>$item, 'rec'=>$rec, 'pro'=>$pro,'pros'=>$pros, 'ses'=>$ses,'result'=>$result,'mynames'=>$ulist,'ulist'=>$ulist]);
        }
        else
        {
            return view('logon');
        }
    }
    public function UTMEDatas(Request $request)
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            //Student Personal Biodata
            $surname = $request->input('surname');
            $session = $request->input('session');
            $firstname = $request->input('firstname');
            $othername = $request->input('othername');
            $matricno = Auth::user()->matricno;
            $email = $request->input('email');

            $dob = $request->input('dob');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $gender = $request->input('gender');
            $marital = $request->input('maritalstatus');
            $state = $request->input('state');
            $town = $request->input('town');
            $faculty = $request->input('faculty');
            $photo = $request->input('photo');
            $religion = $request->input('religion'); 
            $admissiontype = $request->input('admissiontype');
            $uuid = Str::uuid()->toString();
            $file_path = $request->file('photo');
            $file_tmp = $_FILES['photo']['tmp_name'];
            $size = filesize($file_tmp);
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
          
            //SESSION VARIABLES
            session(['dob' => $dob]);
            session(['phone' => $phone]);
            session(['address' => $address]);
            session(['gender' => $gender]);
            session(['marital' => $marital]);
            session(['town' => $town]);
            session(['state' => $state]);
            session(['faculty' => $faculty]);
            session(['photo' => $photo]);
            session(['religion' => $religion]);
            session(['admissiontype' => $admissiontype]);
            session(['category1' => $category1]);
            session(['category2' => $category2]);
            $usrt = "Student";
            //Parent Biodata
            $psurname = $request->input('psurname');
            $pfirstname = $request->input('pfirstname');
            $pemail = $request->input('pemail');
            $relation = $request->input('relation');
            $pphone = $request->input('pphone');
            $paddress = $request->input('paddress');
            //Session Variables
             session(['psurname' => $psurname]);
             session(['pfirstname' => $pfirstname]);
             session(['pemail' => $pemail]);
             session(['relation' => $relation]);
             session(['pphone' => $pphone]);
             session(['paddress' => $paddress]);
            //Check against duplicate records
             ///checks
             $st_email  = DB::SELECT('CALL CheckBiodataDuplicateRecordByEmail(?)',array($email));
             $st_phone  = DB::SELECT('CALL CheckBiodataDuplicateRecordByPhone(?)',array($phone));
             $st_matric = DB::SELECT('CALL CheckBiodataDuplicateRecordByMatricNo(?)',array($matricno));
             //parent info
                $ck_email  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByEmailAndMatricNo(?,?)',array($email,$matricno));
                $ck_phone  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByPhoneAndMatricNo(?,?)',array($phone,$matricno));

            // dd($ck_email);
            /*if($category1 == $category2)
            {
              return back()->with('error', 'Pleae Select Different Categories, Please Try Again');
            }
            */
            
            if($size>20000)
            {
                return back()->with('error', 'Photo Must Not Greater Than 20K, Please Retry');
            }
            if($st_email[0]->Email== 1)
            {
                return back()->with('error', 'Email Address Already Exist, Please Try Another Email Address');
            }
            if($st_phone[0]->Phone== 1)
            {
                return back()->with('error', 'Phone Number Already Exist, Please Try Again');
            }
            if($st_matric[0]->Mat== 1)
            {
                return back()->with('error', 'MatricNo Already Exist, Please Try Again');
            }

                if($ck_email[0]->Mat== 1)
                {
                    return back()->with('error', 'Email Address and MatricNo Already Exist, Please Try Another Email Address');
                }

                if($ck_phone[0]->Mat== 1)
                {
                    return back()->with('error', 'Phone Number and UTME Reg/MatricNo Already Exist, Please Try Again');
                }
            //Save a copy of the uploaded file
           
            $input['imagename'] = $matricno.'.'.$file_path->getClientOriginalExtension();
            $destinationPath = public_path('/Passports');
            $file_path->move($destinationPath, $input['imagename']);
            $imgP=$input['imagename'];
            $photo=$imgP;

         
           //Get Student Info from users table and preload on the form
          //  $sav = DB::INSERT('CALL UGSaveBiodata(?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
          //                      array($email,$surname,$firstname,$othername,$uuid,$matricno,
           //                      $phone,$gender,$dob,$marital,$town,$state,$address,$photo));
           $sav = DB::INSERT('CALL SavePreAdmissionInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                             array($matricno,
                                   $firstname,
                                   $surname,
                                   $othername,
                                   $email,
                                   $phone,
                                   $gender,
                                   $dob,
                                   $marital,$town,
                                   $state,$address,
                                   $photo,$category1,
                                   $category1,$session,
                                   $admissiontype,$religion));
            if($sav)
            {
                //Update student photo
                $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));
                ///Insert record to UG Parent Biodata
                $pat = DB::INSERT('CALL UGSaveParentsData(?,?,?,?,?,?,?,?)',
                       array($matricno,$psurname,$pfirstname,$pemail,$pphone,$paddress,$relation,$uuid));
                if($pat)
                {
                   //return back()->with('success', 'Record Saved Successfully');
                    return redirect()->route('UTMEPrintScreening');
                }
                else
                {       //Remove record from UG Biodata
                      DB::DELETE('CALL RemoveRecordFromUGBiodataByMatricno(?)', array($matricno));
                      return back()->with('error', 'Operation Failed, Please Retry Again');
                }


            }

        }
        else
        {
            return view('logon');
        }
    }
    public function UTMEData()
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            $mat    = Auth::user()->matricno;
            $utme    = Auth::user()->utme;
            $data   = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
           // dd($mat);
            $rec    = DB::SELECT('CALL FetchStateList()');
            $ses    = DB::SELECT('CALL FetchSession()');
            $pro    = DB::SELECT('CALL FetchProgramme()');
            $pros   = DB::SELECT('CALL FetchProgramme()');
            $ulist  = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
            $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array($mat));
            $item   = DB::SELECT('CALL FetchParentsData(?)',array($mat));
            //dd($result);
            return view('utmeDataPage', ['data'=>$data,'item'=>$item, 'rec'=>$rec, 'pro'=>$pro,'pros'=>$pros, 'ses'=>$ses,'result'=>$result,'mynames'=>$ulist,'ulist'=>$ulist]);
        }
        else
        {
            return view('logon');
        }
    }
    public function ValidateUTMES(Request $request)
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            $matricno = Auth::user()->matricno;
            $apptype  = $request->apptype;
            $utme     = $request->utme;
            //dd($apptype);
                         $ck = DB::table('users')->where('utme',$utme)->first();
                         if($ck)
                         {
                            return back()->with('error','Sorry UTME No ' . $utme . ' Has Used By '. $ck->name .', Please Try Again');
                         }
            if($apptype =="UTME")
            {
                $data     = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
                if($data)
                {
                #Update the Users 
                //DB::UPDATE('CALL UpdateUTMEUsers(?,?)',array($matricno,$utme));
                 DB::table('users')
                                        ->where('matricno', $matricno)
                                        ->update(['utme'       => $utme,
                                                  'formnumber' => $utme]);
                                        
                return redirect()->route('utmeDataPage');
                }
                else
                {
                  return back()->with('error', $utme. ' Record Not Found, Please Try Again');
                }
            }
            else
            {
               // dd($apptype);
                $data     = DB::SELECT('CALL GetDirectEntryInfo(?)',array($utme));
                if($data)
                {
                #Update the Users 
                DB::UPDATE('CALL UpdateUTMEUsers(?,?)',array($matricno,$utme));
                return redirect()->route('directEntryDataPage');
                }
                else
                {
                return back()->with('error', $utme. ' Record Not Found, Please Try Again');
                }
            }

            
        }
        else
        {
           return view('logon');
        }
    }
    public function ValidateUTME()
    {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==true)
            {
              return view('validateUTME');
            }
             
        }
        else
        {
           return view('logon');
        }
    }
  
  public function StudentProfile()
  {
    if(Auth::check())
      {
        $matricno = Auth::user()->matricno;
   
        $data = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)', array($matricno));
        if($data)
        {
          return view('myprofile',['data'=>$data]);
        }
        else
        {
            return back()->with('error', 'Not Record Found');
        }
      }
       else
      {
         return view('logon');
      }
  }
 
 
  
  
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
     }
    public function DeleteQual($id)
    {
        if(Auth::check())
         {
           DB::table('u_g_qualifications')->where('id', $id)->delete();
           return redirect()->route('ugQualification');
         }
         else
        {
            return view('logon');
        }
    }
    public function ConfirmScreening(Request $request)
    {

    }
   function GetStudentProgramme($pro)
    {
         
          $dat = DB::table('programme')->where('programmeid', $pro)->get()->first();
          //dd($dat);
          return $dat->programme;
    }
    public function GetScreenHall()
    {
        if(Auth::check())
        {
           $batched = false;
           $matricno = Auth::user()->matricno;
           #Fetch batching information
           $bat = DB::SELECT('CALL FetchBatching()');
           $lastcount = 0;
           //dd($bat);
          if($bat)
           {
               //dd($bat[0]->session);
               #The last occuppant number by hall
               $ocu = DB::SELECT('CALL GetScreeningClearnanceByHall(?,?,?,?)',array($bat[0]->hall, 
                                                                                  $bat[0]->session,
                                                                                  $bat[0]->batchno,
                                                                                  $bat[0]->examdate));
                //dd($ocu);
                if($ocu)
                {
                  $lastcount = $ocu[0]->hallnumber + 1;
                }
                else
                {
                   $lastcount += 1;
                }
              
               #Get the parameter from Batching
               $rechall =  $bat[0]->hall;
               $recbat  =  $bat[0]->batchno;
               $recses  =  $bat[0]->session;
               $edate   =  $bat[0]->examdate;
              
              
               if($lastcount <= $bat[0]->occupy)
               {
                   #check if the hallnumber for a student already exist
                   $bno = DB::SELECT('CALL CheckIfHallNumberExist(?,?,?,?)',array($rechall,
                                                                                  $recses,
                                                                                  $lastcount,
                                                                                  $recbat));
                  //  dd($bno);   
                 if($bno)
                 {
                   $lastcount += 1;
                 }
                 /// dd($lastcount);
                #assign one more student to the hall
                 $ck = DB::SELECT('CALL CheckScreeningClearanceDuplicate(?,?)',array($matricno,$recses));
                 //dd($ck);  

                  //if($ck[0]->checker == 0)
                  //{
                     $sav = DB::INSERT('CALL SaveScreenClearance(?,?,?,?,?,?,?)',  array($matricno,
                                                                                    $bat[0]->examdate,
                                                                                    $bat[0]->hall,
                                                                                    $bat[0]->batchno,
                                                                                    $bat[0]->examtime,
                                                                                    $lastcount,
                                                                                    $bat[0]->session));
                     // return $batched =true;
                      
                  //}
                   return $batched =true;
              }
              elseif($lastcount > $bat[0]->occupy)
              {
                //dd($lastcount);
                $batched = false;
                return $batched;
              }
              else
              {
                $batched = "Full";
                 return $batched;
              }
        }
     }
  }
    public function ScreeningConfirm()
    {
        $ocp=0;
        if(Auth::check())
        {
           $matricno = Auth::user()->matricno;
           $name = Auth::user()->name;
           $ses =Auth::user()->activesession;
           #call batching  
            #Update Complete Registration Status
            DB::UPDATE('CALL UpdateCompleteStatus(?)',array($matricno));
             ini_set('max_execution_time', 300);
             $data = DB::SELECT('CALL GetConfirmation(?)', array($matricno));
             $result = ['data'=>$data];
             PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                  // pass view fil
             $pdf = PDF::loadView('screeningconfirmation',$result);
             //return $pdf;

                //Send Email
           $data["email"] = Auth::user()->email;
           $data["client_name"]=Auth::user()->name;
           $data["subject"]="Predegree Registration Confirmation";
           $data["fileName"] = Auth::user()->name;
           try
           {
                Mail::send('emails.courseForm', $data, function($message)use($data,$pdf)
                {
                    $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(),  $data['fileName'].".pdf");
               });
           }catch(JWTException $exception){
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }
            if (Mail::failures()) {
                $this->statusdesc  =   "Error sending mail";
                $this->statuscode  =   "0";

            }else
            {

            $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "1";
            }

            //return $pdf->download($fname.'.pdf');


              return $pdf->download($name.'.pdf');
              //return view('screeningconfirmation',['data'=>$data]);             
               

              // $res = DB::SELECT('CALL GetScreeningClearnanceByUTME()', array($matricno));
        }
        else
        {
             return view('logon');
        }
    }
    public function QuaData(Request $request)
    {
        if(Auth::check())
        {
            $matricno = Auth::user()->matricno;
            $subject  = $request->input('subject');
            $grade    = $request->input('grade');
            $examno   = $request->input('examnumber');
           //check against duplicate record in qualification
           //dd($subject.' '.$grade.' '.$examno);
            $ck  = DB::SELECT('CALL CheckQualificationDuplicateBySubject(?,?)', array($subject,$examno));
           //dd($ck);
            if($ck)
            {
                return back()->with('error', $subject. ' With '.$examno. ' Already Exist, Please Try Again');
            }

            $qry = DB::INSERT('CALL UGQualification(?,?,?,?)', array($matricno, $subject, $grade, $examno));
          
            if($qry)
            {
                return back()->with('success', 'Record Added Successfully');
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
    public function Qual()
    {
        if(Auth::check())
        {
            $matricno = Auth::user()->matricno;
            $rec = DB::SELECT('CALL FetchPrequalificationRecordByMatricNo(?)', array($matricno));
            $data = DB:: SELECT('CALL FetchQualificationRecordByMatricNo(?)',array($matricno));
           // dd(Auth::user()->email);
            $sub = DB:: SELECT('CALL FetchSubjects()');

            return view('ugQualification',['rec'=>$rec, 'data'=>$data, 'sub'=>$sub]);
        }
        else
        {
            return view('logon');
        }
    }
    public function DeletePreQ($id)
    {
        if(Auth::check())
         {
           DB::table('u_g_pre_qualifications')->where('id', $id)->delete();
           return redirect()->route('ugpreQ');
         }
         else
        {
            return view('logon');
        }
    }
     public function PreQdata(Request $request)
     {
         $exno  = $request->input('examnumber');
         $exdate =$request->input('examdate');
         $exname =$request->input('examname');
         //$seat =$request->input('seatings');
         if(Auth::check())
         {
             $matricno = Auth::user()->matricno;
            if($request)
            {

                //check against duplicate records
                 $ck  = DB::SELECT('CALL CheckPreQualificationDuplicateByExamNo(?)', array($exno));
                 if($ck)
                 {
                    return back()->with('error', 'Examination Details Already Exist, Please Try Again');
                 }
                 $addRec = DB::INSERT('CALL UGPreQualification(?,?,?,?)', array($matricno,$exname, $exno, $exdate));
                if($addRec)
                {
                    return back()->with('success', 'Record Added Successfully');
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
     public function PreQual()
     {
        if(Auth::check())
        {
          $mat = Auth::user()->matricno;
          $rec = DB::SELECT('CALL FetchPrequalificationRecordByMatricNo(?)', array($mat));
          return view('ugpreQ',['data'=>$rec]);
        }
        else
        {
            return view('logon');
        }
     }
     public function GetDepartment($dep="")
     {
         if(Auth::check())
         {
          
         // Fetch Employees by Departmentid
           //  $empData['data'] = ClassSetup::orderby("ClassName","asc")
             $empData['data'] = DB::SELECT('CALL GetDepartmentByFacultyID(?)', array($dep));
            return response()->json($empData);
         }
     }

     public function GetProgramme($prog="")
     {
      if(Auth::check())
       {
       

           $empData['data'] =  DB::table('pgprogramme') ->select('programmeid', 'departmentid', 'programme','degree')
                                                        ->where('departmentid', $prog)
                                                        ->where('degree','Ph.D')
                                                        ->get();   
           //DB::SELECT('CALL GetProgrammeByDepartmentID(?)', array($prog));
          // dd($empData);
           return response()->json($empData);
           }
        }   
    public function ReturnStateName($stateid)
    { 
        if($stateid)
        {
            $sta = DB::table('statelist')->where('stateid', $stateid)
                                         ->first();
            if($sta){
                return $sta->name;
            }
            else
            {
                return 0;
            }
        }

    }
     public function StudentData(Request $request)
     {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            //Student Personal Biodata
            $apptype= Auth::user()->apptype;
           // dd($apptype);
            $surname = $request->input('surname');
            $session = $request->input('session');
            $firstname = $request->input('firstname');
            $othername = $request->input('othername');
            $matricno = Auth::user()->matricno;
            $email = $request->input('email');

            $dob = $request->input('dob');
           
            $phone = $request->input('phone');
            $address = $request->input('address');
            $gender = $request->input('gender');
            $marital = $request->input('maritalstatus');
            $state = $request->input('state');
            $town = $request->input('town');
            $lga = $request->input('lga');
            $faculty = $request->input('faculty');
            $photo = $request->input('photo');
            $religion = $request->input('religion'); 
            $admissiontype = $request->input('admissiontype');
            $uuid = Str::uuid()->toString();
            $file_path = $request->file('photo');
            $file_tmp = $_FILES['photo']['tmp_name'];
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
            $size = filesize($file_tmp);
            //SESSION VARIABLES
            session(['dob' => $dob]);
            session(['phone' => $phone]);
            session(['address' => $address]);
            session(['gender' => $gender]);
            session(['marital' => $marital]);
            session(['town' => $town]);
            session(['state' => $state]);
            session(['faculty' => $faculty]);
            session(['photo' => $photo]);
            session(['religion' => $religion]);
            session(['lga'=> $lga]);
            session(['admissiontype' => $admissiontype]);
            session(['category1' => $category1]);
            session(['category2' => $category2]);
            $usrt = "Student";
            //Parent Biodata
            $psurname = $request->input('psurname');
            $pfirstname = $request->input('pfirstname');
            $pemail = $request->input('pemail');
            $relation = $request->input('relation');
            $pphone = $request->input('pphone');
            $paddress = $request->input('paddress');
            //Session Variables
             session(['psurname' => $psurname]);
             session(['pfirstname' => $pfirstname]);
             session(['pemail' => $pemail]);
             session(['relation' => $relation]);
             session(['pphone' => $pphone]);
             session(['paddress' => $paddress]);
            //Check against duplicate records
             ///checks
             $st_email  = DB::SELECT('CALL CheckBiodataDuplicateRecordByEmail(?)',array($email));
             $st_phone  = DB::SELECT('CALL CheckBiodataDuplicateRecordByPhone(?)',array($phone));
             $st_matric = DB::SELECT('CALL CheckBiodataDuplicateRecordByMatricNo(?)',array($matricno));
             //parent info
                $ck_email  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByEmailAndMatricNo(?,?)',array($email,$matricno));
                $ck_phone  = DB::SELECT('CALL CheckParentInfoDuplicateRecordByPhoneAndMatricNo(?,?)',array($phone,$matricno));

            // dd($ck_email);
            if($apptype =='PDS' || $apptype=='JUP')
            {
                if($category1 == $category2)
                {
                  return back()->with('error', 'Pleae Select Different Categories, Please Try Again');
                }
            }
            if($size>20000)
            {
                return back()->with('error', 'Photo Must Not Greater Than 20K, Please Retry');
            }
          
            // if($st_matric[0]->Mat== 1)
            // {
            //     return back()->with('error', 'MatricNo Already Exist, Please Try Again');
            // }
            
          
            //Save a copy of the uploaded file
            $ses = str_replace("/","",Auth::user()->activesession);
            $input['imagename'] = $matricno.'.'.$file_path->getClientOriginalExtension();
            $destinationPath = public_path('/Passports/'.$apptype.$ses);
            $file_path->move($destinationPath, $input['imagename']);
            $imgP=$input['imagename'];
            $photo=$imgP;
            //dd($destinationPath);
            $admissiontype = Auth::user()->apptype;
            $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array(Auth::user()->matricno));
            $sta = $this->ReturnStateName($state);
            #Check if Record Exist
            if(!$result)
            {
                    if($apptype =="PT")
                    { 
                        $level = $request->input('level');
                        //dd($level);
                        $sav = DB::INSERT('CALL SavePreAdmissionInfoPT(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                                    array($matricno,
                                        $firstname,
                                        $surname,
                                        $othername,
                                        $email,
                                        $phone,
                                        $gender,
                                        $dob,
                                        $marital,$town,
                                        $sta,$address,
                                        $photo,$category1,
                                        $category2,$session,
                                        $admissiontype,$religion,$level));
                    }
                    else
                    {
                        
                        $level =0;
                        $sav = DB::INSERT('CALL SavePreAdmissionInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                                    array($matricno,
                                        $firstname,
                                        $surname,
                                        $othername,
                                        $email,
                                        $phone,
                                        $gender,
                                        $dob,
                                        $marital,$town,
                                        $sta,$address,
                                        $photo,$category1,
                                        $category2,$session,
                                        $admissiontype,$religion));
                    }
                
                    if($sav)
                    {
                        //Update student usertype and photo
                        $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));
                        ///Insert record to UG Parent Biodata
                        $pat = DB::INSERT('CALL UGSaveParentsData(?,?,?,?,?,?,?,?)',
                            array($matricno,$psurname,$pfirstname,$pemail,$pphone,$paddress,$relation,$uuid));
                        if($pat)
                        {
                        //return back()->with('success', 'Record Saved Successfully');
                            return redirect()->route('ugpreQ');
                        }
                        else
                        {       //Remove record from UG Biodata
                            DB::DELETE('CALL RemoveRecordFromUGBiodataByMatricno(?)', array($matricno));
                            return back()->with('error', 'Operation Failed, Please Retry Again');
                        }


                    }
            }
           else
           {
              #Update existing user record
              DB::table('u_g_pre_admission_regs')->where('matricno', Auth::user()->matricno)
                                                 ->update(['surname'=>$surname,
                                                           'firstname'=>$firstname,
                                                           'othername' =>$othername,
                                                           'phone'=>$phone,
                                                           'gender'=>$gender,
                                                           'dob'=>$dob,
                                                           'maritalstatus' =>$marital,
                                                           'town'=>$town,
                                                           'lga'=>$lga,
                                                           'state'=>$sta,
                                                           'address'=>$address,
                                                           'photo'=>$photo,
                                                           'category1' =>$category1,
                                                           'category2' =>$category2,
                                                           'session' =>$session,
                                                           'religion'=>$religion,
                                                           'admissiontype'=>$admissiontype
                                                         ]);
            $ups= DB::UPDATE('CALL UpdatePhotoInUsers(?,?)', array($photo,$matricno));
            DB::table('u_g_parent_infos')->where('matricno', $matricno)
                                         ->update(['surname'=>$psurname,
                                                   'othername'=>$pfirstname,
                                                   'email'=>$pemail,
                                                   'phone'=>$pphone,
                                                   'address' =>$paddress,
                                                   'relation' =>$relation
                                                ]);
              //Track Submitted Application
              $this->TrackSubmittedApplication($gender,$state,$lga,$phone,$dob,$category1,$category2,$session);
              return redirect()->route('ugpreQ');
           }
        }
        else
        {
            return view('logon');
        }

     }
    
     public function TrackSubmittedApplication($gender,$state,$lga,$phone,$dob,$cat1,$cat2,$session)
     {
        $ck  = DB::table('trackapplications')->where('email', Auth::user()->email)
                                             ->where('session',$session)
                                             ->first();
        $r = new TrackApplications();
        $r->matricno = Auth::user()->matricno;
        $r->email = Auth::user()->email;
        $r->surname = Auth::user()->surname;
        $r->firstname =Auth::user()->firstname;
        $r->othername = Auth::user()->othername;
        $r->session = Auth::user()->activession;
        $r->apptype = Auth::user()->apptype;
        $r->gender  = $gender;
        $r->state = $state;
        $r->lga = $lga;
        $r->phone = $phone;
        $r->dob = $dob;
        $r->category1 = $cat1;
        $r->category2 = $cat2;
        if(!$ck) $r->save();




     }
     public function StudentInfo()
     {
        if(Auth::check())
        {
            $ispd = Auth::user()->ispaid;
            if($ispd==false)
            {
              return redirect()->route('home');
            }
            $mat = Auth::user()->matricno;
            $data = DB::SELECT('CALL GetCandidateInfoByMatricNo(?)', array($mat));
            $rec = DB::SELECT('CALL FetchStateList()');
            $ses = DB::SELECT('CALL FetchSession()');
            $pro = DB::SELECT('CALL FetchProgramme()');
            $pros = DB::SELECT('CALL FetchProgramme()');
            $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)',array($mat));
            $item = DB::SELECT('CALL FetchParentsData(?)',array($mat));
           // dd($result);
            return view('ugbiodata', ['data'=>$data,'item'=>$item, 'rec'=>$rec, 'pro'=>$pro,'pros'=>$pros, 'ses'=>$ses,'result'=>$result]);
        }
        else
        {
            return view('logon');
        }
     }

     public function ActivatedAccountResponse()
     {
         return view('accountActivated');
     }
     public function FinishingUp($act)
     {
         $rec=""; $m=0;
         $ac= DB::UPDATE('CALL ConfirmSignupAccount(?)', array($act));
         if($ac)
         {
             $m=1;
            $rec ="Congratulations!!!,Your Confirmation Successful. Please login to complete your registration.";
         }
         else
         {
             # code..
             $m=0;
             $rec ="Sorry!, Your Confirmation Not Successful. Please check and try again.";
         }
         return view('accountActivated', ['rec'=>$rec, 'm' =>$m]);
     }
    public function SignupResponse()
    {
        return view('signupResponse');
    }
   protected function validator(array $data)
   {
       return Validator::make($data, [
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8', 'confirmed'],
       ]);
   }
   public function SignUpNow(Request $request)
   {
       $surname = $request->input('surname');
       $firstname = $request->input('firstname');
       $othername = $request->input('othername');
       $email = $request->input('email');
       $mat = $request->input('matricno');
       $password  = $request->input('password');
       $password2 = $request->input('password2');
       $session   = $request->input('session');

   
            $uuid = Str::uuid()->toString();
            $pw = Hash::make($password);
            $name=  $surname. '  '. $firstname. ' '.$othername;
            $da = Carbon::now();// will get you the current date, time
            $yr= $da->format("Y");
            $id = mt_rand(100000, 999999);
            $mat =date("dmY").$id;
            ///checks
             $emailCheck  = DB::table('users')->where('email',$email)
                                              ->where('isadmitted', 1)
                                              ->first();

                if($emailCheck)
                {

                    $msg = "The Applicant Associated With This Email Address Has Been Offered Admission ". $emailCheck->activesession ." Session, Please Use Another Email Addresss.";
                    return json_encode(array("statusCode"=>201,'msg'=>$msg));
                    //return back()->with('error', $msg);
                }

     
        if($password!=$password2)
        {
           
            $msg = "Password Mismatch, Please Try Again and Make Sure Your Passwords are the same.";
            return json_encode(array("statusCode"=>203,'msg'=>$msg));
            //return back()->with('error', $msg);

        }

        $lpass =strlen($password);
        if(strlen($password) < 1 )
        {
            //return back()->with('error', 'Password Must Be Up To 8 or More Characters, Please Try Again');
            $msg = "Password Must Be Up To 8 or More Characters, Please Try Again.";
            return json_encode(array("statusCode"=>205,'msg'=>$msg));
        }

       if($request)
       {
        
             $d ="12345678";
             $mypassword=Hash::make($d);
            
            
                    $ip = $this->getIPAddress();
                    $usr="Candidate";
                    #Check if the email already exist,for update or create new record
                    //$emailExist  = DB::table('users')->where('email',$email)
                                                    // ->first();
                    $emailExist = $this->CheckStatusDuplication($email, 'users');
                    ///dd($emailExist);
                    if($emailExist == true)
                    {
                       $dat = DB::table('users')->where('email', $email)
                                                ->update([ 'name' => $surname . ' '.$firstname .' '.$othername,
                                                          'surname'   =>$surname,
                                                          'firstname' =>$firstname,
                                                          'othername' =>$othername,
                                                          'password'  =>$mypassword,
                                                          'activesession'   =>$session,
                                                          'isactive' =>0,
                                                          'matricno' =>$mat,
                                                          'guid'=>$uuid,
                                                          'iscomplete' => false]);
                        #Update Info Matricno and parent
                        DB::UPDATE('CALL UpdateApplicantPreviousInfo(?,?)', array($email, $mat));
                        #Send Activation Email
                        $this->SendActivationEmail($email, $mat, $uuid);
                        #Track the user application
                        $this->TrackUserApplications($email,$session,$surname,$firstname,$othername);
                    }
                    else if($emailExist == false)
                    {
                        $crea = DB::INSERT('CALL CreateStudentAccount(?,?,?,?,?,?,?,?,?,?,?,?)',
                        array($name,$email,$uuid,$pw,$mat,$firstname,$surname,$othername,$session,$usr,$mypassword,$ip));
                       // $this->TrackUserApplications($email, $session,$surname,$firstname,$othername);
                         #Send Activation Email
                         $this->SendActivationEmail($email, $mat, $uuid);
                    }
                    else
                    {
                          $msg = "This Applicant Has Completed Registration.";
                          return json_encode(array("statusCode"=>205,'msg'=>$msg));
                    }
                 
                 
                   // return redirect()->route('logon');
                   return view('signupResponse');

       }

   }

    public function SendActivationEmail($email, $name, $uuid)
    {
                        $url= config('paymentUrl.activation_url');
                        $parameters =
                        '{
                        "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                        "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                        "to": [ { "email_address": { "address": "'.$email.'", "name": "'.$name.'" }}],
                        "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                        "subject": "LAUTECH Account Verification",
                        "textbody": "Thank you for signifying interest in LAUTECH Admissions.:",
                        "htmlbody": "<html><body>Thank you for signifying interest in LAUTECH Admissions. Your account has been successfully created. Please click on the link below to activate your account. <img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"'.$url.$uuid.'\">Verity Your Account</a></h1></body></html>",
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
                //var_dump($server_output);
                curl_close ($ch);

    }

   
   public function TrackUserApplications($email, $session, $s,$f,$o)
   {
     if($email && $session)
     {
         $data  = new TrackUserApplication();
         $data->email = $email;
         $data->session = $session;
         $data->surname = $s;
         $data->firstname = $f;
         $data->othername =$o;
         $res = $this->CheckApplication($email, $session);
         if($res== false) $data->save();
     }
   }
   public function CheckStatusDuplication($email,$table)
   {
       $res = DB::table($table)->where('email', $email)
                               ->where('iscomplete', false)
                               ->first();
      if($res)
      {
        return true;
      }
      else
      {
        return false;
      }
   }
   public function CheckApplication($email,$session)
   {
       $res = DB::table('trackuserapplication')->where('email', $email)
                                ->where('session', $session)
                                ->first();
      if($res)
      {
        return true;
      }
      else
      {
        return false;
      }
   }
    public function Reg()
    {
        //
        $lst = DB::SELECT('CALL FetchSession()');
        //dd($ses);
        return view('reg', ['lst'=>$lst]);
    }
    public function logon()
    {
        return view('logon');
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
     public function getIPAddress()
     {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP']))
      {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
      }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
     {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else
    {  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
   }  
}
