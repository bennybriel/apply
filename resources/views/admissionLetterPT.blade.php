
<?php
   use Carbon\Carbon;
   //use DateTime;
   $level =0;
   $frm   = Auth::user()->formnumber;
   $pro  =   DB::table('ptadmissionlist')->where('formnumber',$frm)->first();
//dd($pro);
   $info ='Name: '.Auth::user()->name .' UTME No.'.Auth::user()->utme. ' Programme ='.$pro->programme. ' Programme ='.$pro->slevels; // (round(SumTotalSubjectGrade($utme)/3,1) + round($uinfo[0]->totalscore/8,1) + $presult[0]->score);  
   //$q = QrCode::size(100)->backgroundColor(255,255,1)->generate($info);
    if($pro)
    {
        if($pro->slevels == 100)
        {
            $level = 5;
        }
        elseif($pro->slevels == 200)
        {
            $level = 4;
        }
        elseif($pro->slevels == 300)
        {
            $level = 3;
        }
    }
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
           <P align="center" style="color:#b11226; font-size:22px; font-family:'ARIAL'">
               <img src="../logRegTemp/img/brand/logo_admission.png" width="90px" height="110px"/><br/> 
           <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY<br/>  
                 P.M.B 4000, OGBOMOSO, OYO STATE, NIGERIA<br/>   
                 DIRECTORATE OF PART-TIME PROGRAMME</b><br/>
            </P>

        
      </div>
    </div>
    <div class="col-md-4"></div>
</div>

                                  
                            

    
<div id="watermark">
               <img src="../logRegTemp/img/brand/bglogo.jpg" height="100%" width="100%" />
            </div>     

<div class="w3-container"> 

<br/>
   @if($pro)
     <b style="font-size:20px;">Dear {{ strtoupper($pro->name) }} ({{ strtoupper(Auth::user()->formnumber) }})</b>
   @endif 
<br/>
<div class="headingCenter" style="font-size:22px;">  {{ Auth::user()->activesession }} Academic Session</div>

<div class="headingCenter" style="color:#b11226; font-size:20px;"> OFFER OF PROVISIONAL ADMISSION</div>
<p style="text-align:justify; font-size:18px;">With reference to your application to Part-Time Programme of the University, I am pleased to inform you
that you have been offered provisional admission to pursue {{ $level }} years Bsc Degree Programme in the department of <strong>@if($pro) {{ $pro->programme }} @endif </strong> in the 
  </strong>
 </p>

<p style="text-align:justify;font-size:18px; ">
1 (a).  You will present for scrutiny at the point of registration, the original copies of all the 
 credientials you have listed in your application form.<br/>
 (b). All candidate must statify minimum University admission requirements as advertised for each programme.<br/>
 (c). If at anytime from the point of registration and thereafter, it is discovered that any of your credientials you
 claimed to have had is forged, you will be required to withdraw from the programme and would forfeit all fees paid in 
 respect of same. <br/>
 (d). The names by which you are hereby admitted and by which you will register will be the names which appear on the 
 statement of result/degree certificate that may be issued to you on the successful completion of the programme except a change 
 of name arising from marriage of a female student during the course of the programme. <br/>
 2(a). Payment of the tuition fee will be made online as specified in the attached payment information sheet.<br/>
  (b). Please note that fee paid are non-refundable.<br/>
3. When completing online registration form, kindly follow all the instruction on the university official website
  <www class="lautech edu ng">lautech.edu.ng</www> <br/>
4. Note that your final admission will be based on the outcome of the verification of your results.<br/>
5. You are to resume immedicately.<br/>
6. <em><b>You are to obey the university rules and regulations and matriculation oath, refrain from all act of indiscipline,
  examination malpractices, violence, looting and vadnalism. You are to show at all time respect to the office and person of 
  vice-chacellor and other university officers.
  Failure to comply with these provisions shall lead to your automatic explusion from the university.
 </b></em>
</p>
<p style="text-align:justify; ">Congratulations.</p>

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

<div class="headingCenter" style="color:#b11226; font-size:20px;"> PAYMENT INFORMATION</div>
<p style="text-align:justify; "><b>N.B</b>-Please note that you are expected to pay the acceptance fee of <b>N30,000.00 immediately</b>
 otherwise, the provisional admission offered is assumed forfeited. Please note also that you are to pay the tuition fee, as 
 appropriate, within two(2) weeks of resumption.
 </p>
 <p style="text-align:justify;">
 You are expected to <b>pay online</b>, acceptance fee of <b>N30,000.00</b> as well as tuition fee of <b>N100,000.00</b> using any
 <b>Interswitch Enabled Debit Cards <br/> to enable you to continue your registration online at parttime.lautech.edu.ng  website.

 </p>
 <p style="text-align:justify;">
   Note that after completion of all payments which will give you access to online registration process at www.lautech.edu.ng 
   website, you are expected to print and submit your documents, as appropriate, at the directorate of part time studies. 
 </p>

?>



		
		


































               
               


                                                      
</div>



</div>


                                     
</div>


</html>

