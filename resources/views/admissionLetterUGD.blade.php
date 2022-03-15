
<?php
   use Carbon\Carbon;
   //use DateTime;
   $utme = Auth::user()->utme;
   $pro = DB::SELECT('CALL GetAdmissionInfo(?)',array($utme));
   $info ='Name: '.Auth::user()->name .' UTME No.'.Auth::user()->utme. ' Programme ='.$pro[0]->programme; // (round(SumTotalSubjectGrade($utme)/3,1) + round($uinfo[0]->totalscore/8,1) + $presult[0]->score);  
   //$q = QrCode::size(100)->backgroundColor(255,255,1)->generate($info);
   
   try
   {
    ini_set('max_execution_time', 300);
     $client = new \GuzzleHttp\Client();
     $url    = 'http://api.qrserver.com/v1/create-qr-code/?data="'.$info.'&size=100x100'; //config('paymentUrl.product_id_url_all');     
     //dd($url);
      $response =$client->request('GET', $url,['stream' => true]);
      $data = $response->getBody()->getContents();
      $base64 = 'data:image/png;base64,' . base64_encode($data);
     // '<img src="'.$base64.'">';
   }
   catch(\GuzzleHttp\Exception\RequestException $e)
   {
   
      $error['error'] = $e->getMessage();
      $error['request'] = $e->getRequest();
      if($e->hasResponse()){
          if ($e->getResponse()->getStatusCode() == '400'){
              $error['response'] = $e->getResponse(); 
          }
      }
      Log::error('Error occurred in get request.', ['error' => $error]);
   }
   catch(Exception $e)
   {
      //other errors 
   }
?>
<!doctype html>
<html lang="en">

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
.headingRight
{
  float: right;

  padding-right:20px;
}
.headingCenter
{
  text-align: center;
  /* border: 3px solid #73AD21; */
  font-weight: bolder;
  padding: 10px;
}
body {
  /* background-image: url("logRegTemp/img/brand/bglogo.jpg");
  background-repeat: no-repeat;
  background-position: center; */
}
  #watermark {
                position: fixed;

                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                bottom:   8cm;
                left:     5.5cm;

                /** Change image dimensions**/
                width:    8cm;
                height:   8cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
  


</style>

<div class="row">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
       <div align="center">
           <P align="center" style="color:#b11226; font-size:20px; font-family:'ARIAL'">
               <img src="../logRegTemp/img/brand/logo_admission.png" width="90px" height="110px"/><br/> 
           <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY<br/>  
                 P.M.B 4000, OGBOMOSO, OYO STATE, NIGERIA<br/>   
                 OFFICE OF THE REGISTRAR</b><br/>
            </P>

        
      </div>
    </div>
    <div class="col-md-4"></div>
</div>

                                  
                            

            <table width="963" border="0" align="center">
               <thead>
                 
                  <tr>
                    <td width="305" class="noBorder1">

                    <p><span style="color:#b11226">Registrar</span><br/>
                                                <b>Dr. Kayode A. Ogunleye</b><br/>
                                                <em>B.A (Jos) M.A. (Ilorin), PhD (U.I.),<br/>
                                                MANUPA, MCIPM, AUA (UK), FICA</em><br/>
                                             
                      </p>
                    </td>
                    <td width="648" class="noBorder1">
                         <p><strong style="color:#b11226";>Tel:</strong> (+234)8067624952 <br/>              
                         <strong style="color:#b11226";>Email:</strong> <u>registrar@lautech.edu.ng</u>  <br/>
                         <br/>
                         December 31, 2021.

                    </div></td>
                 </tr>
                
                

              </thead>
</table>

<div id="watermark">
               <img src="../logRegTemp/img/brand/bglogo.jpg" height="100%" width="100%" />
            </div>     

<div class="w3-container"> 
@if($pro)
  <b>{{ strtoupper($pro[0]->name) }} ({{ strtoupper(Auth::user()->utme) }})</b>
@endif
<br/>
 <b>Dear {{ strtoupper(Auth::user()->firstname) }} </b>,
<br/>

<div class="headingCenter" style="color:#b11226; font-size:20px;"> NOTIFICATION OF RECOMMENDATION FOR ADMISSION ON JAMB CAPS FOR 2021/2022 ACADEMIC SESSION</div>
<p style="text-align:justify; ">I am delighted to notify you that you have been offered provisional admission to
 LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO to study  <strong>@if($pro) {{ $pro[0]->programme }} @endif </strong> in the 
 Faculty of  <strong> @if($pro) {{ GetFaculty($pro[0]->programme) }} @endif </strong> at undergraduate level. Consequently, 
 the University will recommend your provisional admission on JAMB CAPS. 
 </p>

<p style="text-align:justify; ">
Confirmation of this offer is subject to your obtaining the minimum entry qualifications for the course 
to which you have been recommended for admission and payment of non-refundable acceptance fee of 
Thirty Thousand Naira (N30,000.00) only through an interswitch enabled debit card within fourteen (14) 
days after the date of notification of recommendation for admission, otherwise the provisional admission 
offered will be forfeited.
</p>

<p style="text-align:justify; ">Please note that it is only after you have satisfied the above conditions 
that the university will recommend you for admission on JAMB CAPS
</p>
<p style="text-align:justify; ">All other relevant information on your admission in the University shall be posted on the University admission
portal: <u>www.apply.lautech.edu.ng</u>. </p>
<p style="text-align:justify; ">	Congratulations.</p>

             <table width="831" align="center">
               <thead>
                 
                  <tr>
                    <td width="373" class="noBorder1">
                      <?php   echo '<img src="'.$base64.'">';   ?>
            				</td>
                    <td width="446" class="noBorder1">
                    <p style="text-align:justify;">Yours faithfully, <br/>
                      <br/>
                        <img src="../logRegTemp/img/brand/registrarsign.jpg" width="116" height="48"/>
                        <br/>
                        <strong>K. A. Ogunleye, Ph.D</strong> <br/>
                        
                      </p>


                 
                 </tr>
             </table>

</div>
<?php
   function GetFaculty($dep)
   {
     $sc = DB::SELECT('CALL GetCandidateFaculty(?)',array($dep));
     if($sc)
     {
        DB::UPDATE('CALL UpdateAdmissionLetterDownload(?)',array(Auth::user()->utme));
        return $sc[0]->faculty;
     }
     else
     {
       return 0;
     }
 
   }

?>



		
		


































               
               


                                                      
</div>



</div>


                                     
</div>


</html>

