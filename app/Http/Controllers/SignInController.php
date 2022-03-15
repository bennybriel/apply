<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\resetEmail;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Session;

class SignInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function ChangeDefaultPassword($email)
   {
      $pass=$this->randomPassword();           
      $ck = DB::SELECT('CALL ValidateEmailAddress(?)', array($email));
        if($ck)
        {
            $url = "http://apply.lautech.edu.ng/changePassword".$ck[0]->guid;
        
            $en_pas = Hash::make($pass);
            if($email)
            {
                $rs = DB::UPDATE('CALL ResetUserPassword(?,?)', array($email, $en_pas));
                if($rs)
                {
                        $parameters =
                        '{
                            "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                            "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                            "to": [ { "email_address": { "address": "'.$email.'", "name": "'.$email.'" }}],
                            "reply_to":[{"address": "webmaster@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                            "subject": "LAUTECH Admissions Password Reset",
                            "textbody": "Please note, your password has been reset to: '.$pass.'",
                            "htmlbody": "<html><body>Please, click the button below to Reset Your Password<img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"http://apply.lautech.edu.ng/changePassword/'.$ck[0]->guid.'\">Reset Password</a></h1></body></html>",
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
                    curl_close ($ch);
                }

                return true;

            }
        }
        
   }
    public function CandidateProfile($mat)
    {
        $data = DB::SELECT('CALL GetConfirmation(?)', array($mat));
        if($data)
        {
            $message='User signed in';
              $response = [
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ];
    
            return response()->json($response, 200);
            
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
    
            return response()->json($response, $code);
        }
    }
    public function AuthenticateMe($u,$p)
    {
       // dd($p);
        if (Auth::attempt(['email' => $u, 'password' => $p]))
        {
            
            $msg = "Login Succcessful";
            return json_encode(array("statusCode"=>200,'msg'=>$msg));
        }
        else
        {
            $msg = "Login Faiied";
            return json_encode(array("statusCode"=>401,'msg'=>$msg));

        }

    }
    public function TestPay()
    { 
         $client = new \GuzzleHttp\Client();
         $user="ade"; $pass_code="17488";$amount =2000;$hash_value="yugwergyuqerw87r78jhsd";
         return redirect()->away('http://localhost/test?user=user');

         //return redirect()->away('http://www.google.com');
        $triggersms = file_get_contents('http://www.cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=efg&password=abcd&msisdn=9197xxx2&sid=MYID&msg=Hello');
       // return $triggersms;
        /*
         
          $res = $client->request('GET', 'http://github.com', [
            'allow_redirects' => true
          ]);
          */
          $res = $client->request('POST', 'https://bennybriel.com', [
            'msg' => [
                 'allow_redirects' => true,
                'field_name' => 'abc',
                'other_field' => '123',
                'nested_field' => [
                    'nested' => 'hello'
                ]
            ]
        ]);
       

       // return redirect()->away('http://www.google.com');
      //return $res;
    }
   public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        //return implode($pass); //turn the array into a string
        return implode($pass);
    }

     public function ResetForgotPassword(Request $request)
     {
              $email = $request->input('email');
              $pass=$this->randomPassword();
            
              $ck = DB::SELECT('CALL ValidateEmailAddress(?)', array($email));
              if($ck)
              {
                $url = "http://apply.lautech.edu.ng/changePassword".$ck[0]->guid;
               // dd($url);
              //$pass = substr(mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999), 1,5);
                  $en_pas = Hash::make($pass);
                  if($email)
                  {
                      $rs = DB::UPDATE('CALL ResetUserPassword(?,?)', array($email, $en_pas));
                      if($rs)
                      {
                            $parameters =
                             '{
                                "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                                "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                                "to": [ { "email_address": { "address": "'.$email.'", "name": "'.$email.'" }}],
                                "reply_to":[{"address": "webmaster@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                                "subject": "LAUTECH Admissions Password Reset",
                                "textbody": "Please note, your password has been reset to: '.$pass.'",
                                "htmlbody": "<html><body>Please, click the button below to Reset Your Password<img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"http://apply.lautech.edu.ng/changePassword/'.$ck[0]->guid.'\">Reset Password</a></h1></body></html>",
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
                        curl_close ($ch);
                      }

                      return back()->with('success', 'Password Reset Code Sent to the email');

                  }
              }
              else 
               {
                 return back()->with('error', 'Sorry, Email Not Exist, Please Try Again');
               }

     }
     public function ForgotPassword()
     {
         return view('forgotPassword');
     }
     public function SuspendAccount($mem, $ema,$sta)
     {
         if(Auth::check())
         {
             $status =0; $msg ="";
             if($mem)
             {
                 if($sta=="0")
                 {
                     $status =1;
                     $msg = "Please your account has been unsuspended";
                 }
                 else
                 {
                     $status =0;
                     $msg = "Please your account has been suspended. Contact the administrator for details";
                 }
                 $su = DB::UPDATE('CALL SuspendUserAccount(?,?)', array($mem, $status));
                 if($su)
                 {
                    $details =
                            [   'title'=>"",
                                'body'=>"FOPAJ Membership Account Information",
                                'parts'=>$msg,
                                'team' =>"FOPAJ Team"

                            ];

                         Mail::to($ema)->send(new suspendEmail($details));
                 }
                return redirect()->route('viewUsers');
             }

         }

     }
     public function ResetPassword($sta,$ema)
     {
         if(Auth::check())
         {
              $pass="fopaj@12345";
              //$pass = substr(mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999), 1,5);
              $en_pas = Hash::make($pass);
              if($mem)
              {
                  $rs = DB::UPDATE('CALL ResetUserPassword(?,?)', array($mem, $en_pas));
                  if($rs)
                  {
                     $details =
                             [   'title'=>"",
                                 'body'=>"FOPAJ Membership Account Password Reset",
                                 'parts'=>"Please note, your password has been reset to ". $pass,
                                 'team' =>"FOPAJ Team"

                             ];

                          Mail::to($ema)->send(new resetEmail($details));
                  }
                 return redirect()->route('viewUsers');
              }
         }
     }

    public function UpdateStudentPassword(Request $request)
    {
         if(Auth::check())
          {       //dd($request->password);
            $matricno = Auth::user()->matricno;
            if( $request->password !=  $request->confirmpassword)
            {
                return back()->with('error', 'Password Mismatch.');
            }

           // if (Auth::attempt(['matricno' => $request->matricno, 'password' => $request->old_password]))
            //dd($request->matricno);
            if (Auth::attempt(['matricno' => $matricno, 'password' => $request->old_password]))
            {
                if (Hash::check($request->old_password, Auth::user()->password) == false)
                {
                    return back()->with('error', 'Unauthorized.');
                }

                //User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
                //DB::table('users')->find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
                   $p = DB::table('users')
                          ->where('matricno', $matricno)
                          ->update(['password'=> Hash::make($request->password)]);
          


                         //$affected = DB::table('users')
                         //                 ->where('matricno', $matricno)
                         //                 ->update(['status' => '1']);

               //dd($p);
                       if($p==1)
                        {
                           return back()->with('success', 'Password Updated Successfully.');
                        }
                        else
                        {
                            return back()->with('error', 'Password Update Not Successful. Please Try Again');
                        }
                 }
                else
                {
                    return back()->with('error', 'Current password Invalid.');
                }
        }
        else
        {
            return view('logon');
        }
    }
    public function PasswordChange()
    {
        if(Auth::check())
        {
            $email =Auth::user()->email;
            return view('changeMyPassword', ['email'=>$email]);
        }
    }
    public function changePassword($guid)
    {
        return view('changePassword',['guid'=>$guid]);
    }

   public function UpdatePassword(Request $request)
   {
       $ck = DB::SELECT('CALL ValidateGUID(?)',array($request->guid));
        if($ck)
        {
           
            $p = DB::table('users')
                        ->where('guid', $request->guid)
                        ->update(['password'=> Hash::make($request->password)]);
                $affected = DB::table('users')
                                        ->where('guid', $request->guid)
                                        ->update(['status' => '1']);

               if($p==1)
                {
                    return redirect('logon');
                }
                else
                {
                    return back()->with('error', 'Password Update Not Successful. Please Try Again');
                }
        }
        else
        {
            return back()->with('error', 'Password Reset Failed. Please Reset Passord Again');
        }   

   }
   public function logons()
   {
       return view('logons');
   }
    public function AuthUser()
    {
        cache()->store('redis')->tags('awesome-tag')->flush();
        return view('logon');
    }
    public function AuthIn(Request $request)
    {
                $data = $request->session()->all();
                $request->session()->forget('data');
                Auth::logout();
                $request->session()->flush();
               
          if(Auth::check() && Auth::user()->id > 0)
          {
               /// dd($data);
                return back()->with('error', 'Sorry, There Is An Active User, Please Logout The Current User And Continue.');
          }
      
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
             #Check if the user login somewhere else
              $user = User::findOrFail(Auth::user()->id);
              $this->swapping($user);
              
             $sid = DB::table('users')->where('email', $request->email)->first();
            //dd($sid->isActive);
              if($sid->locked == '0')
              {
                //$request->session()->destroy();
                //$data = $request->session()->all();
                return back()->with('error', 'Sorry,You are temporarily locked out for maintenance purpose, you will be unlocked shortly.');
              }
             if($sid->isactive == '0')
             {
               return back()->with('error', 'Account Inactive, Please Contact Administrator');
             }
             if($sid->status == '0')
             {
                 session(['email' => $request->email]);
                //return redirect('changePassword');
                 $pas = $this->ChangeDefaultPassword($request->email);
                 if($pas==true)
                 {
                      return back()->with('success', 'Password Reset Code Sent to the email');
                 }
              }
           /* */
            // Authentication passed...
            return redirect('home');
        }
        
        elseif(Auth::attempt(['utme' => $request->email, 'password' => $request->password]))
        {
              #Check if the user login somewhere else
              $user = User::findOrFail(Auth::user()->id);
              $this->swapping($user);
              
             $sid = DB::table('users')->where('utme', $request->email)->first();
             if($sid->locked == '0')
             {
               
                return back()->with('error', 'Sorry,You are temporarily locked out for maintenance purpose, you will be unlocked shortly.');
             }
            if($sid->isactive == '0')
             {
                return back()->with('error', 'Account Inactive, Please Contact Administrator');
             }
            if($sid->status == '0')
             {
                session(['email' => $request->email]);
                return redirect('changePassword');
             }
          
            return redirect('home');
        }
       elseif(Auth::attempt(['formnumber' => $request->email, 'password' => $request->password]))
        { 
              #Check if the user login somewhere else
              $user = User::findOrFail(Auth::user()->id);
              $this->swapping($user);
            
            $sid = DB::table('users')->where('formnumber', $request->email)->first();
            if($sid->locked == '0')
            {
               //$request->session()->destroy();
               return back()->with('error', 'Sorry,You are temporarily locked out for maintenance purpose, you will be unlocked shortly.');
            }
           
            if($sid->isactive == '0')
             {
                return back()->with('error', 'Account Inactive, Please Contact Administrator');
             }
            if($sid->status == '0')
             {
                session(['email' => $request->email]);
                return redirect('changePassword');
             }
           
            
            return redirect('home');
        }
        else
        {
            return back()->with('error', 'Invalid Login. Please Login with Registered Email Address Only');
            //dd("login data incorrect!");

        }
    }
     public function swapping($user)
     {
        $new_sessid   = \Session::getId(); //get new session_id after user sign in
        $last_session = \Session::getHandler()->read($user->lastsession);  
        if ($last_session) 
        {
            if (\Session::getHandler()->destroy($user->lastsession))
             {
               
            }
        }
    
        $user->lastsession = $new_sessid;
        $user->save();
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
    
      public function Mys()
    {
        return view('mylogin');
    }
    public function My(Request $request)
    {
      
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            //dd($request->password);
            //dd($request->password);
            $sid = DB::table('users')->where('email', $request->email)->first();
            //dd($sid->isActive);
            if($sid->isactive == '0')
             {
                return back()->with('error', 'Account Inactive, Please Contact Administrator');
             }
            if($sid->status == '0')
             {
                session(['email' => $request->email]);
                return redirect('changePassword');
             }
           /* */
            // Authentication passed...
            return redirect('home');
        }
        else
        {
            return back()->with('error', 'Invalid Login.');
            //dd("login data incorrect!");

        }
    }
}
