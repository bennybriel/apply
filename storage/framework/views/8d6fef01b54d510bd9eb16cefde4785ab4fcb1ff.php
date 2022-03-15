
<?php
use Carbon\Carbon;
//use DateTime;
//$utme ="10555062HG";
$formnumber = Auth::user()->formnumber;
$pro =DB::table('pgadmissionlist')->where('formnumber',$formnumber)->first();  // DB::SELECT('CALL GetAdmissionInfo(?)',array($utme));
//$q = QrCode::size(100)->backgroundColor(255,255,1)->generate($info);
$base64 ="";
$mat ="693323281306324";
$mats ="693323281306324.jpeg";
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
<P align="center" style="color:#b11226; font-size:22px; font-family:'ARIAL'">
            <img src="../logRegTemp/img/brand/logo_admission.png" width="40px" height="50px"/><br/> 
            STATE IDENTIFICATION FORM
  </P>     
   </div>
 </div>
 <div class="col-md-4"></div>
</div>
        <table style="font-size:13px;">
            <thead>
                <tr>
                 <td width="150" class="noBorder1">
              
              </td>
                 <td width="150" class="noBorder1">
                  
                     
                    

              </td>

                 <td width="150" class="noBorder1">
                   
                      
                    

              </td>
              </tr>

              
               <tr>
                 <td width="200" class="noBorder1">

               
                  
                 </td>
                 <td width="150" class="noBorder1">
                      
                 </td>
                 <td width="150" class="noBorder1">
                
                 </td>
              </tr>
             
              <tr>
                 <td width="150" class="noBorder1">
                  
                </td>
                 <td width="200" class="noBorder1">
                      
                 </div></td>
                 <td width="150" class="noBorder1">
                     <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.Auth::user()->photo)); ?>" alt="Member's Photo" width="80px" height="70px" />	
         
                 </div></td>
              </tr> 

        
</table>

       
<div class="w3-container"> 

<p style="text-align:justify;font-size:18px; "> 
    Name of Student: <?php echo e(Auth::user()->name); ?>

</p>
<p style="text-align:justify;font-size:18px; "> 
    Name of Parents/Guardian:<?php echo e(strtoupper(GetInfo()->surname)); ?>  <?php echo e(strtoupper(GetInfo()->othername)); ?>

</p>
<p style="text-align:justify;font-size:18px; "> 
    Local Government Area Address: .......................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    .................................................................................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    Name of Local Government:<?php echo e(strtoupper(GetInfo()->lga)); ?>

</p>
<p style="text-align:justify;font-size:18px; "> 
    Address of the Local Govt:....................................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    ..................................................................................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    Name of the Secretary: ..........................................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    Secretary Signature:...............................................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    Name of the Chairman:..........................................................................................................
</p>
<p style="text-align:justify;font-size:18px; "> 
    Chairman's Signature:...........................................................................................................
</p>
<?php

function GetInfo()
{
   
  $pa = DB::table('u_g_parent_infos as pa')->select('pa.surname','pa.othername','lga')
                 ->join('u_g_pre_admission_regs as rg','rg.matricno','=','pa.matricno')
                 ->where('rg.matricno',Auth::user()->matricno)->first();//
  if($pa)
  {
      return $pa;   //strtoupper($pa->surname. ' '.$pa->othername);
  }
  else {
       return "No Record";
  }
}
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
?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/stateIdentityUGD.blade.php ENDPATH**/ ?>