
<?php
use Illuminate\Support\Collection;
  $mat = Auth::user()->matricno;
  $utme = Auth::user()->utme;
  $utme ="10801411HC";
 
  $rcounter=0;
  $req = DB::SELECT('CALL GetRequiredSubjects(?)',array($utme));
  $rcounter = 5 - count($req);
  $dat   = DB::SELECT('CALL GetUTMEInformation(?)',array($utme));
  $result = DB::SELECT('CALL GetPOSTUtmeResult(?)',array($utme));
 // dd($result);
  $opt = DB::SELECT('CALL GetOptionalSubjects(?,?)',array($utme,$rcounter));
 // $qr = Auth::user()->name.'-'.$mat.'-' .  Auth::user()->utme;
  $info ='Name: '.Auth::user()->name .' UTME No.'.Auth::user()->utme. ' Programme ='.$dat[0]->programme .' UTME SCORE:'.$dat[0]->totalscore; // (round(SumTotalSubjectGrade($utme)/3,1) + round($uinfo[0]->totalscore/8,1) + $presult[0]->score);  
  $q = QrCode::size(150)->backgroundColor(255,255,1)->generate($info);
   $total =0;
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
    <div class="col-md-4">
    </div>
    <div class="col-md-12">
       <div align="center">
          <img src="../logRegTemp/img/brand/logo_admission.png" width="80" height="81"/>
          <h2>Ladoke Akintola University of Technology</h2>
          <h5>2021/2022 POST UTME SCREENING RESULT SLIP</h5>
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
                                     <table width="48%" align="center" cellpadding="0" cellspacing="0" class="noBorder1" id="dataTable">
                                                       
                                          <tr>
                                            <td width="90" rowspan="5"><div align="center"><span style="text-align:justify"><img src="../logRegTemp/img/brand/logo_admission.png" width="80" height="120"/></span></div></td>
                                            <td width="108">UTME No. </td>
                                            <td width="206"><?php echo e($utme); ?></td>
                                            <td width="120" rowspan="5"><?php echo e($q); ?></td>
                                          </tr>
                                          <tr>
                                            <td>Name:</td>
                                            <td><?php echo e(Auth::user()->name); ?></td>
                                          </tr>
                                          <tr>
                                            <td height="22">Gender:</td>
                                            <td><?php echo e($dat[0]->gender); ?></td>
                                          </tr>
                                          <tr>
                                            <td>Programme</td>
                                            <td><?php echo e($dat[0]->programme); ?></td>
                                          </tr>
                                          <tr>
                                            <td>Application Type </td>
                                            <td>UTME</td>
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

                                             <?php if($req): ?>
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                         <h6 class="m-0 font-weight-bold" style="color:#da251d">OLevel Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                       
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                      
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Score</th>
                                                                    

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                       
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Score</th>
                                                                       
                                                                    
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    // dd($item[$counter][0]->grade);
                                                                    ?>
                                                                    <?php $__currentLoopData = $req; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                      <?php
                                                                        $total+=$data->score
                                                                      ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                           
                                                                            <td><?php echo e($data->subject); ?></td>
                                                                            <td><?php echo e($data->grade); ?></td>
                                                                            <td><?php echo e($data->score); ?></td>
                                                                         

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php $__currentLoopData = $opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        $total+=$data->score
                                                                      ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                           
                                                                            <td><?php echo e($data->subject); ?></td>
                                                                            <td><?php echo e($data->grade); ?></td>
                                                                            <td><?php echo e($data->score); ?></td>
                                                                         

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                 
                                                                </tbody>  
                                                              
                                                      </table>
                                                          
                                                    </div>
                                  </div>
                                             <?php endif; ?>

                             </div>
                        
                         <div class="card shadow mb-4">  
                             <div class="card-body"> 
                               
                                <br/>
                             
							     <div class="table-responsive">
                                <table width="81%" cellspacing="0">
                                  <tr>
                                    <td width="219"><strong>Total:</strong></td>
                                    <td width="656"><strong>
                                      <label><?php echo e($total); ?> /2 = <?php echo e(number_format($total/2,1)); ?></label>
                                    </strong></td>
                                  </tr>
                                  <tr>
                                    <td><strong>UTME Score: </strong></td>
                                    <td><strong>
                                      <?php if($data): ?>
                                      <label> <?php echo e($dat[0]->totalscore); ?> / 400 * 50 = <?php echo e(number_format(((($dat[0]->totalscore)/400) * 50),1)); ?></label>
                                      <?php endif; ?>
                                    </strong> </td>
                                  </tr>
                                  <tr>
                                    <td><strong>
                                      <label>Post UTME Score:</label>
                                    </strong></td>
                                    <td><strong>
                                      <label></label>
                                      <?php if($result): ?>
                                      <label> <?php echo e($result[0]->score); ?>/35 </label>
                                      <?php endif; ?>
</strong> </td>           
                                  </tr>
                               </table>
							    </div>
                                <br/>
                                <div align="center"><strong>Aggregate Score: <?php echo e(number_format($total/2,1)); ?> + <?php echo e(number_format(((($dat[0]->totalscore)/400) * 50),1)); ?> + <?php echo e($result[0]->score); ?> =
                                <?php echo e(number_format($total/2,1)  +  number_format(((($dat[0]->totalscore)/400) * 50),1)  + $result[0]->score); ?><br/>
                                  
                                </strong></div>
                              
                           </div>
                                <br/>
                                <em><label>
                                <div align="center">
								Please note that this result does not guarantee automatic admission to the University
Admission to LAUTECH is free. Do not engage in frivolous transaction with anybody.</em>
                        </div>
                      
                  </div>
              </div>
    <?php /**PATH C:\WebApps\ApplyApp\resources\views/postUTMEResult.blade.php ENDPATH**/ ?>