
<?php $__env->startSection('content'); ?>
<?php
   $stgid =1;
   $std =""; $bal=0;
   $stag = DB::table('pdsregistrationstages')->where('stageid',$stgid)->get();
   $matricno = Auth::user()->matricno;
   $stg = DB::table('pdsregistrationstages')->get();
   $sts =$st;
   $paid = GetTotalAmountPaid($matricno);
   $tu = DB::table('pdsregistrationstages')->select('amount')
                                           ->where('payprefix','TU')
                                           ->where('paytype',$sts)
                                           ->first();
   
   $bal = $tu->amount - $paid;
   if($bal > 0 &&  $paid > 0 )
   {
       $bal+=300;
   }
   //dd($bal);
   $pid  = DB::table('pdsregistrationstages')->where('amount',$bal)->first();

?>
  <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Predegree Student Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                               Admission Letter
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">

                                            
                                     <a href="<?php echo e(route('admissionLetterPDS')); ?>" class="btn btn-success">
                                           Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                     
                        <?php if($stag): ?>
                           <?php $__currentLoopData = $stag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                          
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
                                                            <a href="<?php echo e(route('PDSPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                        <span class="text">Pay &#8358;<?php echo e(number_format($items->amount,2)); ?></span>
                                                           
                                                        </a>
                                                   <?php endif; ?>        
                                                 
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>               
                         <?php endif; ?>
                    
                       



                    <?php $__currentLoopData = $stg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if(RegistrationStatus($matricno,$st->stageid)==true): ?>
                                   <?php ++$stgid; 
                                     $stag = DB::table('pdsregistrationstages')->where('stageid',$stgid)->where('istate',$sts)->get();
                                     $stag1= DB::table('pdsregistrationstages')->where('stageid',$stgid)->where('istate','N')->get();
                                   ?>
                                   <?php if($stag): ?>
                                        <?php $__currentLoopData = $stag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card <?php echo e($items->cardcolor); ?> shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            <?php echo e($items->name); ?></div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?php if(RegistrationStatus($matricno,$items->stageid)==false && $items->ispay=='1'): ?>
                                                              
                                                                <span style="color:red">Pending</span>

                                                            <?php else: ?>
                                                               <?php if($bal > 0 && $items->payprefix=='TU'): ?>
                                                                  <span style="color:red">Pending</span>
                                                               <?php else: ?>
                                                                  <span style="color:green">Completed</span>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    
                                                    <div class="col-auto">
                                                         <?php if($items->ispay=='1'): ?>
                                                          
                                                            <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                                        <a href="<?php echo e(route('PDSPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                                           <span class="text">Pay &#8358;<?php echo e(number_format($items->amount,2)); ?></span>
                                                                    
                                                                       </a>
                                                            <?php else: ?>
                                                                  <?php if($bal > 0 && $items->payprefix=='TU'): ?>
                                                                          <a href="<?php echo e(route('PDSPayNow',['id'=>$pid->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                                              <span class="text">Pay &#8358;<?php echo e(number_format($bal,2)); ?></span>
                                                                          </a>
                                                        
                                                                  <?php endif; ?>
                                                            <?php endif; ?>        
                                                        <?php else: ?>
                                                            <span class="text" style="color:red;"><b><?php echo e(Auth::user()->formnumber); ?></b></span>
                                                        <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
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
                                                            <?php if(RegistrationStatus($matricno,$items->stageid)==false && $items->ispay=='1'): ?>
                                                              
                                                                <span style="color:red">Pending</span>

                                                            <?php else: ?>
                                                               <?php if($bal > 0 && $items->payprefix=='TU'): ?>
                                                                  <span style="color:red">Pending</span>
                                                               <?php else: ?>
                                                                  <span style="color:green">Completed</span>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    
                                                    <div class="col-auto">
                                                         <?php if($items->ispay=='1'): ?>
                                                          
                                                            <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                                        <a href="<?php echo e(route('PDSPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                                           <span class="text">Pay &#8358;<?php echo e(number_format($items->amount,2)); ?></span>
                                                                    
                                                                       </a>
                                                            <?php else: ?>
                                                                  <?php if($bal > 0 && $items->payprefix=='TU'): ?>
                                                                          <a href="<?php echo e(route('PDSPayNow',['id'=>$pid->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix])); ?>" class="btn btn-success">
                                                                              <span class="text">Pay &#8358;<?php echo e(number_format($bal,2)); ?></span>
                                                                          </a>
                                                        
                                                                  <?php endif; ?>
                                                            <?php endif; ?>        
                                                        <?php else: ?>
                                                            <span class="text" style="color:red;"><b><?php echo e(Auth::user()->formnumber); ?></b></span>
                                                        <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                   <?php endif; ?>
                            <?php else: ?>
                            
                            <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       

                     
                   

                    <!-- Content Row -->
                    <div class="row">

                        

                       
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
<?php $__env->stopSection(); ?>
<?php 
  function GetTotalAmountPaid($matricno)
  {
    $amt=0;
    //$matricno =Auth::user()->matricno;
    $pid = DB::table('u_g_student_accounts as st')->select(DB::raw("SUM(st.amount) as amounts")) 
                                                    ->join('pdsregistrationstages as pt','pt.productid','=','st.productid')            
                                                    ->where('matricno',$matricno)
                                                    ->where('payprefix', 'TU')
                                                    ->where('ispaid', 1)
                                                    ->get();
    //dd($pid);
   
    
     
     return $pid[0]->amounts;

  }
  function RegistrationStatus($mat,$sid)
  {
     $stag = DB::table('pdsregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',$sid)
                                              ->first();  
                                            
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
  function NextStageStatus($mat,$sid)
  {
     $stag = DB::table('pdsregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',1)
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
<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\apply\resources\views/admissionHomePDS.blade.php ENDPATH**/ ?>