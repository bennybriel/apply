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
class UpdatesController extends Controller
{
    //
    public function UpdateStudentInfo()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $st = DB::SELECT('CALL FetchStateList');
            return view('updateStudentInfo',['st'=>$st]);
        }
        else
        {
            return view('logon');
        }
    }
    public function UpdateStudentInfos(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $utme =$request->utme;
            $surname = $request->surname;
            $firstname = $request->firstname;
            $othername = $request->othername;
            $lga       = $request->lga;
            $state     = $request->state;
            $sta = DB::table('statelist')->where('stateid',$state)->first();
            $name = $surname.' '.$firstname. ' '.$othername;
            $u = DB::table('users')->where('utme',$utme)->update(['name'=>$name,
                                                                  'surname'=>$surname,
                                                                  'firstname'=>$firstname,
                                                                  'othername'=>$othername]);
            $u1 = DB::table('u_g_pre_admission_regs')->where('utme',$utme)->update(['lga'=>$lga,
                                                                  'state'=>$sta->name,
                                                                  'surname'=>$surname,
                                                                  'othername'=>$name]);

           if($u1 || $u)
           {
             session(['utme'=>null]);
             $script = "<script>
                          alert('Record Update Successfully ');
                     </script>";
             echo $script;
            
             return view('studentInfo');
           }
           else
           {
              session(['utme'=>null]);
              return back()->with('error','Operation Failed, Please Try Again');
           }
        }
        else
        {
            return view('logon');
        }
    }
    public function StudentInformations(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            //session(['data' => null]);
            $utme =$request->utme;
            $data = DB::table('users as us')
                        ->join('u_g_pre_admission_regs as rg','rg.matricno','=','rg.matricno')
                        ->where('us.utme',$utme)
                        ->first();
            if($data)
            {
                //session(['data'=>$data]);
                return redirect()->route('updateStudentInfo');
            }
            else
            {
                return back()->with('error','No Record Found, Please Try Again');
            }
          
        }
        else
        {
            return view('logon');
        }
    }
    public function StudentInformation()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
          
            return view('studentInfo');
        }
        else
        {
            return view('logon');
        }
    }
    public function LGAList()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
          
            $data = DB::table('users')
                                    
                                     ->join('u_g_pre_admission_regs as rg','rg.matricno','=','users.matricno')
                                     ->orwhere('apptype','JUP')
                                     ->orwhere('apptype','PDS')
                                     ->where('isadmitted','1')
                                     ->orderby('formnumber','asc')
                                     ->get();

            $st = DB::SELECT('CALL FetchStateList');
            return view('lgaList',['st'=>$st,'data'=>$data]);
        }
        else
        {
            return view('logon');
        }
    }
    public function GetLGA($sta="")
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
         {
         // Fetch Employees by programme
             $empData['data'] = DB::SELECT('CALL GetLGAByStateID(?)', array($sta));
             return response()->json($empData);
          }
    }   
    public function UpdateLGAs(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $lga = $request->lga;
            $frm = $request->formnumber;
            $state =$request->state;
            $mat = $request->matricno;
            $sta = DB::table('statelist')->where('stateid',$state)->first();
            $up =DB::table('u_g_pre_admission_regs')->where('matricno', $mat)->update(['lga'=>$lga,'state'=>$sta->name]);
           if($up > 0)
           {
               return back()->with('success','Update Successful');
           }
           else
           {
              return back()->with('error','Operation Failed, Please Try Again');
           }
           
        }
        else
        {
            return view('logon');
        }
    }
    public function UpdateLGA()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
          
            $frm = DB::table('users')->orwhere('apptype','JUP')
                                     ->orwhere('apptype','PDS')
                                     ->orderby('formnumber','asc')
                                     ->get();
            $st = DB::SELECT('CALL FetchStateList');
            return view('updateLGA',['frm'=>$frm,'st'=>$st]);
        }
        else
        {
            return view('logon');
        }
    }
    public function UpdateUserPassword($id)
    {
        if($id)
        {
            $ps = DB::UPDATE('CALL 	UpdateUsersPasword(?)',array($id));
            if($ps > 0)
            {
                return back()->with('success','Update Successful');
            }
            else
            {
                return back()->with('error','Operation Failed, Please Try Again');
            }
        }

    }
    public function UpdateRegisteredProgramme(Request $request)
    {
        if(Auth::check())
        {
            $matricno = $request->matricno;
            $prog = $request->programme;
           // dd($matricno.'  '.$prog);
            if($request)
            {
               $up =  DB::UPDATE('CALL UpdateRegisteredProgramme(?,?)',array($matricno,$prog));
               if($up > 0)
               {
                   return back()->with('success','Update Successful');
                  // return redirect()->route('changeUTMEProgramme');
               }
               else
               {
                  return back()->with('error','Operation Failed, Please Try Again');
               }
            }
            else
            {
               return back()->with('error','Operation Failed, Please Try Again');
            }
        }
        else
        {
            return view('logon');
        }
    }
    public function ChangeRegistered()
    {
        if(Auth::check())
        {
          
            $data = DB::SELECT('CALL FetchRegisteredApplicant()');
            $prog = DB::SELECT('CALL FetchAdmissionProgrammeDistinct()');
            //dd($prog);
            return view('changeRegisteredProgramme',['data'=>$data,'p'=>$prog]);
        }
        else
        {
            return view('logon');
        }
    }
    
    public function UpdateProgramme(Request $request)
    {
        if(Auth::check())
        {
            $utme = $request->utme;
            $prog = $request->programme;

            if($request)
            {
               $up =  DB::UPDATE('CALL UpdateUTMEProgramme(?,?)',array($utme,$prog));
               if($up > 0)
               {
                   return back()->with('success','Update Successful');
                  // return redirect()->route('changeUTMEProgramme');
               }
               else
               {
                  return back()->with('error','Operation Failed, Please Try Again');
               }
            }
            else
            {
               return back()->with('error','Operation Failed, Please Try Again');
            }
        }
        else
        {
            return view('logon');
        }
    }
    public function ChangeUTMEProgramme()
    {
        if(Auth::check())
        {
          
            $data = DB::SELECT('CALL FetchUTMEInformation()');
            $prog = DB::SELECT('CALL FetchAdmissionProgrammeDistinct()');
            //dd($prog);
            return view('changeUTMEProgramme',['data'=>$data,'p'=>$prog]);
        }
        else
        {
            return view('logon');
        }
    }
}
