
<?php
   use Carbon\Carbon;
   $apt = Auth::user()->apptype;
   $matricno = Auth::user()->matricno;
   $olevel = DB::SELECT('CALL FetchQualificationRecordByMatricNo(?)',array($matricno));
   $edu = DB::SELECT('CALL GetEducationInfoByMatricNo(?)',array($matricno));
   $appoint = DB::SELECT('CALL 	GetAppointmentsByMatricNo(?)',array($matricno));
   $pub  = DB::SELECT('CALL GetPGPublicationByMatricNo(?)',array($matricno));
   $oth  = DB::SELECT('CALL 	GetPGOtherInfoByMatricNo(?)',array($matricno));
   $ref  = DB::SELECT('CALL 	GetReferenceByMatricNo(?)',array($matricno)); 
   //dd($ref);
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

               

                <h2 align="center" style="color:#da251d"> Post Graduate Registration Information</h2>
                <?php if($data): ?>
               <div style="overflow-x:auto; ">
                <table width="638" border="0" align="center">
               <thead>
                 <tr>
                   <td width="100" rowspan="9" class="noBorder" >
				        <?php
                         $pic = $data[0]->photo;
                   //dd($pic);
                ?>
					             <img src="<?php echo e(asset('public/Passports/'.Auth::user()->photo)); ?>" style="max-width:130px;height:150px;" /> 			
            
             		   </td>
                    <td width="132" class="noBorder" >Student Name</td>
                    <td width="300" class="noBorder1"><?php echo e(Auth::user()->name); ?></td>
                 </tr>
                  <tr>
                    <td class="noBorder">Form Number</td>
                    <td class="noBorder1"><?php echo e(Auth::user()->formnumber); ?></td>
                 </tr>
                
                
                 <tr>
                        <td class="noBorder">App.No  </td>
                        <td class="noBorder1"><?php echo e($data[0]->appnumber); ?></td>
                    </tr>
                  <tr>
                      <td class="noBorder">Programme  </td>
                      <td class="noBorder1"><?php echo e(GetPGProgramme($data[0]->category1)); ?></td>
                  </tr>
           
                 <tr>
                   <td class="noBorder">Session </td>
                    <td class="noBorder1">
                    <?php echo e($data[0]->session); ?>

                    </td>
                 </tr>

                 <tr>
                   <td class="noBorder">Email</td>
                    <td class="noBorder1"><?php echo e($data[0]->email); ?></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Phone</td>
                    <td class="noBorder1"><?php echo e($data[0]->phone); ?></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Date of Birth</td>
                                   
                   <td class="noBorder1"><?php echo e(Carbon::parse($data[0]->dob)->format('d-m-Y')); ?></td>
                 </tr> 

                 <tr>
                   <td class="noBorder">State of Origin</td>
                    <td class="noBorder1"><?php echo e($data[0]->state); ?></td>
                 </tr>
                
                
                 </thead>
          </table>
          <h4 style="color:red"><strong>Sponsorship Information</strong></h4>
          <table width="698" border="0" align="center">
               <thead>
                    <tr>
                        <td class="noBorder">Sponsor's Name</td>
                          <td class="noBorder1"><?php echo e($data[0]->sname); ?></td>
                      </tr>
                 
                      <tr>
                        <td class="noBorder">Sponsor's Phone</td>
                          <td class="noBorder1"><?php echo e($data[0]->sphone); ?></td>
                      </tr>
                      <tr>
                        <td class="noBorder">Sponsor's Email</td>
                          <td class="noBorder1"> <?php echo e($data[0]->semail); ?></td>
                      </tr>
                      <tr>
                        <td class="noBorder">Sponsor's Address</td>
                          <td class="noBorder1"> <?php echo e($data[0]->saddress); ?></td>
                      </tr>
                
       </div>

   
       </thead>
          </table>


          <h4 style="color:red"><strong>Parent's Information</strong></h4>
          <table width="698" border="0" align="center">
               <thead>
                    <tr>
                        <td class="noBorder">Parent's Name</td>
                          <td class="noBorder1"><?php echo e($data[0]->pname); ?></td>
                      </tr>
                 
                      <tr>
                        <td class="noBorder">Parent's Phone</td>
                          <td class="noBorder1"><?php echo e($data[0]->pphone); ?></td>
                      </tr>
                      <tr>
                        <td class="noBorder">Parent's Email</td>
                          <td class="noBorder1"> <?php echo e($data[0]->pemail); ?></td>
                      </tr>
                      <tr>
                        <td class="noBorder">Parent's Address</td>
                          <td class="noBorder1"> <?php echo e($data[0]->paddress); ?></td>
                      </tr>
                
       </div>

   
       </thead>
          </table>
         
        
              
       </div>

   
       </thead>
          </table>
          <h4 style="color:red"><strong>OLevel Information</strong></h4>
                           <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        <?php if($olevel): ?>
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Olevel Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Exam No.</th>
                                                                   

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                         <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Exam No.</th>
                                                                        <th>Grade</th>
                                                                       

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $olevel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $olevel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($olevel->subject); ?></td>
                                                                            <td><?php echo e($olevel->grade); ?></td>
                                                                            <td><?php echo e($olevel->examnumber); ?></td>

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                          
                                          
                                          </div>
                                        <?php endif; ?>

                                </div>

                             </div>
                                <h4 style="color:red"><strong>Education Information</strong></h4>
                              <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        <?php if($edu): ?>
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Education Info</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name(s) of School(s)</th>
                                                                        <th>Town</th>
                                                                        <th>Country</th>
                                                                        <th>Start Year</th>
                                                                        <th>End Year</th>
                                                                      

                                                                    </tr>
                                                                </thead>
                                                               
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $edu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($edu->schoolname); ?></td>
                                                                            <td><?php echo e($edu->town); ?></td>
                                                                            <td><?php echo e($edu->country); ?></td>
                                                                            <td><?php echo e($edu->startyear); ?></td>
                                                                            <td><?php echo e($edu->endyear); ?></td>  
                                                              
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>


                                                </div>
                                          
                                          
                                          </div>
                                        <?php endif; ?>

                                </div>
                                <?php if($appoint): ?>
                                  <h4 style="color:red"><strong>Appointment Information</strong></h4>
                                 <div class="col-lg-8">
                                   <div class="p-5">
                                       <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                       </div>



                                     
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Appointment Info</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Employer</th>
                                                                        <th>Post</th>
                                                                        <th>Start Year</th>
                                                                        <th>End Year</th>
                                                                     
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $appoint; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($appoint->employer); ?></td>
                                                                            <td><?php echo e($appoint->post); ?></td>
                                                                            <td><?php echo e($appoint->startyear); ?></td>
                                                                            <td><?php echo e($appoint->endyear); ?></td>  
                                                                     
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>


                                                </div>
                                          
                                          
                                          </div>
                                       
                                   </div>
                                <?php endif; ?>

                             </div>
                                
                      <?php if($pub): ?>   
                             <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Publication</h1>
                                    </div>



                                       
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Publication Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Publication</th>
                                                                        <th>Title</th>
                                                                        <th>Year</th>
                                                                      

                                                                    </tr>
                                                                </thead>
                                                             
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $pub; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($pub->publication); ?></td>
                                                                            <td><?php echo e($pub->title); ?></td>
                                                                            <td><?php echo e($pub->year); ?></td>
                                                       
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                         

                                </div>

                             </div>
                         <?php endif; ?>

                         <?php if($oth): ?>
                               <div class="col-lg-7">
                                  <div class="p-5">
                                      <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Other Information</h1>
                                      </div>



                                    
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Other Info Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Description</th>
                                                                        <th>Response</th>
                                                                        <th>Year</th>
                                                                   

                                                                    </tr>
                                                                </thead>
                                                              
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $oth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($oth->description); ?></td>
                                                                            <td><?php echo e($oth->content); ?></td>
                                                                            <td><?php echo e($oth->year); ?></td>
                                                                         
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                          
                                               

                                </div>

                             </div>

                              <?php endif; ?>
                       <?php if($ref): ?>
                              <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                    
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Reference Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Email</th>
                                                                    

                                                                    </tr>
                                                                </thead>
                                                               
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $ref; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($ref->remail); ?></td>
                                                                    
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            

                                           

                                </div>

                                </div>  
                               <?php endif; ?>

                             </div>

    <?php endif; ?>
  
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
  } ?><?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/printPGData.blade.php ENDPATH**/ ?>