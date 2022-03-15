
<?php
   $Tunit=0;
   use Carbon\Carbon;
   $mat = Auth::user()->matricno;
   $ses = Auth::user()->activesession;
   $apptype = Auth::user()->apptype;
   $data = DB::SELECT('CALL GetScreeningClearnanceByUTME(?)', array($mat));
   $ch = DB::table('change_programmes')->where('utme',Auth::user()->utme)->first();

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
    }

    {
  box-sizing: border-box;
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 10px;
  height: 30px; /* Should be removed. Only for demonstration */
}

.left {
  width: 25%;
}

.right {
  width: 75%;
}
.lefts {
  width: 50%;
}

.rights {
  width: 50%;
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
</style>

<div class="row">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
       <div align="center">
          <img src="../logRegTemp/img/brand/logo_admission.png" style="max-width:100%;height:auto;"/>
          <h2>Ladoke Akintola University of Technology</h2>
          </div>
    </div>
    <div class="col-md-4"></div>
</div>


  <div class="w3-container">



                <h4 align="center" style="color:#da251d">Post UTME Registration Confirmation</h4>
                @if($data)
               <div style="overflow-x:auto; ">
                <table width="1000" border="0" align="center">
               <thead>
                 <tr>
                   <td width="183" rowspan="9" class="noBorder" >
				  
					         <img class="nav-user-photo" src="{{ asset('public/Passports/'.$data[0]->photo)}}" alt="Member's Photo" width="183" height="200px" />             		   </td>
                    <td width="116" class="noBorder" >Name</td>
                    <td width="687" class="noBorder1"><div align="left">{{ Auth::user()->name}}</div></td>
                 </tr>
                  <tr>
                    <td class="noBorder">UTME No.</td>
                    <td class="noBorder1"><div align="left">{{  Auth::user()->utme }}</div></td>
                 </tr>
                
                 @if($apptype=="UGD")

                 <tr>
                   <td class="noBorder">Programme </td>
                    <td class="noBorder1"><div align="left">{{ $data[0]->category1 }}</div></td>
                 </tr>
                 @if($ch)
                 <tr>
                   <td class="noBorder">Old Programme </td>
                    <td class="noBorder1"><div align="left">{{ $data[0]->category1 }}</div></td>
                 </tr>
                 <tr>
                   <td class="noBorder"> New Programme </td>
                    <td class="noBorder1"><div align="left">{{ $ch->programme }}</div></td>
                 </tr>
                 @else
                  <tr>
                    <td class="noBorder">Programme </td>
                      <td class="noBorder1"><div align="left">{{ $data[0]->category1 }}</div></td>
                  </tr>
                 @endif
                 <tr>
                   <td class="noBorder">Mode </td>
                    <td class="noBorder1"><div align="left">UTME</div></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Session </td>
                    <td class="noBorder1"><div align="left">{{ $data[0]->session }}</div></td>
                 </tr>

                 <tr>
                   <td class="noBorder">Screening Date</td>
                    <td class="noBorder1"> <div align="left">{{ Carbon::parse($data[0]->examdate)->format('d-m-Y') }}</div></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Screening Time</td>
                    <td class="noBorder1"><div align="left">{{ $data[0]->examtime }}</div></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Venue</td>
                    <td class="noBorder1"><div align="left">{{ $data[0]->hall }}</div></td>
                 </tr> 
                 <tr>
                   <td class="noBorder">Batch No.</td>
                    <td class="noBorder1"><div align="left">{{ $data[0]->batch }}</div></td>
                 </tr>
              @endif

                 </thead>
          </table>
       </div>



    @endif
    @if($apptype=="UGD")
     <p>

     <strong>NOTE:</strong><em> Please ensure that this document is printed with a coloured printer as white and black printout 
     will not be accepted for the screening exercise. </em>
     </p>
     @endif                                                
</div>
    </div>


                                     
</div>


</html>

<?php
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

?>

