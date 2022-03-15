<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ReferenceResponseEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Auth;
class ReferenceEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RegConfirmation()
    {
        if(Auth::check())
        {
           return view('registrationConfrimationPage');
        }
        else
        {
           return view('logon');
        }
    }
    public function ReferenceResponse()
    {
        return view('pgreferenceResponse');
    }
    public function PGReferences(Request $request)
    {
        if($request)
        {
            $title = $request->input('title');
            $email = $request->input('email');
            $myemail = $request->input('myemail');
            $name = $request->input('name');
            $rank = $request->input('rank');
            $remark = $request->input('remark');
            $matricno = $request->input('matricno');
            $guid = $request->input('guid');

            $sav = DB::INSERT('CALL SaveReferenceInfo(?,?,?,?,?,?)',array($title,$name,$email,$rank,$remark,$matricno));
            if($sav)
            {
               // dd($guid);
                DB::UPDATE('CALL UpdateSendEmailStatus(?)',array($guid));
                #Send Email To Candidate
                $details =
                [   
                    'title'=>"",
                    'body'=>"Lautech Post Gradurate Application Reference",
                    'header'=>"Dear Sir/Ma,", 
                    'parts'=>$title. ' '.strtoupper($name). " has successfully confirmed your reference.",
                    'team' =>"Lautech Post Graduate Admission Team."

                ];
                Mail::to($myemail)->send(new ReferenceResponseEmail($details));
                return view('pgreferenceResponse');
            }
            else
            {
                return back()->with('error', 'Operation Failed, Please Try Again');
            }
        }
    }
    public function PGReference($id)
    {
       $ck  = DB::SELECT('CALL 	ConfirmReferenceLink(?)',array($id));
       if($ck)
       {   
            $tit =DB::SELECT('CALL FetchTitles()');
            return view('pgreferencePage',['res'=>$ck, 'tit'=>$tit,'guid'=>$id ]);
       }
       else
       {
        return redirect()->route('logon');
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
