<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
use App\Imports\PDSResult; 
use App\Imports\ImpPDSResult; 
use App\Imports\ImpUTMEInfo;
use App\Imports\PostUTMEResult; 
use App\Imports\ImpUTMESubject;
use App\Exports\UsersExport;
use App\Imports\ImpAdmissionList;
use App\Imports\ImpPGAdmissionList;
use App\Imports\ImpPTAdmissionList;
use App\Imports\ImpBiodataUpdates;
use Maatwebsite\Excel\Facades\Excel;
use Config;
use Maatwebsite\Excel\Concerns\FromCollection;
class UploaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function UploadPTAdmissions(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      {
            $sta = Auth::user()->matricno;
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 1200);
            $ses = $request->input('session');
            $todayDate = Carbon::now()->format('dmY');
           
            $data = Excel::import(new ImpPTAdmissionList($ses), $request->file('resultfile')->store('temp'));
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/PTAdmissions');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="PT Admission ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
      }
      else
      {
          return view('logon');
      }
    }
    public function UploadPTAdmission()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      { 
        
        $data =DB::table('ptadmissionlist')->where('session',Auth::user()->activesession)->orderby('created_at','desc')->get(); // DB::SELECT('CALL GetUGDAdmissionList(?)',array(Auth::user()->activesession));
        $ses = DB::SELECT('CALL FetchSession');
      // dd($data);
        return view('uploadPTAdmission',['data' =>$data,'lst'=>$ses]);
      }
      else
      {
       return view('logon');
      }
    }
    public function UploadPGAdmissions(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      {
            $sta = Auth::user()->matricno;
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 1200);
            $ses = $request->input('session');
            $todayDate = Carbon::now()->format('dmY');
           
            $data = Excel::import(new ImpPGAdmissionList($ses), $request->file('resultfile')->store('temp'));
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/PGAdmissions');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="PG Admission ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
      }
      else
      {
          return view('logon');
      }
    }
    public function UploadPGAdmission()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      { 
        
        $data =DB::table('pgadmissionlist')->where('session',Auth::user()->activesession)->orderby('created_at','desc')->get(); // DB::SELECT('CALL GetUGDAdmissionList(?)',array(Auth::user()->activesession));
        $ses = DB::SELECT('CALL FetchSession');
      // dd($data);
        return view('uploadPGAdmission',['data' =>$data,'lst'=>$ses]);
      }
      else
      {
       return view('logon');
      }
    }
    public function UploadBiodataUpdates(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      {
            $sta = Auth::user()->matricno;
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 1200);
            $ses = $request->input('session');
            $todayDate = Carbon::now()->format('dmY');
           
            $data = Excel::import(new ImpBiodataUpdates($ses), $request->file('resultfile')->store('temp'));
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/BiodataUpdates');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="Biodata Update ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
      }
      else
      {
          return view('logon');
      }
    }
    public function UploadBiodataUpdate()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      { 
        
        $data =DB::table('ugregistrationprogress')->orwhere('stageid',7)->orwhere('stageid',8)->orderby('created_at','desc')->get();
        $lst = DB::SELECT('CALL FetchSession');
      // dd($data);
        return view('uploadBiodataUpdates',['data' =>$data,'lst'=>$lst]);
      }
      else
      {
       return view('logon');
      }
    }
    public function UploadAdmissions(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      {
            $sta = Auth::user()->matricno;
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 1200);
            $ses = $request->input('session');
            $ops = $request->operation;
            $todayDate = Carbon::now()->format('dmY');
           
            $data = Excel::import(new ImpAdmissionList($ses,$ops), $request->file('resultfile')->store('temp'));
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/UGDAdmissions');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="UGD Admission ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
     }
     else
     {
        return view('logon');
     }
    }
    public function UploadAdmission()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      { 
        
        $data =DB::table('admission_lists')->where('session',Auth::user()->activesession)->orderby('created_at','desc')->get(); // DB::SELECT('CALL GetUGDAdmissionList(?)',array(Auth::user()->activesession));
        $ses = DB::SELECT('CALL FetchSession');
      // dd($data);
        return view('uploadAdmission',['data' =>$data,'lst'=>$ses]);
      }
      else
      {
       return view('logon');
      }
    }
    public function UploadDoc()
    {
      if(Auth::check())
      { 
         $guid = Auth::user()->guid;
         
         $URL = config('paymentUrl.document_url');
        // return redirect()->away($URL)->with(['email'=>$email]);
         return redirect()->away($URL.'/'.$guid);
      }
      else
      {
        return view('logon');
      }
    }
    public function UploadPDScreeningScores(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      {
            $sta = Auth::user()->matricno;
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 600);
            $ses = $request->input('session');
            $todayDate = Carbon::now()->format('dmY');
           
            $data = Excel::import(new ImpPDSResult($ses), $request->file('resultfile')->store('temp'));
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/PDSResult');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="Predegree Result ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
     }
     else
     {
        return view('logon');
     }
    }
   public function UploadPDScreeningScore()
   {
    if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
       { 
         $data = DB::SELECT('CALL FetchPDSScreeningResults()');
         $ses = DB::SELECT('CALL FetchSession');
       // dd($data);
        return view('uploadPDScreeningScore',['data' =>$data,'lst'=>$ses]);
       }
       else
       {
        return view('logon');
       }
   }
    public function UploadUTMESubjects(Request $request)
    {
      $adm = Auth::user()->usertype;
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      {
             $sta = Auth::user()->matricno;
             //dd($sta);
             $path = $request->file('subfile');
             ini_set('max_execution_time', 600);
           
             $todayDate = Carbon::now()->format('dmY');
             // dd($ses);
             $data = Excel::import(new ImpUTMESubject, $request->file('subfile')->store('temp'));
             $file_path = $request->file('subfile');   
             $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
             $input['imagename'] = $ID.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
             $destinationPath = public_path('/uploads/PostUtmeSubject/');     
             $file_path->move($destinationPath, $input['imagename']); 
             $imgP=$input['imagename'];
             $myfile_path=$imgP;
             $filetype="Post UTME Subject ";
             $fname = $ID.'-'.$todayDate;
              //Save backup File
            /* */
        
           $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
  
           if($sav)
           {
             return back()->with('success', 'File Uploaded Successfully');
           }  
      }
      else
      {
         return view('logon');
      }
    }
    public function UploadUTMESubject()
    {
        if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
        { 
          $data = DB::SELECT('CALL 	FetchUTMESubject()');
          return view('uploadUTMESubject',['data'=>$data]);
        }
        else
        {
          return view('logon');
        }
    }
    public function ChangePassports(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      { 
        $file_path = $request->file('passfile');
        $matricno = $request->matricno;
        $utme = $request->utme;
        $file_tmp = $_FILES['passfile']['tmp_name'];
        $size = filesize($file_tmp);
           if($size>20000)
            {
                return back()->with('error', 'Photo Must Not Greater Than 20K, Please Retry');
            }
        $input['imagename'] = $matricno.'.'.$file_path->getClientOriginalExtension();
        $destinationPath = public_path('/Passports');
        $file_path->move($destinationPath, $input['imagename']);
        $imgP=$input['imagename'];
        $photo=$imgP;

        //Update Passport
        //session(['res' => null]);
         $data = DB::SELECT('CALL GetPreRegistrationInfo(?)',array($utme));
         $u = DB::UPDATE('CALL UpdateApplicantPhoto(?,?)',array($matricno,$photo));
         return view('changePassport',['data'=>$data]);
      }
      else
      {
      return view('logon');
      }
    }
    public function ChangePassport()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
      { 
        // $data = DB::SELECT('CALL GetPreRegistrationInfo(?)',array($utme));
         return view('changePassport');
      }
      else
      {
      return view('logon');
      }
    }
    public function UploadPassports(Request $request)
    {
        if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
        { 
           $utme =$request->utme;
           $data = DB::SELECT('CALL GetPreRegistrationInfo(?)',array($utme));
           if($data)
           {
               session(['res' => $data]);
               return redirect()->route('changePassport');
           }
           else
           {
            return back()->with('error', 'No Record Found, Please Try Again');
           }
        }
        else
        {
        return view('logon');
        }
    }
    public function UploadPassport()
    {
        if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
        { 
           return view('uploadPassport');
        }
        else
        {
        return view('logon');
        }
    }
    public function UploadUTMEInfos(Request $request)
    {
      $adm = Auth::user()->usertype;
     if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
     {
            $sta = Auth::user()->matricno;
            //dd($sta);
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 600);
            $ses = $request->session;
          //  dd($ses);
            $todayDate = Carbon::now()->format('dmY');
            // dd($ses);
            $data = Excel::import(new ImpUTMEInfo($ses), $request->file('resultfile')->store('temp'));
 
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/PDSResult');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="Post UTME Result ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
     }
     else
     {
        return view('logon');
     }
    }
    public function UploadUTMEInfo()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
        { 
          $data = DB::SELECT('CALL FetchUTMEInformation()');
          $ses = DB::SELECT('CALL FetchSession()');
         //dd($ses);
        return view('uploadUtmeInfo',['data' =>$data,'lst'=>$ses]);
        }
        else
        {
        return view('logon');
        }
    }
    public function UploadPOSTUTMEResults(Request $request)
    {
      $adm = Auth::user()->usertype;
     if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
     {
            $sta = Auth::user()->matricno;
            //dd($sta);
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 600);
            $ses = $request->session;
            $todayDate = Carbon::now()->format('dmY');
            // dd($ses);
            $data = Excel::import(new PostUTMEResult($ses), $request->file('resultfile')->store('temp'));
 
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/PDSResult');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="Post UTME Result ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
     }
     else
     {
        return view('logon');
     }
    }
    public function uploadPostUTMEResult()
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
        { 
          $data = DB::SELECT('CALL FetchPostUTMEResults()');
          $ses = DB::SELECT('CALL FetchSession');
         //dd($ses);
        return view('uploadPostUTMEResult',['data' =>$data,'lst'=>$ses]);
        }
        else
        {
        return view('logon');
        }
    }
    public function UploadPDSResult(Request $request)
    {
      if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
     {
            $sta = Auth::user()->matricno;
            $path = $request->file('resultfile');
            ini_set('max_execution_time', 600);
            $ses = $request->input('session');
            $todayDate = Carbon::now()->format('dmY');
           
            $data = Excel::import(new PDSResult($ses), $request->file('resultfile')->store('temp'));
 
            $file_path = $request->file('resultfile');
            $sess = substr_replace($ses, '/', 4, 0);//Addd '/' To the session
            $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
            $input['imagename'] = $sess.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
            $destinationPath = public_path('/uploads/PDSResult');     
            $file_path->move($destinationPath, $input['imagename']); 
            $imgP=$input['imagename'];
            $myfile_path=$imgP;
            $filetype="Predegree Result ".$ses;
            $fname = $ID.'-'.$todayDate;
             //Save backup File
           /* */
       
          $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  
 
          if($sav)
          {
            return back()->with('success', 'File Uploaded Successfully');
          }  
     }
     else
     {
        return view('logon');
     }
    }
   public function UploadPDScore()
   {
    if(Auth::check()  && (Auth::user()->usertype =='Admin' || Auth::user()->usertype='Staff'))
       { 
         $data = DB::SELECT('CALL FetchPDSResults()');
         $ses = DB::SELECT('CALL FetchSession');
       // dd($data);
        return view('uploadpdsResult',['data' =>$data,'lst'=>$ses]);
       }
       else
       {
        return view('logon');
       }
   }
   public function CreateCurriculum(Request $request)
   {
        if(Auth::check())
         {
                $sta = Auth::user()->matricno;
                //$path = $request->file('userfile')->getRealPath();
                ini_set('max_execution_time', 600);
                $todayDate = Carbon::now()->format('dmY');
                $data = Excel::import(new CurriculumImport, $request->file('userfile')->store('temp'));

                $file_path = $request->file('userfile');
                $ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
                $input['imagename'] = $ID.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
                $destinationPath = public_path('/uploads/Curriculum');     
                $file_path->move($destinationPath, $input['imagename']); 
                $imgP=$input['imagename'];
                $myfile_path=$imgP;
                $filetype="Course Curriculum";
                $fname = $ID.'-'.$todayDate;
                 //Save backup File
               /* */
           
              $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  

              if($sav)
              {
                return back()->with('success', 'File Uploaded Successfully');
              }  
         }
         else
         {
            return view('logon');
         }
   }
    public function SetCurriculum()
    {
      if(Auth::check())
      {
        $data = DB::SELECT('CALL FetchCurriculumBySession()');
        return view('uploadCurriculum',['data'=>$data]);
      }
      else
      {
        return view('logo');
      }
    }
    public function UploadAuthentication(Request $request)
    {
        
        if(Auth::check())
        {

				$sta = Auth::user()->matricno;
				$_SESSION['error_lst'] =null;
				$status = true;
				$path = $request->file('userfile')->getRealPath();
			   	$collection=collect();
				$counter = 0;
				$err ="";
                //$todayDate = Carbon::now();
                ini_set('max_execution_time', 600);
                $todayDate = Carbon::now()->format('dmY');
                $data = Excel::import(new UsersImport, $request->file('userfile')->store('temp'));
                  //dd($data);
                   
             
            /* */
				$file_path = $request->file('userfile');
				$ID = mt_rand(1111, 9999).mt_rand(1111, 9999).mt_rand(1111, 9999);
				$input['imagename'] = $ID.'-'.$todayDate.'.'.$file_path->getClientOriginalExtension();       
				$destinationPath = public_path('/uploads/Auths');     
				$file_path->move($destinationPath, $input['imagename']); 
				$imgP=$input['imagename'];
				$myfile_path=$imgP;
                $ses = $request->input('session');
                $filetype="User Authentication";
		        $fname = $ID.'-'.$todayDate;
                 //Save backup File
               /* */
           
              $sav =DB::INSERT('CALL SaveFileBackups(?,?,?,?)', array($sta,$filetype,$myfile_path,$fname));  

              if($sav)
              {
                return back()->with('success', 'File Uploaded Successfully');
              }  
        }
                  
		  
 
	  
	
	
   }
    public function UploadUserAuthecticate()
    {
        if(Auth::check())
         {
            $data = DB::SELECT('CALL FetchUsers()');
            $ses = DB::SELECT('CALL FetchSession');
           // dd($data);
            return view('uploadUserAuth',['data' =>$data,'ses'=>$ses]);
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
