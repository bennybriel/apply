
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
    // $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
              
            
                                <?php if($data): ?>
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Active Users</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name</th>
                                                                        <th>Formnumber</th>
                                                                        <th>Email</th>
                                                                        <th>Apptype</th>
                                                                        <th>LastSeen</th>
                                                                        <th>Action</th>
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name</th>
                                                                        <th>Formnumber</th>
                                                                        <th>Email</th>
                                                                        <th>Apptype</th>
                                                                        <th>LastSeen</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                  
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($data->name); ?> </td>
                                                                            <td><?php echo e($data->formnumber); ?> </td>
                                                                            <td><?php echo e($data->email); ?> </td>
                                                                            <td><?php echo e($data->apptype); ?> </td>
                                                                            <td><?php echo e(Carbon\Carbon::parse($data->last_seen)->diffForHumans()); ?> </td>
                                                                            <td>
                                                                              <?php if(Cache::has('user-is-online-' . $data->id)): ?>
                                                                                    <span class="text-success">Online</span>
                                                                                <?php else: ?>
                                                                                    <span class="text-secondary">Offline</span>
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
        </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/activeUsers.blade.php ENDPATH**/ ?>