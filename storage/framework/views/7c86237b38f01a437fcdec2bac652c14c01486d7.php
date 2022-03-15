
<?php $__env->startSection('content'); ?>
<?php
 
 $stag = DB::table('pgregistrationstages')->where('degree','All')->get();
 $matricno = Auth::user()->matricno;
 $deg = DB::table('pgadmissionlist')->where('formnumber', Auth::user()->formnumber)->first();
 $stag1 = DB::table('pgregistrationstages')->where('degree',$deg->degree)->orderby('stageid','asc')->get();
 //dd($deg);
?>
  <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Post Graduate Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Admission Letter
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">

                                            
                                     <a href="<?php echo e(route('admissionLetterPG')); ?>" class="btn btn-success">
                                           Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Acceptance Form</div>
                                           
                                        </div>
                                        <div class="col-auto">
                                        <a href="<?php echo e(route('pgAcceptanceForm')); ?>" class="btn btn-success">
                                                Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                    <?php if($stag): ?>
                         <?php $__currentLoopData = $stag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($items->stageid == '1'): ?>
                                  <div class="col-xl-3 col-md-6 mb-4">
                                  <div class="card <?php echo e($items->cardcolor); ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   <?php echo e($items->name); ?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                    <span style="color:red">Pending</span>
                                                <?php else: ?>
                                                    <span style="color:green">Completed</span>
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                           
                                            <div class="col-auto">
                                          
                                                  <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                            <a href="<?php echo e(route('PGPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                        <span class="text">Pay &#8358;<?php echo e(number_format($items->amount,2)); ?></span>
                                                           
                                                        </a>
                                                   <?php endif; ?>        
                                                 
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                   
                     <?php endif; ?>
                   <?php if($stag1): ?>
                        <?php $__currentLoopData = $stag1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                             <div class="col-xl-3 col-md-6 mb-4">
                                  <div class="card <?php echo e($items->cardcolor); ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   <?php echo e($items->name); ?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                           
                                                <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                    <span style="color:red">Pending</span>
                                                <?php else: ?>
                                                    <span style="color:green">Completed</span>
                                                <?php endif; ?>
                                            
                                                </div>
                                            </div>
                                           
                                            <div class="col-auto">
                                              <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                   <?php if(RegistrationStatus($matricno,$items->stageid)==true): ?>
                                                           <a href="<?php echo e(route('PGPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                            <span class="text">Pay &#8358;<?php echo e(number_format($items->amount,2)); ?></span>
                                                            <?php else: ?>
                                                            
                                                           <?php endif; ?>
                                                       </a> 
                                              <?php endif; ?>        
                                              
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                               
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                  
                     <?php endif; ?>

                     <?php if($stag): ?>
                         <?php $__currentLoopData = $stag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($items->stageid == '4'): ?>
                                  <div class="col-xl-3 col-md-6 mb-4">
                                  <div class="card <?php echo e($items->cardcolor); ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   <?php echo e($items->name); ?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                    <span style="color:red">Pending</span>
                                                <?php else: ?>
                                                    <span style="color:green">Completed</span>
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                           
                                            <div class="col-auto">
                                          
                                                  <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                          
                                                   <?php endif; ?>        
                                                 
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                   
                     <?php endif; ?>
                    <!-- Content Row -->

                   

                    <!-- Content Row -->
                    <div class="row">

                        

                       
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
<?php $__env->stopSection(); ?>

<?php 
function RegistrationStatus($mat,$sid)
  {
     $stag = DB::table('pgregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',$sid)
                                              ->first();   //DB::SELECT('CALL GetRegistrationStatus(?,?)',array($mat,$sid));
     if($stag)
     {
        if($stag->status=="1")
        {
           return true;
        }
        else
        {
            return false;
        }
     }
     else
     {
        return 0;
     }
  }
?>
<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/admissionPGHome.blade.php ENDPATH**/ ?>