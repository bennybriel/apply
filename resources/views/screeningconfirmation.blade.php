
<?php
   use Carbon\Carbon;
   $apt = Auth::user()->apptype;
   $ses = Auth::user()->activesession;
   //$apptype = Auth::user()->apptype;
   $appname ="";
   if($apt=="PDS")
   {
      $appname="Predegree";
   }
   elseif($apt=="JUP")
   {
      $appname="Jupeb";
   }
   elseif($apt=="PAT")
   {
      $appname="Part Time";
   }
   elseif($apt=="UGD")
   {
      $appname="Undergradute";
   }
   elseif($apt=="PG")
   {
      $appname="Postgraduate";
   }
   //dd($ses.$apt);
   $result = DB::SELECT('CALL GetScreenInfoByApptype(?,?)',array($apt,$ses));
 // dd($apt);
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
          <img src="../logRegTemp/img/brand/logo_predegree.jpg" style="max-width:100%;height:auto;"/>
          </div>
    </div>
    <div class="col-md-4"></div>
</div>


  <div class="w3-container">

               

                <h2 align="center" style="color:#da251d">{{ strtoupper($appname) }} Registration Confirmation</h2>
                @if($data)
               <div style="overflow-x:auto; ">
                <table width="698" border="0" align="center">
               <thead>
                 <tr>
                   <td width="100" rowspan="9" class="noBorder" >
				        <?php
                   $pic = $data[0]->photo;
                   $ses = str_replace("/","",Auth::user()->activesession);
                   //dd($pic);
                ?>
					           <img src="{{ asset('public/Passports/'.Auth::user()->apptype.$ses.'/'.Auth::user()->photo)}}" style="max-width:130px;height:150px;" /> 		
            
             		   </td>
                    <td width="132" class="noBorder" >Student Name</td>
                    <td width="369" class="noBorder1">{{ Auth::user()->name}}</td>
                 </tr>
                  <tr>
                    <td class="noBorder">Form Number</td>
                    <td class="noBorder1">{{ Auth::user()->formnumber}}</td>
                 </tr>
                 @if(!$apt=="DE" || !$apt=="TRF")
                 <tr>
                   <td class="noBorder"> First Choice Course </td>
                    <td class="noBorder1">{{ $data[0]->category1 }}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Second Choice Course  </td>
                    <td class="noBorder1">{{ $data[0]->category2 }}</td>
                 </tr>
                 @endif
                 @if($apt=="PG")
                 <tr>
                        <td class="noBorder">App.No  </td>
                        <td class="noBorder1">{{ $data[0]->appnumber }}</td>
                    </tr>
                  <tr>
                      <td class="noBorder">Programme  </td>
                      <td class="noBorder1">{{ GetPGProgramme($data[0]->category1) }}</td>
                  </tr>
                 @endif
                 @if($apt=="DE")
                 <tr>
                    <td class="noBorder">Programme  </td>
                    <td class="noBorder1">{{ $data[0]->category1 }}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Mode </td>
                    <td class="noBorder1">Direct Entry</td>
                 </tr>
                 @endif
                 <tr>
                   <td class="noBorder">Session </td>
                    <td class="noBorder1">
                    {{  $data[0]->session}}
                    </td>
                 </tr>

                 <tr>
                   <td class="noBorder">Email</td>
                    <td class="noBorder1">{{ $data[0]->email }}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Phone</td>
                    <td class="noBorder1">{{ $data[0]->phone }}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Date of Birth</td>
                                   
                   <td class="noBorder1">{{ Carbon::parse($data[0]->dob)->format('d-m-Y') }}</td>
                 </tr> 

                 <tr>
                   <td class="noBorder">State of Origin</td>
                    <td class="noBorder1">{{ $data[0]->state }}</td>
                 </tr>
                
                
                 </thead>
          </table>
          <hr/>
          <h4 style="color:red"><strong>Screening Information</strong></h4>
          <table width="698" border="0" align="center">
               <thead>
          @if($result)
          
                  @if($apt=='JUP')
                     <tr>
                        <td class="noBorder">Proceed To Screening Venue</td>
                          <td class="noBorder1">{{ $result[0]->venue }}</td>
                      </tr>
                  @else
                      <tr>
                        <td class="noBorder">Venue</td>
                          <td class="noBorder1">{{ $result[0]->venue }}</td>
                      </tr>
                      <tr>
                        <td class="noBorder">Date</td>
                          <td class="noBorder1"> {{ Carbon::parse($result[0]->sdate)->format('l d-m-Y') }}</td>
                      </tr>
                      <tr>
                        <td class="noBorder">Time</td>
                          <td class="noBorder1"> {{ $result[0]->stime }}</td>
                      </tr>
                  @endif
                @else
                 
                  <span>Venue Information Not Available</span>

                @endif
       </div>

   
       </thead>
          </table>

    @endif
    <p><h6 style="color:#da251d">For enquires</h6>
                  <strong>Call</strong> +234 803 568 5435, +234 803 378 6715 <br/>
                  <strong>Email</strong> 
                            @if($apt=="PDS")
                                  pds@lautech.edu.ng 
                             @endif 
                              @if($apt=="JPB")
                                 jupeb@lautech.edu.ng
                              @endif

                                                        </p>

                                                      
</div>
    </div>


                                     
</div>


</html>

<?php 

  function GetPGProgramme($pro)
  {
       $p = DB:: SELECT('CALL GetPGProgramme(?)',array($pro));

      
       if($p)
       {
         return $p[0]->programme;
       }
       else
       {
         return 0;
       }
  }