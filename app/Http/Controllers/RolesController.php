<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SuspendRoleByAdmin($id,$sta)
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
            DB::UPDATE('CALL SuspendUserRoleByAdmin(?,?)',  array($id,$st));
            return redirect()->route('createusers');
        }
       else
       {
         return view('logon');
       }
    }
    public function DeleteRoleByAdmin($id)
    {
        if(Auth::check())
        {
             DB::DELETE('CALL DeleteUserRoleByAdmin(?)', array($id));
             return redirect()->route('createusers');
        }
        else
        {
                 return view('logon');
        }
    }
    public function DeleteRoleBySection($id,$rol)
    {
        if(Auth::check())
         {
           DB::DELETE('CALL DeleteUserRoleBySection(?,?)', array($id,$rol));
           return redirect()->route('createusers');
         }
        else
        {
            return view('logon');
        }
    }
    public function AddUsers(Request $request)
    {
      if(Auth::check())
       {
        ////Addmin Details//////
        $staffID = Auth::user()->matricno;
        $email = Auth::user()->email;
        ///////New User Detail////////
        $uuid = Str::uuid()->toString();
        $fr  = $request->input('firstname');
        $sr  = $request->input('surname');
        $oth = $request->input('othername');
        $ph  = $request->input('phone');
        $ema = $request->input('email');
        $sta = $request->input('staffid');
        $rol = $request->input('role');
        $sec = $request->input('section');
        $name =  $sr. '  '. $fr;
        $session=0;
        $ses = Auth::user()->activesession;
        $pwd="12345678";
        $pw = Hash::make($pwd);
        ///Check Mulitple entry by email
         $ck        = DB::SELECT('CALL CheckAccountSignupDuplicateByEmail(?)', array($ema));
         $ck_st = DB::SELECT('CALL CheckAccountSignupDuplicateByMatricNo(?)',array($sta));
        //Current User Role
          $urol = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffID));
        //dd($urol);
          if($ck[0]->Email==   1)
          {
             return back()->with('error', 'Email Address Already Exist, Please Try Another Email Address');
          }
          if($ck_st[0]->Mat== 1)
          {
            return back()->with('error', 'StaffID Already Exist, Please Try Again');
          }
     // dd($urol);
        if($request) 
        {
            $usr="Staff";
            $crea = DB::INSERT('CALL CreateStaffAccount(?,?,?,?,?,?,?,?,?,?)',
            array($name,$ema,$uuid,$pw,$sta,$fr,$sr,$oth,$usr,$ses));
            if($crea)
            {
                 $ro = DB::INSERT('CALL CreateRoles(?,?,?,?,?,?)', array($rol,$sec,$sta,$urol[0]->roleid,$ema,$email));
                 if($ro)
                 {
                  $parameters =
                  '{
                     "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                     "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                     "to": [ { "email_address": { "address": "'.$email.'", "name": "'.$email.'" }}],
                     "reply_to":[{"address": "webmaster@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                     "subject": "LAUTECH Admissions Password Reset",
                     "textbody": "Please note, your password has been reset to: ",
                     "htmlbody": "<html><body>Please, click the button below to Reset Your Password<img src=\"cid:img-welcome-design\"> <img src=\"cid:img-CTA\"><h1><a href=\"http://apply.lautech.edu.ng/changePassword/'.$uuid.'\">Create Password</a></h1></body></html>",

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
                  return back()->with('success', 'Record Added Successfully');
                 }
                 else
                 {
                     return back()->with('error', 'Record Not Saved');
                 }
             }
         }
       
       }    
         
            return view('createusers');
    }
    public function CreateUser()
    {
        if(Auth::check())
        {
          $usr = Auth::user()->usertype;
           if($usr=="Admin")
           {
             $email =Auth::user()->email;
            // $urol = DB::SELECT('CALL GetCurrentUserRole(?)', array($email));
             $data = DB::SELECT('CALL FetchUserAccessByAdmin()');
             $rol  = DB::SELECT('CALL FetchRoles()');
             $sec  = DB::SELECT('CALL FetchSections');

             return view('createusers',['rol'=>$rol, 'sec'=>$sec,'data'=>$data]);
          }
          else
          {
            $staffid =Auth::user()->matricno;
            $urol = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
            //dd($urol);
            $data = DB::SELECT('CALL FetchUserAccessBySection(?)',array($urol[0]->section));
            $rol  = DB::SELECT('CALL FetchRoles()');
            $sec  = DB::SELECT('CALL FetchSections');
            return view('createusers',['rol'=>$rol, 'sec'=>$sec,'data'=>$data]);
          }


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
