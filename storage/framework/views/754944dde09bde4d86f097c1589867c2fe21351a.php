
<?php
   use Carbon\Carbon;
   //use DateTime;
   //$utme ="10555062HG";
   $formnumber = Auth::user()->formnumber;
   $pro =DB::table('pgadmissionlist')->where('formnumber',$formnumber)->first();  // DB::SELECT('CALL GetAdmissionInfo(?)',array($utme));
   $info ='Name: '.Auth::user()->name .' FormNumber.'.Auth::user()->formnumber. ' Programme ='.$pro->course; // (round(SumTotalSubjectGrade($utme)/3,1) + round($uinfo[0]->totalscore/8,1) + $presult[0]->score);  
   //$q = QrCode::size(100)->backgroundColor(255,255,1)->generate($info);
   $base64 ="";
   try
   {
    ini_set('max_execution_time', 300);
     $client = new \GuzzleHttp\Client();
     $url    = 'http://api.qrserver.com/v1/create-qr-code/?data="'.$info.'&size=70x70'; //config('paymentUrl.product_id_url_all');     
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
   .div
    {
       padding-top: 2px;
       font-size:10px;
     }
    table {
    border-collapse: collapse;
     font-size:12px;
    }

    td, th {
    border: 1px solid #999;
    padding: 0.1rem;
    font-size:14px;
    text-align: left;
    }

    {
  box-sizing: border-box;
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 2px;
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
        padding-top: 2px;
       
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
           
           <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO<br/>  
                                 NIGERIA
<P align="center" style="color:#b11226; font-size:15px; font-family:'ARIAL'">
               <img src="../logRegTemp/img/brand/logo_admission.png" width="40px" height="50px"/><br/> 
               THE POSTGRADUATE SCHOOL
     </P>     
      </div>
    </div>
    <div class="col-md-4"></div>
</div>
           <table style="font-size:13px;">
               <thead>
                   <tr>
                    <td width="150" class="noBorder1">
                    <p> <em>GSM<br/>
                                                <b>+2348185061737</b><br/>
                                                   +2347064960343<br/>
                                                </em><br/>
                                             
                      </p>
                 </td>
                    <td width="150" class="noBorder1">
                         <p><strong>Email</strong> <br/>              
                         <strong></strong> pgschool@lautech.edu.ng  <br/>
                        
                       

                 </td>

                    <td width="150" class="noBorder1">
                         <p><strong>Postal Address</strong> <br/>              
                         <strong></strong>P.M.B. 4000 Ogbomoso, Nigeria  <br/>
                         
                       

                 </td>
                 </tr>

                 
                  <tr>
                    <td width="200" class="noBorder1">

                    <p> <em> <b>DEAN</b>:PROFESSOR A. W. OGUNSOLA</span><br/>
                     <b>SECRETARY</b>:	MR. A. P. AKANBI B.Ed., M.Ed., IBADAN</b><br/>
                    </em>
                                             
                      </p>
                    </td>
                    <td width="150" class="noBorder1">
                         
                    </td>
                    <td width="150" class="noBorder1">
                         Date: February 14, 2022
                    </td>
                 </tr>
                
                 <tr>
                    <td width="150" class="noBorder1">
                       <?php if($pro): ?>
                        <b><?php echo e(strtoupper(Auth::user()->name)); ?></b>
                        <br/>
                        <b><?php echo e(strtoupper($pro->course)); ?> LAUTECH P.M.B. 4000</b>
                        <br/>
                        Ogbomoso.
                        <br/>
                        
                        <?php echo e(Auth::user()->appnumber); ?>

                       <?php endif; ?>
                   </td>
                    <td width="200" class="noBorder1">
                         
                    </div></td>
                    <td width="150" class="noBorder1">
                        <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.Auth::user()->photo)); ?>" alt="Member's Photo" width="80px" height="70px" />	
            
                    </div></td>
                 </tr> 

           
</table>

          
<div class="w3-container"> 
 Dear <?php echo e(Auth::user()->firstname); ?><br/>
<b class="headingCenter" style="color:#b11226; font-size:13px;"> ADMISSION AND REGISTRATION FOR HIGHER DEGREE COURSES</b>
<p style="text-align:justify;font-size:14px; ">With reference to your application for admission to a higher degree course of this university
 in the Department of <b><?php if($pro): ?> <?php echo e($pro->programme); ?> Faculty of <?php echo e(GetFaculty($pro->programme)); ?></b>,<?php endif; ?>  it is my pleasure to inform you that the application is successful.
 Your registration will be for the degree of  <?php if($pro): ?>  <b><?php echo e(GetDegree($pro->degree)); ?> </b> <?php endif; ?>. Mode of your study is Full-Time.<br/>
Please, take note of the following conditions relating to your registration:
<ul style="text-align:justify;font-size:14px; ">
  <li>	You will need to visit Postgraduate School with a copy of your admission letter 
    and signed Acceptance Form (printed online), if you will accept the offer. Details of 
    the fees payable will be made available to you on your application portal, to assist your
     decision on the offer of the admission.</li>
  <li> 	You are expected to commence the programme at the beginning of the 2021/2022 Session.  </li>
  <li> 	You will be required to present the original copies of your educational/other relevant 
    credentials, and NYSC, Discharge/Exemption/Exclusion Certificate for Verification at the
     appropriate office in the Postgraduate School before you proceed to make payment of the prescribed fees.</li>
  <li>	Foreign student will need to present a copy of our letter to the Director-General. 
    Federal Ministry of Internal Affairs. Abuja for necessary action. When applying for entry permit 
    or visa, you are requested to furnish him with the following items of information to accelerate
     action on your application.</li>


<p style="text-align:justify; "><b>a.	Your nationality	 b.	Date and Place of Birth. 
c.	Passport Number, Date and Place of Issue	d.	Validity of Passport
e.	Length of the Intended stay at the Ladoke Akintola University of Technology,
 Ogbomoso. </b></p>


</p>

<p style="text-align:justify; "><li>	You are required to register for your programme of study within three weeks of the commencement 
 of the academic year and to renew your registration annually until you finally complete the programme.</li>
</p>
<p style="text-align:justify; "><li>	Please note that the offer may be revoked, if you fail to
 complete your registration within the stipulated period</li> 
</ul>
	Congratulations.
</p>
             <table width="831" align="center">
               <thead>                
                  <tr>
                    <td width="200" class="noBorder1">
                           <?php  // echo '<img src="'.$base64.'">';   ?>
                   </td>
                    <td width="200" class="noBorder1">
                            <p style="text-align:justify;">Yours faithfully, <br/>
       				</td>
                   <td width="200" class="noBorder1">    </td>                
                 </tr>
             </table>

             <table width="831" align="center">
               <thead>                
                  <tr>
                    <td width="200" class="noBorder1">	
                    
                    </td>
                    <td width="200" class="noBorder1">
                            <p style="text-align:justify;">
                                 <img src="../logRegTemp/img/brand/pg_signature.jpeg" width="58" height="24"/><br/>
                                Secretary, <br/>
                                                    The Postgraduate School
                                <br/>
       				</td>
                   <td width="200" class="noBorder1">    </td>                
                 </tr>
             </table>

</div>
<?php
   function GetFaculty($dep)
   {
       $sc = DB::table('departments as de')
                       ->select('faculty','department')
                       ->join('faculty as fa','fa.FacultyID','=','de.FacultyID')
                       ->where('Department',$dep)
                       ->first();
     if($sc)
     {
        DB::UPDATE('CALL UpdateAdmissionLetterDownload(?)',array(Auth::user()->formnumber));
        return $sc->faculty;
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

<?php

  function GetDegree($de)
  {
     $de = DB::table('pgdegree')->where('degree',$de)->first();
     if($de)
     {
       $deg = $de->name.'('.$de->degree. ')';
       return $deg;
     }
     else
     {
        return 0;
     }
  }
?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/admissionLetterPG.blade.php ENDPATH**/ ?>