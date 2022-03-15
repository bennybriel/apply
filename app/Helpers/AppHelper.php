<?php
namespace App\Helpers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Carbon\Carbon;
class AppHelper
{
      public function bladeHelper($someValue)
      {
             return "increment $someValue";
      }

     public function startQueryLog()
     {
           \DB::enableQueryLog();
     }

     public function showQueries()
     {
          dd(\DB::getQueryLog());
     }

     public static function instance()
     {
         return new AppHelper();
     }
     public function GetNames($mat)
      { 
         $nam =DB::SELECT('CALL GetStudentName(?)', array($mat));
         if($nam)
         {
           return $nam[0]->name;
         }
         else
         {
          return $mat;
         }
     }
     public function GetProgramme($pro)
     {
           $de ="";
           $dat = DB::table('programme')->where('programmeid', $pro)->get()->first();

        if($dat)
         {
           return $dat->programme;
         }
         else
         {
          return $dat;
         }
           
     }
      public function GetActivity($ops)
      {
       //Activitylog
        $agent = new Agent();
        $plat = $agent->platform();
        $ver = $agent->version($plat);
        $pla_ver = $plat." ".$ver;
        $brw =$agent->browser();
        $b_v =$agent->version($brw);
        $brow = $brw.  " ".$b_v;
        $ops = Auth::user()->name. $ops;
        $ip = request()->ip();
        $ema = Auth::user()->email;
        $mat = Auth::user()->matricno;
        $mac = exec('getmac');
        $da = Carbon::now();// will get you the current date, time
        $dat= $da->format("Y-m-d:h:m:s");
        DB::INSERT('CALL ActivityTrackerLog(?,?,?,?,?,?,?,?)',array($ops,$ip,$ema,$mat,$mac,$dat,$pla_ver,$brow));
   }
}