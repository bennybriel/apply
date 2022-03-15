
<?php
use Carbon\Carbon;
//use DateTime;
$utme = Auth::user()->utme;
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


         .pss {
       white-space: pre;
}
</style>

<div class="row">
 <div class="col-md-8">
 </div>
 <div class="col-md-4">
    <div align="center">
        <P align="center" style="color:#b11226; font-size:20px; font-family:'ARIAL'">
            <img src="../logRegTemp/img/brand/logo_admission.png" width="90px" height="110px"/><br/> 
        <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO<br/>   
            OATH OF ALLEGIANCE
             </b><br/>
         </P>

     
   </div>
 </div>
 <div class="col-md-4"></div>
</div>

                               
                        


<div class="headingCenter" style="color:#b11226; font-size:20px;">
    ON ADMISSION TO MEMBERSHIP OF THE LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO</div>
<b>I {{ Auth::user()->name }}</b>
<p style="text-align:justify; ">
    (MENTION YOUR NAME HERE) SOLEMNLY AND SINCERELY PROMISE AND DECLARE THAT I WILL PAY DUE 
    RESPECT AND OBEDIENCE TO THE VICE CHANCELLOR AND OTHER OFFICERS OF THE UNIVERSITY. 
     I WILL FAITHFULLY OBSERVE ALL REGULATIONS WHICH MAY, FROM TIME TO TIME, BE ISSUED BY 
     THEM FOR THE GOOD ORDER AND GOVERNANCE OF THE UNIVERSITY INCLUDING AN ORDER THAT THE
      STUDENT UNION SHOULD MAKE RESTITUTION FOR DAMAGE DONE BY STUDENTS TO PUBLIC PROPERTY. 
      IN ADDITION, I FAITHFULLY PROMISE TO REFRAIN FROM ANY ACT OF VIOLENCE AND OTHER ACTIONS
       CALCULATED TO DISRUPT  THE WORK OF  THE  UNIVERSITY  OR  LIKELY TO BRING THE UNIVERSITY
        INTO DISREPUTE.   I PROMISE NOT TO JOIN A SECRET CULT OR ENGAGE IN EXAMINATION MALPRACTICE
         THROUGHOUT THE PERIOD OF MY STUDENTSHIP IN THE UNIVERSITY.  SO HELP ME GOD
</p>




<p style="text-align:justify; "><b> Name: {{ Auth::user()->name }}  </p>
<p style="text-align:justify; ">Matric No. {{  Auth::user()->matric  }}</b></p>
<p style="text-align:justify; "><b>Phone: {{ GetPhoneNumber() }} </p>
<p style="text-align:justify; "><b>Department: {{ GetDepartment() }} </p>
<p style="text-align:justify; "><b>Faculty: {{ GetFaculty() }} </b></p>
<br/>
 Signature: 	
<br/><br/><br/>

<br/><br/>
Date: 	


</div>
<?php
function GetPhoneNumber()
{
    $d = DB::table('u_g_pre_admission_regs')->where('matricno', Auth::user()->matricno)->first();
    if($d)
    {
        return $d->phone;
    }
    else {
        return 0;
    }
}
function GetDepartment()
{
    $d = DB::table('admission_lists')->where('utme', Auth::user()->utme)->first();
    if($d)
    {
        return $d->programme;
    }
    else {
        return 0;
    }
}
function GetFaculty()
{
  $d = DB::table('admission_lists')->where('utme', Auth::user()->utme)->first();
  $sc = DB::SELECT('CALL GetCandidateFaculty(?)',array($d->departmentcode));
  if($sc)
  {
    
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

