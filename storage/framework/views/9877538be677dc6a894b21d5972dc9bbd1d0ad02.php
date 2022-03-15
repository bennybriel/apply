
<?php
   use Carbon\Carbon;
   $formnumber = Auth::user()->formnumber;
   $pro =DB::table('pgadmissionlist')->where('formnumber',$formnumber)->first();  // DB::SELECT('CALL GetAdmissionInfo(?)',array($utme));
   $det = DB::table('u_g_pre_admission_regs')->where('matricno',Auth::user()->matricno)->first();
   $net = DB::table('u_g_parent_infos')->where('matricno', Auth::user()->matricno)->first();
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
             <b>THE POSTGRADUATE SCHOOL</b>
            <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY</b>  
<P align="center" style="font-size:20px; font-family:'ARIAL'">
               <img src="../logRegTemp/img/brand/logo_admission.png" width="90px" height="110px"/><br/> 
               <?php echo e(Auth::user()->activesession); ?> ACADEMIC SESSION<br/> 
     </P>     ACCEPTANCE FORM
      </div>
    </div>
    <div class="col-md-4"></div>
</div>

<div style="overflow-x:auto; ">
  <table width="698" border="0" align="center">
    <thead>
      <tr>
        <td width="132" class="noBorder" >Name in Full</td>
        <td width="369" class="noBorder1"><?php echo e(Auth::user()->name); ?></td>
      </tr>
      <tr>
        <td class="noBorder">Department</td>
        <td class="noBorder1"><?php echo e($pro->programme); ?></td>
      </tr>
      <tr>
        <td class="noBorder">Faculty</td>
        <td class="noBorder1"><?php echo e(GetFaculty($pro->programme)); ?></td>
      </tr>
      <tr>
        <td class="noBorder">Mode of Study </td>
        <td class="noBorder1"> Full Time</td>
      </tr>  
    <?php if($pro): ?>
  <tr>
    <td class="noBorder">Degree in View </td>
    <td class="noBorder1"><?php echo e($pro->degree); ?></td>
  </tr>
  <tr>
    <td class="noBorder">Area of Specialization </td>
    <td class="noBorder1"><?php echo e($pro->course); ?></td>
  </tr>
    <?php endif; ?>
    <?php if($det): ?>
  <tr>
    <td class="noBorder">Address </td>
    <td class="noBorder1"><?php echo e($det->address); ?></td>
  </tr>
  <tr>
    <td class="noBorder">State of Origin </td>
    <td class="noBorder1"><?php echo e($det->state); ?></td>
  </tr>
  <tr>
    <td class="noBorder">Nationality </td>
    <td class="noBorder1">Nigeria</td>
  </tr>
  <tr>
    <td class="noBorder">Email</td>
    <td class="noBorder1"><?php echo e($det->email); ?></td>
  </tr>
    <?php endif; ?>
    <?php if($net): ?>
    <tr>
      <td class="noBorder">Name and Address of Next of Kin</td>
      <td class="noBorder1"><?php echo e($net->surname); ?> <?php echo e($net->othername); ?>, <br/>
            <?php echo e($net->address); ?></td>
    </tr>
    <tr>
    <td colspan="2" class="noBorder">Declaration of Acceptance/Rejection of Offer of Admission<br/>

                 <em>(delete whichever is not applicable)</em>
    </td>
             
    </tr>
    <?php endif; ?>
  
  </table>
  <table width="831" align="center">
                        <thead>
                            
                            <tr>
                                <td width="373" class="noBorder1">
                                <strong>Signature________________________</strong> <br/>
                                </td>
                                <td width="446" class="noBorder1">
                               
                                
                                    
                                    <br/>
                                    <strong>Date________________________</strong> <br/>
                                    
                                </p>
                                </td>
                            </tr>
  </table>
  I accept/reject the offer of admission into the  <b> <?php if($pro): ?> <?php echo e($pro->degree); ?> </b> Program for the  <b><?php echo e(Auth::user()->activesession); ?> </b> Session,
   in the Department of <b><?php echo e($pro->programme); ?> <?php endif; ?></b>
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
?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/pgAcceptanceForm.blade.php ENDPATH**/ ?>