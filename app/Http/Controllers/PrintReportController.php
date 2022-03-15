<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use QrCode;
use App\Exports\ExportJupebPayment;
use App\Exports\ExportPDSPayment;
use App\Exports\ExportPOSTUTME;
use App\Exports\ExportApplications;
use App\Exports\ExportPUTMESummary;
use App\Exports\ExportAllPostUTMEList;
use App\Exports\ExportPostUTMEByAppType;
use App\Exports\ExportPaymentReport;
use App\Exports\ExportPTList;
use App\Exports\ExportPGList;
use App\Exports\ExportPaymentJUPEBReport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use File;
use ZipArchive;
use App\PGRegistered;
use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Response;
class PrintReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function StateIdentityUGD()
    {
        if(Auth::check())
        {
            //return view('stateIdentityUGD');
            /// return view('studentDressCode');
             ini_set('max_execution_time', 300);
            
                          PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                         // pass view fil
                           $pdf = PDF::loadView('stateIdentityUGD');
                           //return $pdf;
                          return $pdf->download(Auth::user()->name.'State Identification Form'. Auth::user()->activesession .'.pdf');   
      
        }
        else
        {
            return view('logon');
        }
    }
    public function StudentOath()
    {
        if(Auth::check())
        {
            return view('studentOath');
        }
        else
        {
            return view('logon');
        }
    }
    public function StudentDressCode()
    {
        if(Auth::check())
        {
           // return view('studentDressCode');
             ini_set('max_execution_time', 300);
            
                          PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                         // pass view fil
                           $pdf = PDF::loadView('studentDressCode');
                           //return $pdf;
                          return $pdf->download(Auth::user()->name.'Student Dress Code'. Auth::user()->activesession .'.pdf');   
        }
        else
        {
            return view('logon');
        }
    }
    public function PTAdmissionLetter()
    {
        if(Auth::check() )
        {       
            
           //  return view('admissionLetterPT');     
             ini_set('max_execution_time', 300);
            
                          PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                         // pass view fil
                           $pdf = PDF::loadView('admissionLetterPT');
                           //return $pdf;
                          return $pdf->download(Auth::user()->name.' Admission Letter'. Auth::user()->activesession .'.pdf');   
        }
        else
        {
            return view('logon');
        } 
    }
    public function DownloadPostUTMES(Request $request)
    {
        if(Auth::check())
        {
            $utme= $request->utme;
            $mat = DB::table('users')->where('utme',$utme)->first();
            if($mat)
            {
            
                //return view('downloadPostUTMEResult');
                // $result = ['utme'=>$utme,'mat'=>$mat->matricno];
                 Session(['utme'=>$utme]);
                 Session(['matricno'=>$mat->matricno]);
                 Session(['name'=>$mat->name]);
                PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                
                // pass view fil
                $pdf = PDF::loadView('downloadPostUTMEResult');
                //$pdf->setPaper([0, 0, 685.98, 396.85], 'portrait');
                    //return $pdf;
                return $pdf->download(Auth::user()->name.'.pdf');
     
            }
           
        }
        else
        {
        return view('logon');
        }
    }
    public function DownloadPostUTME()
    {
        if(Auth::check() )
        {       
            
             return view('downloadPostUTME');        
        }
        else
        {
            return view('logon');
        } 
    }
    public function PGAcceptanceForm()
    {
        if(Auth::check() )
        {       
            
             return view('pgAcceptanceForm');        
        }
        else
        {
            return view('logon');
        } 
    }
    public function PGAdmissionLetter()
    {
        if(Auth::check() )
        {       
            
             return view('admissionLetterPG');        
        }
        else
        {
            return view('logon');
        } 
    }
    public function DownloadPGList(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $d = date('d-m-Y,h-m-s');
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $programme = $request->programme;
            //$p = DB::table('pgprogramme')->where('programme',$programme)->first();
           
            if($programme)
            {
              $pg =DB::table('users as us')
                      ->select('us.formnumber','us.matricno','category1',
                                DB::raw("CONCAT(us.surname, ' ' ,us.firstname,' ',us.othername) as name")
                              )
                      ->join('u_g_pre_admission_regs as rg','rg.matricno','=','us.matricno')
                      ->where('us.apptype','PG')
                      ->where('formnumber','<>',"")
                      ->where('rg.departmentid',$programme)
                      ->where('ispaid','=',"1")
                      ->get();
                DB::table('pgregistered')->delete();
                foreach($pg as $data)
                {

                    $ck  = DB::table('pgregistered')->where('formnumber',$data->formnumber)->first();
                    if(!$ck)
                    {
                        $ps = DB::table('pgprogramme')->where('programmeid',$data->category1)->first();
                        $pgreg = new PGRegistered;
                        if($ps)
                        {
                            $pgreg->name         =   $data->name;
                            $pgreg->course       =   $ps->programme;
                            $pgreg->programme    =   $ps->programme;
                            $pgreg->formnumber   =   $data->formnumber;
                            $pgreg->matricno     =   $data->matricno;
                            $pgreg->degree       =   $ps->degree;
                            $pgreg->save();
                        }
                    }
                }

              return Excel::download(new ExportPGList($programme), "PGList".$programme.$uuid.'.xlsx');
            } 
        }
        else
        {
            return view('logon');
        }
    }
    public function PGApplicantList()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
             $pro = DB::table('u_g_pre_admission_regs')->distinct()
                                                       ->select('departmentid')
                                                       ->where('admissiontype','PG')
                                                       ->orderby('departmentid','asc')
                                                       ->get();
             return view('pgApplicantList',['pro'=>$pro]);
         
        }
        else
        {
            return view('logon');
        } 
    }
    public function GenerateJUBEPPayments(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
                $pty =$request->paymenttype;
                return Excel::download(new ExportPaymentJUPEBReport($pty), $pty.'.xlsx');
        }
        else
        {
            return view('logon');
        } 
    }

    public function JupebPaymentReport()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $pty = DB::SELECT('CALL FetchPaymentList()');
            return view('jupebPaymentReport',['pty'=>$pty]);
        }
        else
        {
            return view('logon');
        } 
    }
    public function GetRefereeRecord($mat)
    {
        if(Auth::check())
         {
             $empData['data'] = DB::table('pgreference')->where('matricno',$mat)->get();
            return response()->json($empData);
         }
    }
    public function DownloadPTList($ses)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $d = date('d-m-Y,h-m-s');
            $uuid = Str::uuid()->toString() . Str::uuid()->toString();
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            return Excel::download(new ExportPTList($sess), "Part-Time".$d.$ses.$uuid.'.xlsx');
        }
        else
        {
            return view('logon');
        }
    }
    public function PTRegisteredList()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $data = DB::table('users')->distinct()->select('activesession')->get();
            return view('ptRegisteredList',['data'=>$data]);
        }
        else
        {
            return view('logon');
        }
    }
    public function BiodataBatchingClearance()
    {
          // $isadm = Auth::user()->isadmitted;
            if(Auth::check())
            {
            ini_set('max_execution_time', 300);
            $matricno= Auth::user()->matricno;
            $utme= Auth::user()->utme;
            //dd($id);
            $data = DB::SELECT('CALL GetBiodataBatchingClearance(?)',array($utme));
           // return view('getBiodataBatching',['data'=>$data]);
             
            $result = ['data'=>$data];
                            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                            // pass view fil
                            $pdf = PDF::loadView('getBiodataBatching',$result);
                            //return $pdf;
                            return $pdf->download(Auth::user()->name.'.pdf');
            //return view('printProfile',['data'=>$data]);
            }
            else
            {
            return view('logon');
            }
    }
    public function GetAdmissionInformation($utme="")
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
           $empData['data'] = DB::SELECT('CALL GetAdmissionInfoForBiodata(?)', array($utme));
           return response()->json($empData);
        }
        else
        {
            return view('logon');
        }
    }
    public function downloadFile($file_name)
    {
        $file = Storage::disk('public/Passports/')->get($file_name);
      //  dd($file);
        return (new Response($file, 200))->header('Content-Type', 'image/jpeg');
    }
    public function DownPassports(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $app =  $request->application;
            $data = DB::SELECT('CALL GetStudentPassportByAppType(?)',array($app));
          

           // dd($data);
           foreach($data as $item)
            {
               // $file = $item->photo;
               // $file_path = $request->file($file);
               // $name =$item->formnumber.' '. $item->name;
               // $img = $name.'.'.$file_path;
               // $destinationPath = public_path('/JUP');
                //$file_path->move($destinationPath, $img);
                



                 $file = public_path(). "/Passports/$item->photo";
                 $headers = ['Content-Type: image'];
                if (file_exists($file))
                 {
                    return (new Response($file, 200))->header('Content-Type', 'image');
                    //return \Response::download($file, $item->formnumber.' '. $item->name.".jpg", $headers);
                }
                 
            }
           
        }
        else
        {
         return view('logon');
        }
    }
    public function DownPassport()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            return view('downloadPassport');
        }
        else
        {
            return view('logon');
        }
    }
    public function GetPDSPayment()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
             $data = DB::SELECT('CALL DownloadPDSPayment()');
             return view('downloadPDSPayment',['data'=>$data]);   
         }
         else
         {
             return view('logon');
         }
    }
    public function DownloadPDSPayment($ses,$pat)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
             $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
             return Excel::download(new ExportPDSPayment($sess,$pat), $pat.$ses.'.xlsx');
        }
        else
        {
            return view('logon');
        }
    }
    public function GeneratePayments(Request $request)
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
                $pty =$request->paymenttype;
                return Excel::download(new ExportPaymentReport($pty), $pty.'.xlsx');
        }
        else
        {
            return view('logon');
        } 
    }
    public function PaymentReport()
    {
        $usr = Auth::user()->usertype;
        if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
            $pty = DB::SELECT('CALL FetchPaymentList()');
            return view('paymentReport',['pty'=>$pty]);
        }
        else
        {
            return view('logon');
        } 
    }
    public function PDSResultSlip()
    {
    // $isadm = Auth::user()->isadmitted;
        if(Auth::check())
        {
        ini_set('max_execution_time', 300);
        $matricno= Auth::user()->matricno;
        return view('pdsResultSlip');
        

                        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                        // pass view fil
                        $pdf = PDF::loadView('pdsResultSlip');
                        //return $pdf;
                        return $pdf->download(Auth::user()->name.$data[0]->apptype.'.pdf');
        //return view('printProfile',['data'=>$data]);
        }
        else
        {
            return view('logon');
        }

    }
    public function GetPDSAdmissionLetter()
     {
            if(Auth::check())
            {
            ini_set('max_execution_time', 300);
            //$matricno= Auth::user()->matricno;
            //$data = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)',array($matricno));
            //return view('admissionLetter');
            // $result = ['data'=>$data];
                            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                        // pass view fil
                            $pdf = PDF::loadView('admissionPDSLetter');
                            //return $pdf;
                            return $pdf->download(Auth::user()->name.'.pdf');
            //return view('printProfile',['data'=>$data]);
            }
            else
            {
            return view('logon');
            }
     }

    public function DownloadJupebPayment($ses,$pat)
    {
        $usr = Auth::user()->usertype;
       if(Auth::check() && $usr=='Staff' || $usr=='Admin')
        {
             $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
             return Excel::download(new ExportJupebPayment($sess,$pat), $pat.$ses.'.xlsx');
        }
        else
        {
            return view('logon');
        }
    }
   public function GetJupebPayment()
   {
        if(Auth::check())
        {
           // $data = DB::SELECT('CALL DownloadJupebPayment()');
            $pty = DB::SELECT('CALL GetUGDPaymentType()');
            return view('downloadJupebPayment',['data'=>$data]);   
        }
        else
        {
            return view('logon');
        }
   }
    public function ExportPostUTMESummary($ses)
    {
        
         if(Auth::check())
         {
            $uuid = Str::uuid()->toString();
              $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
              return Excel::download(new ExportPUTMESummary($sess), $uuid.'.xlsx');
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

  public function GetByProgramme($utm)
  {
    $p = DB::SELECT('CALL GetByProgrammeByUTME(?)',array($utm));
    if($p)
    {
      return $p[0]->programme;
    }
    else
    {
      return 0;
    }

  }

  public function PostUtmeSummary()
  {
      if(Auth::check())
      {
       // $data = DB::SELECT('CALL FetchPostUTMESummary()');
       // return view('postUtmeSummary',['data'=>$data]);
          
         $dat ="";
         $rcounter=0; $total =0; $sum=0; $c=0; $tot=0;

         $res_count = count(DB::SELECT('CALL FetchPostUTMEResults()'));
         $sum_count = DB::SELECT('CALL FetchPostUTMESummaryCount()');
         
              $ses ="2021/2022";
              $result = DB::SELECT('CALL GetPostResultsBySession(?)', array($ses));
             //dd($result);
              foreach($result as $item)
              {
                   //check if admitted already
                   $ckadm = DB::SELECT('CALL GetAdmissionInfo(?)',array($item->utme)); 
                    if($ckadm)
                    {
            
                    }
                    else
                    {
                        ini_set('max_execution_time', 300);
                            $state ="";
                            //dd($item);
                            $mat = DB::SELECT('CALL GetMatricNoFromUsers(?)',array($item->utme));
                            //dd($item);
                            #Get Programme Applied For
                            if($mat)
                            {
                                $state =$mat[0]->state;
                                $pr = DB::SELECT('CALL GetCandidateProgramme(?)',array($mat[0]->matricno));
                            // dd($pr);
                                $dat   = DB::SELECT('CALL GetUTMEInfoResult(?)',array($mat[0]->matricno));
                                //dd($dat);
                            }
                        
                            $result = DB::SELECT('CALL GetPOSTUtmeResult(?)',array($item->utme));
                            //dd($result);
                        
                        
                            $uf= DB::SELECT('CALL GetUTMEInformation(?)',array($item->utme));
                            // dd($item->utme);
                            #Compute Olevel Score
                            if($dat &&  $pr) 
                            {
                                $subj =DB::SELECT('CALL GetUTMESubjects(?)',array($item->utme));
                                $scount = count($subj);
                                
                                if($scount > 9)  
                                {   
                                    $sid = DB::SELECT('CALL GetRequireSubjectID(?,?)',array($item->utme,$pr[0]->programmeid));
                                    //dd($sid);
                                    foreach($sid as $s)
                                        {
                                        $sgrad = DB::SELECT('CALL GetSubjectGrade(?,?)',array($item->utme,$s->subjectid));
                                        $total+=$this->GetScore($sgrad[0]->grade);
                                        $tot+=$this->GetScore($sgrad[0]->grade);
                                        $c++;
                                        }
                                        //dd($tot);
                                        $rcounter = 5 - $c;
                                        $opt = DB::SELECT('CALL GetOptionalSubjects(?,?,?)',array($item->utme,$rcounter,$pr[0]->programmeid));           
                                        //$opt = DB::SELECT('CALL GetOptionalSubjects(?,?,?)',array($item->utme,$rcounter,$pr[0]->programmeid));
                                        foreach($opt as $da)
                                        {
                                            $total+=$this->GetScore($da->grade);
                                            $tot+=$this->GetScore($sgrad[0]->grade);
                                        }

                                        DB::INSERT('CALL SaveUTMESubjectScore(?,?)',array($item->utme,$tot));
                                        $tot = number_format($tot/2,1);
                                        // dd($tot);
                                        #UTME Score Computation
                                        //dd($tot);
                                        $uts = number_format(((($item->totalscore)/400) * 50),1);
                                        $ck = DB::SELECT('CALL CheckDuplicatePostUtmeSummary(?)',array($item->utme));
                                        $sum = number_format($uts +  $tot + $item->score,1);
                                        $p =$this->GetByProgramme($item->utme);
                                        if($ck)
                                        {
                                            DB::UPDATE('CALL UpdatePostUTMESummary(?,?,?,?,?,?,?)',array($item->utme,$item->score,$tot,$item->session,$sum,$p,$state));
                                            $rcounter=0; $total =0; $sum=0; $c=0;
                                        }
                                        else
                                        {
                                            //dd($tot.' =$item->utme '.$item->utme);
                                                $sav = DB::INSERT('CALL SavePostTUTMESummary(?,?,?,?,?,?,?,?,?)',
                                                array($item->utme,$item->score, $tot,$uts, $item->session,$sum,$item->name,$p,$state));
                                                $rcounter=0; $tot =0; $sum=0; $c=0;
                                        } 
                                        
                                }
                                else
                                {
                                #=========================================================
                                    $req = DB::SELECT('CALL GetRequiredSubjects(?,?)',array($item->utme,$pr[0]->programmeid));
                                    foreach($req as $data)
                                    {
                                        $total+=$this->GetScore($data->grade);
                                        $tot+=$this->GetScore($data->grade);
                                    }
                                        $rcounter = 5 - count($req);
                                        $opt = DB::SELECT('CALL GetOptionalSubjects(?,?,?)',array($item->utme,$rcounter,$pr[0]->programmeid));
                                        foreach($opt as $da)
                                        {
                                            $total+=$this->GetScore($da->grade);
                                            // $tot+=$this->GetScore($data->grade);
                                        }
                                    }
                                    DB::INSERT('CALL SaveUTMESubjectScore(?,?)',array($item->utme,$tot));
                                    $tot=0;
                                
                                    $total = number_format($total/2,1);
                                    #UTME Score Computation
                                    $uts = number_format(((($item->totalscore)/400) * 50),1);
                                    $ck = DB::SELECT('CALL CheckDuplicatePostUtmeSummary(?)',array($item->utme));
                                    $sum = number_format($uts +  $total + $item->score,1);
                                    $p =$this->GetByProgramme($item->utme);
                                    if($ck)
                                    {
                                        DB::UPDATE('CALL UpdatePostUTMESummary(?,?,?,?,?,?,?)',array($item->utme,$item->score,$total,$item->session,$sum,$p,$state));
                                        $rcounter=0; $total =0; $sum=0;
                                    }
                                    else
                                    {
                                        
                                            $sav = DB::INSERT('CALL SavePostTUTMESummary(?,?,?,?,?,?,?,?,?)',
                                            array($item->utme,$item->score, $total,$uts, $item->session,$sum,$item->name,$p,$state));
                                            $rcounter=0; $total =0; $sum=0;
                                    } 
                                }        
                             }//end foreach
                        }//check end if admitted
         
           $data = DB::SELECT('CALL FetchPostUTMESummary()');
           return view('postUtmeSummary',['data'=>$data]);


         
 }
 else
  {
    return view('logon');
  }
}
    public function CheckPostUTMEResult()
    {
        if(Auth::check())
        {
              $res =false;
              $utme = Auth::user()->utme;
              $data = DB::SELECT('CALL CheckCandidateResult(?)',array($utme));
              if($data)
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
            return view('logon');
        }
    }
      public function EditProfile($mat)
      {
            if(Auth::check())
            {
                $data = DB::SELECT('CALL GetPGProfileForEdit(?)',array($mat));
                return view('editData',['data'=>$data]);
            }
            else
            {
                return view('logon');
            } 
      }
      public function PGProfileList()
      {
        if(Auth::check())
        {
            $data = DB::SELECT('CALL EditPGProfile()');
            return view('pgProfileList',['data'=>$data]);
        }
        else
        {
            return view('logon');
        } 
      }
       public function PrintPGData()
       {
            if(Auth::check())
            {
                 $matricno = Auth::user()->matricno;
                 $name = Auth::user()->name;
                  $data = DB::SELECT('CALL GetPGInformation(?)', array($matricno));
                   $result = ['data'=>$data];
                      PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                    // pass view fil
                      $pdf = PDF::loadView('printPGData',$result);
                      //return $pdf;
                     return $pdf->download($name.'.pdf');
                return view('printPGData',['data'=>$data]);
            }
            else
            {
                return view('logon');
            }
       }
       public function ReceiptSlip($id)
       {
             // $isadm = Auth::user()->isadmitted;
               if(Auth::check())
               {
               ini_set('max_execution_time', 300);
               $matricno= Auth::user()->matricno;
               //dd($id);
               $data = DB::SELECT('CALL GetPaymentReceipt(?)',array($id));
               return view('getReceipt',['data'=>$data]);
                
               $result = ['data'=>$data];
                               PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                               // pass view fil
                               $pdf = PDF::loadView('getReceipt',$result);
                               //return $pdf;
                               return $pdf->download(Auth::user()->name.'.pdf');
               //return view('printProfile',['data'=>$data]);
               }
               else
               {
               return view('logon');
               }
       }
    public function GetUTMEResult()
    {
        if(Auth::check())
         {
                //$sum =0;$utmes =0;
               // $matricno ="PDS20219123222";
               // $utme= "10801411HC";  //Auth::user()->matricno;
                //$utme =  Auth::user()->utme; //"10801411HC" ;
                
                // dd($data);
                return view('postUTMEResult');
                //$result = ['data'=>$data,'olevel'=>$olevel];
              
                PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                $pdf->setPaper([0, 0, 685.98, 396.85], 'portrait');
                // pass view fil
                    $pdf = PDF::loadView('postUTMEResult');
                    //return $pdf;
                return $pdf->download(Auth::user()->name.'.pdf');
     
            }
            else
            {
            return view('logon');
            }
      }
    public function GetPostUTMEAllList()
    {
        if(Auth::check())
        {
            
            //dd($sess);
            $uuid = Str::uuid()->toString();
            return Excel::download(new ExportAllPostUTMEList, $uuid.'.xlsx');
        }
        else
        {
            return view('logon');
        }
    }
    public function GetPostUTMEListByAppType($ses,$apptype)
    {
        
        if(Auth::check())
        {
             $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            //dd($sess);
            return Excel::download(new ExportPostUTMEByAppType($sess,$apptype), $ses.$apptype.'.xlsx');
        }
        else
        {
            return view('logon');
        }
    }
    public function GetPostUTMEList()
    {
        
        if(Auth::check())
        {
            $data = DB::SELECT('CALL FetchPostUTMEListByApptype()');
            return view('getPostUTMEList',['data'=>$data]);
        }
        else
        {
            return view('logon');
        }
    }
    public function ExportApplication($ses,$appt)
    {
        
         if(Auth::check())
         {
              $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
             //dd($sess);
             return Excel::download(new ExportApplications($sess,$appt), $ses.$appt.'.xlsx');
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
             $data   =   DB::SELECT('CALL FetchAllCandidateInformationPDS()');
             return view('getCandidateData',['data'=>$data]);
         }
         else
         {
             return view('logon');
         }
    }
    public function GetLGA($sta="")
    {
         if(Auth::check())
         {
         // Fetch Employees by programme
             $empData['data'] = DB::SELECT('CALL GetLGAByStateID(?)', array($sta));
             return response()->json($empData);
          }
    }   
    public function AddLGAs(Request $request)
    {
        if(Auth::check())
         {
             $matricno = Auth::user()->matricno;
              $lg = $request->lga;
            
              $l = DB:: UPDATE('CALL UpdateStudentLGA(?,?)',array($matricno,$lg));
          
                if($l== 1)
                {
                   
                    return redirect()->route('home');
                }
                else
                {
                    return back()->with('error', 'Operation Failed, Try Again');
                }
         }
         else
         {
             return view('index');
         }
    }
    public function AddLGA()
    {
         if(Auth::check())
         {
              $st = DB::SELECT('CALL FetchStateList');
              return view('addLGA',['st'=>$st]);
         }
         else
         {
             return view('index');
         }
    }
public function GetStateIdentity()
{
    $isadm = Auth::user()->isadmitted;
    if(Auth::check() && $isadm == true)
    {
       ini_set('max_execution_time', 300);
       $matricno= Auth::user()->matricno;
       
       $data = DB::SELECT('CALL GetStudentStateIdentity(?)',array($matricno));
    // dd($data);
     // return view('stateIdentity',['result'=>$data]);
       $result = ['data'=>$data];
                    PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                   // pass view fil
                     $pdf = PDF::loadView('stateIdentity',$result);
                     //return $pdf;
                    return $pdf->download(Auth::user()->name.'.pdf');
       //return view('printProfile',['data'=>$data]);
    }
    else
    {
       return view('logon');
    }
}
    public function ExportPOSTApplications()
    {
        $uuid = Str::uuid()->toString();
         if(Auth::check())
         {
          
             //dd($sess);
             return Excel::download(new ExportPOSTUTME, $uuid.'.xlsx');
         }
         else
         {
             return view('logon');
         }
    }
    public function GetScreenHall()
{
    if(Auth::check())
    {
       $batched = false;
       $matricno = Auth::user()->matricno;
     //  $utme = Auth::user()->utme;
       #Fetch batching information
       $bat = DB::SELECT('CALL FetchExamHall()');
       //dd($bat);
       $lastcount = 0;
       //dd($bat);
       if($bat)
        {
           //dd($bat[0]->session);
           #The last occuppant number by hall
           $ocu = DB::SELECT('CALL GetScreeningClearnanceByHall(?,?,?,?)',array($bat[0]->hallid, 
                                                                              $bat[0]->session,
                                                                              $bat[0]->batch,
                                                                              $bat[0]->edate));
            //dd($ocu);
            if($ocu)
            {
              $lastcount = $ocu[0]->counter + 1;
            }
            else
            {
               $lastcount += 1;
            }
          
           #Get the parameter from Batching
           $rechall =  $bat[0]->hallid;
           $recbat  =  $bat[0]->batch;
           $recses  =  $bat[0]->session;
           $edate   =  $bat[0]->edate;
          
          
           if($lastcount <= $bat[0]->capacity)
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

              if($ck[0]->checker == 0)
              {
                 $sav = DB::INSERT('CALL SaveScreenClearance(?,?,?,?,?,?,?)',  array($matricno,
                                                                                $bat[0]->edate,
                                                                                $bat[0]->hallid,
                                                                                $bat[0]->batch,
                                                                                $bat[0]->etime,
                                                                                $lastcount,
                                                                                $bat[0]->session));
                 // return $batched =true;
                  
              }
               return $batched =true;
          }
          elseif($lastcount > $bat[0]->capacity)
          {
           // dd($lastcount);
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
    public function UTMEPrintScreening()
    {
        $ocp=0;
        if(Auth::check())
        {
           $matricno = Auth::user()->matricno;
           $name = Auth::user()->name;
           $ses =Auth::user()->activesession;
           $apptype = Auth::user()->apptype;
           ini_set('max_execution_time', 300);
           #Update Registration Completion Status
           DB::UPDATE('CALL UpdateCompleteStatus(?)',array($matricno));         
           #call batching  
         
           if($apptype=="UGD")
           {
                $datas = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
               // dd($matricno);
                $prog = DB::SELECT('CALL GetUTMEProgrammeByName(?)',array($datas[0]->category1));
                if($prog)
                {
                    DB::UPDATE('CALL UpdateUTMEProgrammeID(?,?)',array($matricno,$prog[0]->programmeid));
                }
 
                $batched = $this->GetScreenHall();
            
               if($batched == true)
               {
                     ini_set('max_execution_time', 300);
                   
                     $data = DB::SELECT('CALL GetScreeningClearnanceByUTME(?)', array($matricno));
                    // dd($data);
                    // dd($data);
                    // return view('UTMEscreeningconfirmation',['data'=>$data]);   
    
                      $result = ['data'=>$data];
                      PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                    // pass view fil
                      $pdf = PDF::loadView('UTMEscreeningconfirmation',$result);
                      //return $pdf;
                       return $pdf->download($name.'.pdf');
                     
               }
               elseif($batched == false)
               {    
                  // dd($batched);
                 #Get the parameter from Batching
                 $data = DB::SELECT('CALL GetScreeningClearnanceByUTME(?)', array($matricno));
                 $bat = DB::SELECT('CALL FetchExamHall()');
                 $rechall =  $bat[0]->hallid;
                 $recbat  =  $bat[0]->batch;
                 $recses  =  $bat[0]->session;
                 $edate   =  $bat[0]->edate;             
                  #update current hall status to occupied and select next available hall for the day
                  $uhal = DB::UPDATE('CALL UpdateBatchingHallStatusFull(?,?,?,?)',array($rechall,$recses,$recbat,$edate));
                  //dd($uhal);
                  if($uhal)
                  {
                    $ba = $this->GetScreenHall();
                    ini_set('max_execution_time', 300);
                  
                    $data = DB::SELECT('CALL GetScreeningClearnanceByUTME(?)', array($matricno));
                   // return view('UTMEscreeningconfirmation',['data'=>$data]);   
   
                    $result = ['data'=>$data];
                     PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                   // pass view fil
                     $pdf = PDF::loadView('UTMEscreeningconfirmation',$result);
                     //return $pdf;
                      return $pdf->download($name.'.pdf');
                    
                  }
               }
               else
               {
                  $msg ="Hall Filled-up";
               }
           }
           else
           {
               #
               $matricno = Auth::user()->matricno;
               $name = Auth::user()->name;
               $ses =Auth::user()->activesession;
               ini_set('max_execution_time', 300);
               DB::UPDATE('CALL UpdateCompleteStatus(?)',array($matricno));
                         $data = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
                         $result = ['data'=>$data];
                          PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                        // pass view fil
                          $pdf = PDF::loadView('UTMEscreeningconfirmation',$result);
                          //return $pdf;
                         return $pdf->download($name.'.pdf');   


           }
    
              // $res = DB::SELECT('CALL GetScreeningClearnanceByUTME()', array($matricno));
        }
        else
        {
             return view('logon');
        }
    }
public function GetAdmissionLetter()
{
    if(Auth::check())
    {
       ini_set('max_execution_time', 300);
       //$matricno= Auth::user()->matricno;
       //$data = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)',array($matricno));
       //return view('admissionLetter');
      // $result = ['data'=>$data];
                    PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                   // pass view fil
                     $pdf = PDF::loadView('admissionLetter');
                     //return $pdf;
                    return $pdf->download(Auth::user()->name.'.pdf');
       //return view('printProfile',['data'=>$data]);
    }
    else
    {
       return view('logon');
    }
}
public function PrintProfile()
{
     if(Auth::check())
     {
        ini_set('max_execution_time', 300);
        $matricno= Auth::user()->matricno;
        $data = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)',array($matricno));
        $result = ['data'=>$data];
                     PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                    // pass view fil
                      $pdf = PDF::loadView('printProfile',$result);
                      //return $pdf;
                     return $pdf->download(Auth::user()->name.'.pdf');
        //return view('printProfile',['data'=>$data]);
     }
     else
     {
        return view('logon');
     }
}

public function PaymentHistory()
{
     if(Auth::check())
     {
         $matricno = Auth::user()->matricno;
         $matricno ="756";
         $data = DB::SELECT('CALL GetStudentPaymentHistory(?)', array($matricno));
         return view('stdpaymentHistory',['data'=>$data]);
     }
     else
     {
        return view('logon');
     }
}
public function PrintScreening()
{
   // return 
       if(Auth::check())
        {
           $matricno = Auth::user()->matricno;
           $name = Auth::user()->name;
           $appno = Auth::user()->appnumber;
           $apptype = Auth::user()->apptype;
           $ses =Auth::user()->activesession;
           ini_set('max_execution_time', 300);
           $dat = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
           DB::UPDATE('CALL UpdateCompleteStatus(?)',array($matricno));
            if($apptype=="PG")
            {
                    $ap = DB::SELECT('CALL GetPGProgramme(?)', array($dat[0]->category1));
                    if(!$appno || empty($appno) || $appno == null)
                    {
                        DB::UPDATE('CALL GetPGApplicationNumber(?,?)',array($matricno,$ap[0]->degree));
                    }
            }
                     $data = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
                     //dd($data);
                     $result = ['data'=>$data];
                      PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                    // pass view fil
                      $pdf = PDF::loadView('screeningconfirmation',$result);
                      //return $pdf;
                     return $pdf->download($name.'.pdf');
        }
        else
        {
            return view('logon');
        }
}
public function generatePDF()
{
    if(Auth::check())
    {
        //Set variables
        $sess =  session('ses'); //Auth::user()->activesession;// $request->input('session');
        $mat = Auth::user()->matricno;
        $stdname = Auth::user()->name;
        $levs = session('levs');
        $sems = session('sems');
        $pro = session('pro');

        $dat = DB::SELECT('CALL UGFetchSubmittedCourseReg(?,?,?,?,?)',array($mat,$sess, $sems,$levs,$deps));

        $result = ['data'=>$dat, 'lev'=>$levs, 'ses'=>$sess, 'sem'=>$sems,'pro'=>$pro];

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // pass view file
       

        $pdf = PDF::loadView('ugprintPreview',$result);
        // download pdf
        $fname = $stdname.$levs;
        return $pdf->download($fname.'.pdf');
    }
}

public function sendmail(Request $request){
        $data["email"]=$request->get("email");
        $data["client_name"]=$request->get("client_name");
        $data["subject"]=$request->get("subject");

        $pdf = PDF::loadView('mails.mail', $data);

        try{
            Mail::send('mails.mail', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "invoice.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
 }

 function GetSession($ses)
 {
      $ses = DB::table('session')->where('id', $ses)->get()->first();
      return $ses->name;
 }
 function GetSemester($sm)
 {
     $sem ="";
     if($sm == "1")
     {
        $sem ="First Semester";
     }
     else
     {
        $sem ="Second Semester";
     }

     return $sem;
 }
    public function PrintForm(Request $request)
    {
        ini_set('max_execution_time', 300);
        if(Auth::check())
        {
            $deps = $request->input('programme');
            $levs = $request->input('level');
            $sess = $request->input('session');
            $sems = $request->input('semester');
            $mat  = Auth::user()->matricno;
            $stdname = Auth::user()->name;
             
             //Check for the course registration



            ///Email Parameters
            $data["email"] = Auth::user()->email;
            $data["client_name"]=Auth::user()->name;
            $data["subject"]="Course Registration " .$levs ." level  ". $sems . " " . $sess;
            //Session Variables
            session(['deps' => $deps]);
            session(['sems' => $sems]);
            session(['levs' => $levs]);

            $reg = DB::SELECT('CALL FetchApprovedCourseRegistration(?,?,?,?,?)', array($mat,$sess, $sems,$levs,$deps));

            if(!$reg)
            {
             return back()->with('error', 'Course Registration Has Not Been Approved, Try Again Later');
            }

            $data = DB::SELECT('CALL UGFetchSubmittedCourseReg(?,?,?,?,?)',array($mat,$sess, $sems,$levs,$deps));
            if(!$data)
             {
                return back()->with('error', 'Not Course Registration Found, Try Again');
             }
            //dd($mat);
             $qcr =Auth::user()->name.'-'.$mat.'-'.$sess.' Sesssion-'.$sems.' Semester-'.$levs.' level-'.$deps. ' Department';
             $qcoder = QrCode::size(150) 
                                   ->backgroundColor(255,255,204)
                                   ->generate($qcr);
            return view('ugprintPreview',['data'=>$data, 'lev'=>$levs, 'ses'=>$sess, 'sem'=>$sems,'pro'=>$deps,'qcoder'=>$qcoder]);

            $result = ['data'=>$data, 'lev'=>$levs, 'ses'=>$sess, 'sem'=>$sems,'pro'=>$deps];

            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // pass view fil
           //  $pdf = App::make('dompdf.wrapper');
            // $pdf->loadHTML('<h1>Test</h1>');
            //return $pdf->stream();

           //return PDF::loadFile(public_path().'/myfile.html')->save('/path-to/my_stored_file.pdf')
                                                       // ->stream('download.pdf');

            $pdf = PDF::loadView('ugprintPreview',$result);
           // $pdf->setWatermarkImage(public_path('img/logo_course.jpg'));
            $fname = $stdname.$levs.$sems.$sess;
           return $pdf->download($fname.'.pdf');

           //Send Email
           $data["email"] = Auth::user()->email;
           $data["client_name"]=Auth::user()->name;
           $data["subject"]="Course Registration " .$levs ."  ". $sems ." Semester, " . $sess;
           $data["fileName"] = $stdname.$levs;
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

            return $pdf->download($fname.'.pdf');
        }
        else
        {
            return view('logon');
        }
    }
    public function CourseReg(Request $request)
    {
        ini_set('max_execution_time', 300);
        if(Auth::check())
        {

            $deps = $request->input('programme');
            $levs = $request->input('level');
            $sess = $request->input('session');
            $sems = $request->input('semester');
            $mat  = Auth::user()->matricno;
            $stdname = Auth::user()->name;
            $dat = DB::SELECT('CALL UGFetchSubmittedCourseReg(?,?,?,?,?)',array($mat,$sess, $sems,$levs,$deps));
            // dd($deps.$levs.$sess.$sems);      
             $qcr =Auth::user()->name.'-'.$mat.'-'.$sess.' Sesssion-'.$sems.' Semester-'.$levs.' level-'.$deps. ' Department';
             $qcoder = QrCode::size(150) 
                                   ->backgroundColor(255,255,204)
                                   ->generate($qcr);

            $result = ['data'=>$dat, 'lev'=>$levs, 'ses'=>$sess, 'sem'=>$sems,'pro'=>$deps,'qcoder'=>$qcoder];
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            $pdf = PDF::loadView('ugprintPreview',$result);
            $fname = $stdname.$levs.$sems.$sess;
           return $pdf->download($fname.'.pdf');

           //Send Email
     
        }
        else
        {
            return view('logon');
        }
    }

    public function PrintFormReg()
    {
        if(Auth::check())
        {
           $matricno = Auth::user()->matricno;
           //dd($matricno);
           $ses = DB::SELECT('CALL FetchSession()');
           $dep = DB::SELECT('CALL FetchProgramme()');
           $data =DB::SELECT('CALL GetDistinctCourseRegistration(?)', array($matricno));
           return view('ugprintCourse',['data'=>$data, 'pro' =>$dep, 'ses'=>$ses]);
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
