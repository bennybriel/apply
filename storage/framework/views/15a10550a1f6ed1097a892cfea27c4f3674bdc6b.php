
<?php
use Illuminate\Support\Collection;
  $mat =Auth::user()->matricno;  // "07102021689411001914678";
 //dd($scount);
  #Get Programme Applied For
  $dat   = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)',array($mat));
  $result = DB::SELECT('CALL GetPDSResult(?)',array(Auth::user()->formnumber));

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
  font-size:14px;
  margin: 1cm auto;
  border: 1px #D3D3D3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
@page  {
  size: A4;
  margin: 0;
}

  /* ... the rest of the rules ... */
  .content-box 
  {
    column-width: 20px;
   }
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
          <h5>PRE-DEGREE SCIENCE PROGRAMME</h5>
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
                                                       <?php if(Auth::user()->photo): ?>
                                                        <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.Auth::user()->photo)); ?>" alt="Member's Photo" width="80px" height="70px" />
                                                       <?php else: ?>
                                                        <img src="../logRegTemp/img/brand/default.png" style="max-width:70px;height:70px;" />
                                                       <?php endif; ?>
                                                </div></td>
                                            <td width="467">Form Number </td>
                                            <td width="510"><?php echo e(Auth::user()->formnumber); ?></td>
                                           
                                          </tr>
                                          <?php if($dat): ?>
                                          <tr>
                                            <td>Name</td>
                                            <td><?php echo e($dat[0]->names); ?></td>
                                          </tr>
                                        
                                          <tr>
                                            <td>Gender</td>
                                            <td><?php echo e($dat[0]->gender); ?></td>
                                          </tr>
                                          <tr>
                                            <td>Programme</td>
                                            <td width="482"><?php echo e($dat[0]->category1); ?> </td>
                                          </tr>
                                          <?php endif; ?>
                                          <tr>
                                            <td>Application Type </td>
                                            <td>PDS</td>
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
                          
                             </div>
                        
                         <div class="card shadow mb-4">  
                             <div class="card-body"> 
                               
                                <br/>
                             
							     <div class="table-responsive">
              
							    </div>
                                <br/>
                                <?php if($result): ?>
                                   <div align="center"><strong>
                                    YOUR TOTAL SCORE IS:
                                   <h3><?php echo e(number_format($result[0]->score/2,1)); ?>% </h3><br/>
                                <?php endif; ?>
                                </strong></div>
                              
                           </div>
                               
                                <em><label>
                                <div style="margin-right:15px">
							</em>
                        </div>
                      
                  </div>
              </div>
</div>

                                <br/>
 <?php   
 
  ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/pdsResultSlip.blade.php ENDPATH**/ ?>