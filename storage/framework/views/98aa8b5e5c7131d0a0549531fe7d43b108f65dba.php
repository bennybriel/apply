
<?php $__env->startSection('content'); ?>

   <!-- Content Row -->
<?php

  use Carbon\Carbon;
  $today = date("Y-m-d");
  $amt=0;
  $ses = Auth::user()->activesession;
  $matricno = Auth::user()->matricno;
  $usr =   Auth::user()->usertype;
  $ispd = Auth::user()->ispaid;
  $isadm = Auth::user()->isadmitted;
  $ismedical = Auth::user()->ismedical;
  $apptype = Auth::user()->apptype;
  $accpt =Auth::user()->isacceptance;
  $istuition =Auth::user()->istuition;
  //Fetch Data
  
  $amount= 0;$amount1=0; $prod="";
  $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
  
  $data   = DB::SELECT('CALL FetchFailedPayments(?)', array($matricno));
  ///dd($id);
  $p2 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($id));
 
?>
   <!-- Content Row -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payment Dashboard</h1>
    
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Hello <i
            class="fas fa-info fa-sm text-white-50"></i> <?php echo e(Auth::user()->name); ?> <?php echo date("l, dS-M-Y") ?></a>
</div>

<!-- Content Row -->
<?php if(Session::has('error')): ?>
                                <div class="alert alert-danger">
                                                        <?php echo e(Session::get('error')); ?>

                                                        <?php
                                                            Session::forget('error');
                                                        ?>
                                                        </div>
                                                   <?php endif; ?>
                                                        <?php if(Session::has('success')): ?>
                                                <div class="alert alert-success">
                                                        <?php echo e(Session::get('success')); ?>

                                                        <?php
                                                            Session::forget('success');
                                                        ?>

                                                        </div>
                                                        <?php
                                                           // $memberID = session('memberID');
                                                        ?>
                               <?php endif; ?>


   <?php if($usr=="Student"): ?>                           
       
   <div class="col-lg-12">
      <div class="p-3">
   
         <?php if($data): ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                <div class="alert alert-danger">
                        Payment Transaction Failed
                 </div>
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Failed Payment Record</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Session</th>
                                    <th>Amount</th>                        
                                    <th>PaymentType</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                            </thead>
                             
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($data->session); ?></td>
                                                                            <td>&#8358;<?php echo e(number_format($data->amount,2)); ?></td>
                                                                          
                                                                            <td><?php echo e($data->description); ?></td>
                                                                            <td><?php echo e(Carbon::parse($data->created_at)->format('d-m-Y,h:m:s A')); ?></td>
                                                                            <td> 
                                                                              
                                                                              <?php if($data->response): ?>
                                                                              
                                                                                <span style="color:red"><?php echo e($data->response); ?></span>
                                                                              <?php else: ?>
                                                                              <span style="color:red">Pending</span>
                                                                              <?php endif; ?>
                                                                            </td> 
                                                                            <td> 
                                                                              <a href="<?php echo e(route('QueryTransaction', $data->transactionID)); ?>" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                             </td>

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                             <h6 style="color:#da251d">Please Click Pay Now, Below To Try Again  </h6>
                                                        </div>
                                                    </div>
                                                </div>
            <?php else: ?>
                 <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><strong><?php if($p2): ?> <?php echo e($p2[0]->name); ?> <?php endif; ?></strong></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                         <?php if($id  && $pname): ?>
                                            <div class="col-auto">
                                                <h7>&#8358;<?php echo e(number_format($p2[0]->amount,2)); ?> </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="<?php echo e(route('PayingNow',['id'=>$id,'prod'=>$pname])); ?>"
                                                                                class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Pay Now</span>
                                                </a>
                                                <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                                </div>
                                            <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            <?php endif; ?>

                                        </div>
                                    
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
                                             

         <?php endif; ?>
 
      </div>
    </div>
<?php endif; ?>







<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/paymentBalance.blade.php ENDPATH**/ ?>