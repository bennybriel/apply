<?php

namespace App\Http\Controllers;
use Auth;
use PDF;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\ApprovalEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CourseRegDisapproval(Request $request)
    {
         if(Auth::check())
        {
            if($request)
            {
                $pro = $request->input('pro');
                $lev = $request->input('lev');
                $ses = $request->input('ses');
                $sem = $request->input('sem');
                $mat = $request->input('mat');
                #Disapprove course registration
                $dsp =DB::UPDATE('CALL CourseRegistrationDisapproval(?,?,?,?,?)', array($mat,$ses,$sem,$lev,$pro));
                //dd($dsp);
               if($dsp)
               {
                 return back()->with('success', 'Course Registration Disapproval Successful');
               }
            }
            else
            {
                 return back()->with('error', 'Operation Failed, Please Retry Again');
            }

        }
        else
        {
             return view('logon');
        }

    }
    public function CourseDisapproval(Request $request)
    {
        if(Auth::check())
        {
            if($request)
             {
                $pro = $request->input('programme');
                $lev = $request->input('level');
                $ses = $request->input('session');
                $sem = $request->input('semester');

                session(['pro' => $pro]);
                session(['sem' => $sem]);
                session(['lev' => $lev]);
                session(['ses' => $ses]);
                //dd($lev.$pro.$ses.$sem);
                $data = DB::SELECT('CALL GetCourseRegistrationDisapproval(?,?,?,?)',array($ses,$sem,$lev,$pro));
                //dd($data);
                if(!$data)
                {
                   return back()->with('error', 'No Record Found, Please Retry Again');
                }
                 return redirect()->route('courseRegDisapproval');
                
                
            }
            else
            {
                  return back()->with('error', 'Operation Failed, Please Retry Again');
            }
        }
        else
        {
            return view('logon');
        }

    }
    public function DisapprovalReg()
    {
        if(Auth::check())
        {
             $staffid =Auth::user()->matricno;
             $usr = Auth::user()->usertype;
             $urol = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
             $level  = DB::SELECT('CALL FetchLevel');
             $rol   = DB::SELECT('CALL FetchRoles()');
             #get session varaible
                    $lev = session('lev');
                    $sem = session('sem');
                    $pro = session('pro');
                    $ses = session('ses');
           
               
                $session  = DB::SELECT('CALL FetchSession');
                $sec   = DB::SELECT('CALL GetProgrammeFromCourseReg');
               
                return view('courseRegDisapproval',['session'=>$session,
                                                 'sec'=>$sec,
                                                 'rol'=>$rol,
                                                 'level'=>$level,
                                                 'ses'=>$ses,
                                                 'lev'=>$lev,
                                                 'pro'=>$pro,
                                                 'sem'=>$sem]);
           
          
        }
        else
        {
             return view('logon');
        }
    }
    public function CourseApproval(Request $request)
    {
        if(Auth::check())
        {
            if($request)
            {
                $pro = $request->input('pro');
                $lev = $request->input('lev');
                $ses = $request->input('ses');
                $sem = $request->input('sem');
                $mat = $request->input('mat');
                $staffid = Auth::user()->matricno;

                #Update the approval status 
                 $ap = DB::UPDATE('CALL UpdateCourseRegApprovalStatus(?,?,?,?,?)',array($mat,$ses,$sem,$lev,$pro));
                 if($ap)
                 {
                    $com="Your Course Registration For ".$lev .' level '.$sem. ' Semester of '. $ses.' Session '. ' '.$pro. ' Has Been Successfully Approved';
                    $sta = true;
                    DB::INSERT('CALL CourseRegApprovallnfo(?,?,?,?,?,?,?,?)',array($mat,$ses,$sem,$lev,$pro,$com,$sta,$staffid));
                       
                  #Send Email
                    $ema = DB::SELECT('CALL GetStudentInfoByMatricNo(?)',array($mat));
                    $details =
                    [   'title'=>"",
                        'body'=>"Lautech Course Registration Approval",
                        'parts'=>"Congratulations, your course registration was successfully. 
                         Please click on the link below to login and print your course registration. 
                         https://lautech.unified.education/",
                        'team' =>"HOD Team"

                    ];
                  
                   Mail::to($ema[0]->email)->send(new ApprovalEMail($details));
                  return redirect()->route('courseRegApproval');
                 }
                 else
                 {
                     return redirect()->route('courseRegApproval');
                 }
            }
          else 
           {
              return redirect()->route('courseRegApproval');
           }
        }
        else
        {
            return view('logon');
        }
    }
    public function DisapproveCourseReg(Request $request)
    {

        if(Auth::check())
        {
            if($request)
            {
                $pro = $request->input('programme');
                $lev = $request->input('level');
                $ses = $request->input('session');
                $sem = $request->input('semester');
                $mat = $request->input('matricno');
                $com = $request->input('comment');
                $staffid = Auth::user()->matricno;
                $sta = false;
                //dd($pro.$lev.$ses.$sem.$mat);
                #Save disapproval information
                  $dsp= DB::INSERT('CALL CourseRegApprovallnfo(?,?,?,?,?,?,?,?)',array($mat,$ses,$sem,$lev,$pro,$com,$sta,$staffid));
                #Get Student Email
                if($dsp)
                {
                       $ema = DB::SELECT('CALL GetStudentInfoByMatricNo(?)', array($mat));
                       #Send Email

                       return redirect()->route('courseRegApproval');
                }
                else
                {
                      return back()->with('error', 'Operation Failed, Please Retry Again');
                }

            }
        }
        else
        {
            return view('logon');
        }

    }
    public function ViewStudentCourseReg(Request $request)
    {
        if(Auth::check())
        {
            if($request)
             {
                $pro = $request->input('pro');
                $lev = $request->input('lev');
                $ses = $request->input('ses');
                $sem = $request->input('sem');
                $mat = $request->input('mat');
                //dd($pro.$lev.$ses.$sem.$mat);
                $data = DB::SELECT('CALL GetStudentCourseRegistration(?,?,?,?,?)', array($mat,$ses,$sem,$lev,$pro));
                //dd($data);
                return view('viewCourseReg',['data'=>$data,  
                                        'ses'=>$ses,
                                        'lev'=>$lev,
                                        'pro'=>$pro,
                                        'sem'=>$sem,
                                        'mat'=>$mat]);
          }
          else 
          {
              return redirect()->route('courseRegApproval');
          }
        }
        else
        {
            return view('logon');
        }
       
    }
    public function CourseRegApproval(Request $request)
    {
        if(Auth::check())
        {
            if($request)
             {
                $pro = $request->input('programme');
                $lev = $request->input('level');
                $ses = $request->input('session');
                $sem = $request->input('semester');

                session(['pro' => $pro]);
                session(['sem' => $sem]);
                session(['lev' => $lev]);
                session(['ses' => $ses]);
                //dd($lev.$pro.$ses.$sem);
                $data = DB::SELECT('CALL GetCourseRegistrationForApproval(?,?,?,?)',array($pro,$lev,$sem,$ses));
                //dd($data);
                if(!$data)
                {
                   return back()->with('error', 'No Record Found, Please Retry Again');
                }
                 return redirect()->route('courseRegApproval');
                
                
            }
            else
            {
                  return back()->with('error', 'Operation Failed, Please Retry Again');
            }
        }
        else
        {
             return view('logon');
        }

    }
    public function CourseApprove()
    {
        if(Auth::check())
        {
             $staffid =Auth::user()->matricno;
             $usr = Auth::user()->usertype;
             $urol = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
             $level  = DB::SELECT('CALL FetchLevel');
             $rol   = DB::SELECT('CALL FetchRoles()');
             #get session varaible
                    $lev = session('lev');
                    $sem = session('sem');
                    $pro = session('pro');
                    $ses = session('ses');
           
               
                $session  = DB::SELECT('CALL FetchSession');
                $sec   = DB::SELECT('CALL GetProgrammeFromCourseReg');
               
                return view('courseRegApproval',['session'=>$session,
                                                 'sec'=>$sec,
                                                 'rol'=>$rol,
                                                 'level'=>$level,
                                                 'ses'=>$ses,
                                                 'lev'=>$lev,
                                                 'pro'=>$pro,
                                                 'sem'=>$sem]);
           
          
        }
        else
        {
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
