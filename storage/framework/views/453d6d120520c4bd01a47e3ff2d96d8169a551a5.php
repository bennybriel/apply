
<?php
   use Carbon\Carbon;
   $apt = Auth::user()->apptype;
   $ses = Auth::user()->activesession;
   $mat = Auth::user()->matricno;

   $result = DB::SELECT('CALL GetStudentStateIdentity(?)',array($mat));
   //dd($result);
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
          <h3 align="center" style="color:#da251d">  
            LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO</h3>
            <h4 align="center" style="color:#000">  
                STATE IDENTIFICATION FORM
            </h4>
          </div>
    </div>
    <div class="col-md-4"></div>
</div>


  <div class="w3-container">

      
     <?php if($result): ?>
	   <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.$result[0]->photo)); ?>" alt="Member's Photo" width="80" height="80" />             		   </td>
      
               <div style="overflow-x:auto; ">
                <table width="1000" border="0" align="center">
               <thead>
                 
                 <tr>
                    <td width="363" class="noBorder" >Name</td>
                    <td width="250" class="noBorder1"><?php echo e($result[0]->stdname); ?></td>
                    <td width="400" rowspan="8" class="noBorder1">
					
				         
					
					</td>
                 </tr>
                  <tr>
                    <td class="noBorder">Name of Parent</td>
                    <td class="noBorder1"><?php echo e($result[0]->patname); ?></td>
                 </tr>
                 <tr>
                   <td class="noBorder">
                   Address
                   </Address></td>
                    <td class="noBorder1"><?php echo e($result[0]->address); ?></td>
                 </tr>

                 <tr>
                   <td class="noBorder">State of Origin </td>
                    <td class="noBorder1"><?php echo e($result[0]->state); ?></td>
                 </tr>

                 <tr>
                   <td class="noBorder">Local Govt </td>
                    <td class="noBorder1"> <?php echo e($result[0]->lga); ?> </td>
                 </tr>

                 <tr>
                   <td class="noBorder">Name of Local Government Chairman</td>
                    <td class="noBorder1">.</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Name of Authorising Officer </td>
                    <td class="noBorder1">.....................</td>
                 </tr>
                
                 <tr>
                   <td class="noBorder">Signature of Authorising Officer (Duly Stamped)</td>
                    <td class="noBorder1">.........................</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Date</td>
                    <td class="noBorder1"> <?php echo e(date("d-m-Y")); ?></td>
                 </tr>
                 <hr/>
                
                 
                 </thead>
          </table>
        
            
       </div>
    <?php endif; ?>

  
                                                      
</div>
    </div>


                                     
</div>


</html>

<?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/stateIdentity.blade.php ENDPATH**/ ?>