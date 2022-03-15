
<?php
use Illuminate\Support\Collection;

  $mat =  Session('matricno');
  $utme = Session('utme');
  $name = Session('name');
  //$utme ="10055815EA";
  $subj =DB::SELECT('CALL GetUTMESubjects(?)',array($utme));
  $scount = count($subj);
  //dd($subj);
  #Get Programme Applied For
  $pr = DB::SELECT('CALL GetCandidateProgramme(?)',array($mat));
  $dat   = DB::SELECT('CALL GetUTMEInfoResult(?)',array($mat));
  $result = DB::SELECT('CALL GetPOSTUtmeResult(?)',array($utme));
  $info ='Name: '.$name .' UTME No.'.$utme. ' Programme ='.$dat[0]->category1 .' UTME SCORE:'.$dat[0]->totalscore; // (round(SumTotalSubjectGrade($utme)/3,1) + round($uinfo[0]->totalscore/8,1) + $presult[0]->score);  
  $q = QrCode::size(100)->backgroundColor(255,255,1)->generate($info);
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
      //dd($pr[0]->programmeid);   
      $opt = DB::SELECT('CALL GetOptionalSubjects(?,?,?)',array($utme,$rcounter,$pr[0]->programmeid));
      //dd($opt);
     
   }
    
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
    table {
    border-collapse: collapse;
    }

    td, th {
    border: 1px solid #999;
    padding: 0.5rem;
    text-align: left;
    width: 10px;
    }

    {
  box-sizing: border-box;
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 10px;
  height: 10px; /* Should be removed. Only for demonstration */
}


/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.noBorder {
    border:none !important;
    font-weight: bold;
}
.noBorder1 {
    border:none !important;
}
.page {
  width: 18cm;
  min-height: 29.7cm;
  padding: 2cm;
  font-size:11px;
  margin: 1cm auto;
  border: 1px #D3D3D3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
@page {
  size: A4;
  margin: 0;
}

  /* ... the rest of the rules ... */
  .content-box 
  {
    column-width: 20px;
   }
}
body
 {
   background-image: url(logo.png);
   background-repeat: no-repeat;
   background-size: 300px 100px;
}
</style>
<div class="page">
      <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-12">
       <div align="center"style="word-spacing:0px;">
          <img src="../logRegTemp/img/brand/logo_admission.png" width="60" height="61"/>
          <h4>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO</h4>
          <h5>2021/2022 POST UTME SCREENING RESULT SLIP</h5>
      </div>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="row">
               

             <div class="card shadow mb-4">
                            <div class="col-lg-12">
                                <div class="p-4">
                                <div class="card-body">
								   <div class="table-responsive">
                                        <table  width="85%" cellspacing="0">
                                                       
                                          <tr>
                                            <td width="100" rowspan="5">
                                                <div align="center">
                                                       @if(Auth::user()->photo)
                                                        <img class="nav-user-photo" src="{{ asset('public/Passports/'.Auth::user()->photo)}}" alt="Member's Photo" width="80px" height="70px" />
                                                       @else
                                                        <img src="../logRegTemp/img/brand/default.png" style="max-width:70px;height:70px;" />
                                                       @endif
                                                </div></td>
                                            <td width="467">UTME No. </td>
                                            <td width="510">{{  $utme }}</td>
                                           
                                          </tr>
                                          @if($uf)
                                          <tr>
                                            <td>Name</td>
                                            <td>{{ $uf[0]->name }}</td>
                                          </tr>
                                          @endif
                                          <tr>
                                            <td>Gender</td>
                                            <td>{{ $dat[0]->gender }}</td>
                                          </tr>
                                          <tr>
                                            <td>Programme</td>
                                            <td width="482">{{ $dat[0]->category1 }} </td>
                                          </tr>
                                          <tr>
                                            <td>Application Type </td>
                                            <td>UTME</td>
                                          </tr>
                                  </table>
                               </div>
							     </div>
                               </div>
                           </div>
  </div>
</div>
                         <div class="row">
                         <div class="col-lg-12">
                                <div class="p-1">
                                @if($scount > 9)
                                             @if($sid)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                         <h6 class="m-0 font-weight-bold" style="color:#da251d">O'level Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                       
                                                    <table class="table table-bordered" id="dataTable" width="85%" cellspacing="0">
                                                      
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Score</th>
                                                                    

                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    // dd($item[$counter][0]->grade);
                                                                    ?>
                                                                    @foreach($sid as $sd)
                                                                      <?php
                                                                        //dd($sd);
                                                                      ?>
                                                                        <tr>
                                                                             <td>{{ ++$i }}</td>
                                                                             <td>{{ GetSubject($sd->subjectid)}}</td>
                                                                             <td>{{ GetGrade($sd->subjectid) }}</td>
                                                                             <td>{{ GetScores($sd->subjectid) }}</td>

                                                                        </tr>
                                                                    @endforeach
                                                                    @foreach($opt as $da)
                                                                    <?php
                                                                         $total+=GetScore($da->grade);
                                                                      ?>
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                             <td>{{ $da->subject }}</td>
                                                                            <td>{{ $da->grade }}</td>
                                                                            <td>{{ GetScore($da->grade) }}</td>
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                 
                                                                </tbody>  
                                                              
                                                      </table>
                                                          
                                                    </div>
                                               </div>
                                             @endif
                                @else
                                @if($req)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                         <h6 class="m-0 font-weight-bold" style="color:#da251d">O'level Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                       
                                      <table class="table table-bordered" id="dataTable" width="85%" cellspacing="0">
                                                      
                                           <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Score</th>
                                                                    

                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    // dd($item[$counter][0]->grade);
                                                                    ?>
                                                                    @foreach($req as $data)
                                                                      <?php
                                                                        $total+=GetScore($data->grade);
                                                                      ?>
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                           
                                                                            <td>{{ $data->subject }}</td>
                                                                            <td>{{ $data->grade }}</td>
                                                                          <td>{{ GetScore($data->grade) }}</td>
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                    @foreach($opt as $da)
                                                                    <?php
                                                                         $total+=GetScore($da->grade);
                                                                      ?>
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                           
                                                                            <td>{{ $da->subject }}</td>
                                                                            <td>{{ $da->grade }}</td>
                                                                            <td>{{ GetScore($da->grade) }}</td>
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                 
                                                                </tbody>  
                                                              
                                                      </table>
                                                          
                                                    </div>
                                               </div>
                                             @endif
                                @endif

                             </div>
                        
                         <div class="card shadow mb-4">  
                             <div class="card-body"> 
                               
                                <br/>
                             
							     <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="85%" cellspacing="0">
                                  <tr>
                                    <td width="219"><strong>O'level Score</strong></td>
                                    <td width="656"><strong>
                                      <label>{{ $total }} /2 = {{ number_format($total/2,1) }}</label>
                                    </strong></td>
                                  </tr>
                                  <tr>
                                    <td><strong>UTME Score </strong></td>
                                    <td><strong>
                                      @if($dat)
                                      <label> {{ $dat[0]->totalscore }} / 400 * 50 = {{ number_format(((($dat[0]->totalscore)/400) * 50),1) }}</label>
                                      @endif
                                    </strong> </td>
                                  </tr>
                                  <tr>
                                    <td><strong>
                                      <label>Post UTME Score</label>
                                    </strong></td>
                                    <td><strong>
                                      <label></label>
                                      @if($result)
                                      <label> {{ $result[0]->score }}/35 </label>
                                      @endif
</strong> </td>           
                                  </tr>
                               </table>
							    </div>
                                <br/>
                                @if($result && $dat && $total)
                                <div align="center"><strong>Aggregate Score: {{ number_format($total/2,1) }} + {{ number_format(((($dat[0]->totalscore)/400) * 50),1) }} + {{ $result[0]->score }} = {{ number_format($total/2,1)  +  number_format(((($dat[0]->totalscore)/400) * 50),1)  + $result[0]->score }}%
                                <h3>{{ number_format($total/2,1)  +  number_format(((($dat[0]->totalscore)/400) * 50),1)  + $result[0]->score }}% </h3><br/>
                                @endif
                                </strong></div>
                              
                           </div>
                               
                                <em><label>
                                <div style="margin-right:15px">
								Please, note that this result does not guarantee automatic admission to the University. 
Admission to LAUTECH is free. Do not engage in frivolous transaction with anybody.</em>
                        </div>
                      
                  </div>
              </div>
</div>
 <table align="right" width="80%"  cellspacing="0" class="table table-bordered">
                                  <tr class="noBorder">
                                    
                                    <td  class="noBorder" width="105">{{ $q }}</td>
                                  </tr>
                                </table>
                                <br/>
 <?php   
 
 // DB::UPDATE('CALL UpdatePostUTMECheckStatus(?)',array(Auth::user()->utme));
  function GetScore($sid)
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

  function GetScores($sed)
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
  function GetGrade($sid1)
  {
      $g1 = DB::SELECT('CALL GetSubjectGrade(?,?)',array(Auth::user()->utme,$sid1));
     // dd($g1);
     if($g1)
     {
       return $g1[0]->grade;
     }
     else
     {
       return 0;
     }
  }
  function GetSubject($sid2)
  {
     $g2 = DB::SELECT('CALL GetSubjectGrade(?,?)',array(Auth::user()->utme,$sid2));
     if($g2)
     {
      return $g2[0]->subject;
     }
     else
     {
       return 0;
     }
  }

  Session(['utme'=>null]);
  Session(['matricno'=>null]);
  Session(['name'=>null]);
  ?>
                                