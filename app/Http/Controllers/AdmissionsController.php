<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
use PDF;
use App\ChangeProgramme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class AdmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function DisplayAdmissionStatus()
    {
        return view('displayAdmissionStatus');
    }
    public function AdmissionStatus(Request $request)
    {
        if($request)
        {
            $utme = $request->utme;
            $data = DB::table('admission_lists')->where('utme',$utme)->first();
            if($data)
            {
                 ///return view('displayAdmissionStatus',['data'=>$data]);
                 session(['utme' => $request->utme]);
                 return redirect()->route('displayAdmissionStatus');
            }
            else
            {
                return back()->with('error', 'Sorry No Admission Status Found For '.strtoupper($utme).', Please Try Again');
            }
        } 
       
    }
    public function AdmissionsCheck()
    {
        return view('admissionStatus');
    }

    
    public function RemoveProgrammes(Request $request)
    {
        $usr = Auth::user()->usertype;
        $utme = $request->utme;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $del = DB::table('change_programme')->where('utme',$utme)->delete();
            $up  = DB::table('u_g_pre_admission_regs')->where('utme',$utme)->update(['changeprograme'=>null]);
            $us  = DB::table('users')->where('utme',$utme)->update(['ischange'=>0]);

            if($del && $up && $us)
            {
                return back()->with('success', 'Programme Removed Successfully');
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
    public function RemoveProgramme()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            return view('removeChangedProgramme');
        }
        else
        {
            return view('logon');
        }
    }
    public function RejectedDocument($utme)
    {
            $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
            {
                if($utme)
                {
                    DB::table('ugregistrationprogress')->where('utme',$utme)->update(['isrejected'=>'R']);
                    return redirect()->route('documentScreening');
                }
            }
            else 
            {
                return view('logon');
            }
    }
    public function GetScore($sid)
    {
        $sc = DB::SELECT('CALL GetGrade(?)',array($sid));
        if($sc)
        {
        return $sc[0]->score;
        }
        else
        {
        return 0;
        }

    }

  public function GetScores($sed)
  {
     $g = DB::SELECT('CALL GetSubjectGrade(?,?)',array(Auth::user()->utme,$sed));
     if($g)
     {
      return $g[0]->score;
     }
     else
     {
       return 0;
     }
  }
    public function ChangeProgrammes(Request $request)
    {
        if (Auth::check())
        {
            if($request)
            {
                $prog = $request->category1;
                $utme = Auth::user()->utme;
                $ses = Auth::user()->activesession;
                $mat = Auth::user()->matricno;
                $ck =DB::table('change_programmes')->where('matricno',$mat)->first();
                if($ck)
                {
                    return back()->with('error', 'Sorry You Have Already Change Programme to '.$ck->programme);
                }
                else
                {
                    $sav = ChangeProgramme::create(
                        [
                            'programme'=>$prog,
                            'session'=>$ses,
                            'utme'=>$utme,
                            'matricno'=>$mat
                        ]
                        );
                    if($sav)
                    { 
                        DB::table('u_g_pre_admission_regs')->where('matricno', $mat)->update(['changeprogramme'=>$prog]);
                        return back()->with('success', 'Programme Changed Successfully');
                    }
                    else
                    {
                        return back()->with('error', 'Operation Failed, Please Try Again');
                    }
                }
            }
           
        }
        else
        {
            return view('logon');
        }
    }
    public function ChangeProgramme()
    {
        if (Auth::check())
        { 
            $mat = Auth::user()->matricno; $utme = Auth::user()->utme;

            $subj =DB::SELECT('CALL GetUTMESubjects(?)',array($utme));
            $scount = count($subj);
            //dd($subj);
            #Get Programme Applied For
            $pr = DB::SELECT('CALL GetCandidateProgramme(?)',array($mat));
           // dd($pr);
            $dat   = DB::SELECT('CALL GetUTMEInfoResult(?)',array($mat));
            $result = DB::SELECT('CALL GetPOSTUtmeResult(?)',array($utme));
            $uf= DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
            $total =0; $rcounter=0;
            $slist = new Collection();
            $c =0;
            if($scount > 9)
             {
                $sid = DB::SELECT('CALL GetRequireSubjectID(?,?)',array($utme,$pr[0]->programmeid));
                foreach($sid as $s)
                {
                    $sgrad = DB::SELECT('CALL GetSubjectGrade(?,?)',array($utme,$s->subjectid));
                    $total+=GetScore($sgrad[0]->grade);
                    $c++;
                }
                $rcounter = 5 - $c;
                $opt = DB::SELECT('CALL GetOptionalSubjects(?,?,?)',array($utme,$rcounter,$pr[0]->programmeid));
             }
             else
             {
                  $req = DB::SELECT('CALL GetRequiredSubjects(?,?)',array($utme,$pr[0]->programmeid));
                 $rcounter = 5 - count($req);
                 $opt = DB::SELECT('CALL GetOptionalSubjects(?,?,?)',array($utme,$rcounter,$pr[0]->programmeid));
                //dd($opt);
               
             }

            foreach($req as $data)
            {
                $total+=$this->GetScore($data->grade);
            }  
             
            foreach($opt as $da)
            {
                $total+=$this->GetScore($da->grade);
            }
               
           //dd($total);
            $score =  number_format($total/2,1)  +  number_format(((($dat[0]->totalscore)/400) * 50),1)  + $result[0]->score;
           //  $score =50;
            $ulist  = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
            if($ulist)
            {
                if($ulist[0]->totalscore >= 200)
                {
                    $pro    = DB::table('changeprogrammelist')->where('cutoff','<=',$score)->orderby('name','asc')->get();
                }
                else
                {
                    $pro    = DB::table('changeprogrammelist')
                            ->where('cutoff','<=',$score)
                            ->where('status','=','0')
                            ->orderby('name','asc')
                            ->get();
                }
            }
          /// dd($ulist[0]->totalscore);
            $dat = DB::table('changeprogrammerequirement')->get();
            $data = DB::table('u_g_pre_admission_regs')->where('matricno',$mat)->get();
            return view('changeProgramme',['data'=>$data,'ulist'=>$ulist,'pro'=>$pro,'dat'=>$dat]);
        }
        else
        {
            return view('logon');
        }
    }
    public function DocScreeningList()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            


            $ulist  = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
            return view('documentScreeningList',['ulist'=>$ulist]);
        }
        else
        {
            return view('logon');
        }
    }
    public function AdmissionProcess($utme)
    {
         $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
           // $adm = DB::UPDATE('CALL UpdateDocumentScreeningStatus(?)',array($utme));
           
            DB::table('ugregistrationprogress')->where('utme',$utme)
                                               ->where('stageid','2')
                                               ->update(['docStatus'=>'A','status'=>'1']);
            return redirect()->route('documentScreening');
        }
        else
        {
            return view('logon');
        }
    }
    public function DocumentScreenings(Request $request)
    {
        if (Auth::check())
        {
            $utme = $request->utme;
            $ck = DB::SELECT('CALL 	CheckDocumentScreeningStatus(?)',array($utme));
            if($ck && $ck[0]->status == '1')
            {
                return back()->with('error', 'Document Screening Have Been Done Already, Please Try Another Candidate For '.strtoupper($utme));
            }
            $data = DB::SELECT('CALL   GetScreeningInformation(?)',array($utme));
            $olevel = DB::SELECT('CALL GetUTMESubjects(?)',array($utme));
            $uifo = DB::SELECT('CALL   GetUTMEInformation(?)',array($utme));
            $pay = DB::SELECT('CALL FetchPaymentHistory(?)',array($data[0]->matricno));
            $sid =2; $pre="DO";
           if($data)
           {
              #Create Document Screening Profile
                        $ckg = DB::SELECT('CALL CheckDuplicateRegistrationStatge(?,?)',array($data[0]->matricno,$sid));
                         if(!$ckg)
                         {
                            $stag = DB::INSERT('CALL SaveRegistrationStages(?,?,?,?)',
                            array($data[0]->matricno,$utme,$sid,$pre));
                         }
              return view('displayDocument',['data'=>$data,'olevel'=>$olevel,'uifo'=>$uifo,'pay'=>$pay]);
           }
           else
           {
            return back()->with('error', 'Record Not Found, Please Try Again');
           }
        }
        else
        {
            return view('logon');
        }
    }
    public function DocumentScreening()
    {
        if (Auth::check())
        {
             return view('documentScreening');
        }
        else
        {
            return view('logon');
        }
    }
    public function GetUGSAdmissionLetter()
    {
        if (Auth::check())
        {
          
            $utme = Auth::user()->utme;
            $status ="Student";
            DB::UPDATE('CALL UpdateCandidateStatus(?,?)',array($utme,$status));
            //return view('admissionLetterUGD');
            ini_set('max_execution_time', 300);
         
                         PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                        // pass view fil
                          $pdf = PDF::loadView('admissionLetterUGD');
                          //return $pdf;
                         return $pdf->download(Auth::user()->name.' AdmissionLetter'.'.pdf');
           
        } else 
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
