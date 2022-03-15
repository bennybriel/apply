
<?php $__env->startSection('content'); ?>

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
  $amt=0;
  $matricno = $data[0]->matricno;



?>
   <!-- Content Row -->

      <?php if($data): ?>
           <div class="card shadow mb-4">
                <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Transaction History</h6>
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
                                                                            
                                                                               <?php if($data->response=="Approved Successful"): ?>
                                                                                  <span style="color:green"><?php echo e($data->response); ?></span>
                                                                                <?php else: ?>
                                                                                  <span style="color:red"><?php echo e($data->response); ?></span>
                                                                                <?php endif; ?>
                                                                            </td> 
                                                                            <td> 
                                                                                <?php if($data->response=="Approved Successful" || $data->response=="Transaction Successful"): ?>
                                                                                  <a href="<?php echo e(route('ReceiptSlip', $data->transactionID)); ?>" style="background:#c0a062;color:#FFF" class="btn">Get Receipt</a>
                                                                                <?php else: ?>
                                                                                <a href="<?php echo e(route('QueryTransactAdmin', $data->transactionID)); ?>" style="background:#da251d;color:white" class="btn">Check Status</a>
                                                                       
                                                                                <?php endif; ?>
                                                                             </td>

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>


      <?php endif; ?>






<div class="row">

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/transactionList.blade.php ENDPATH**/ ?>