
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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Download Payment</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Acceptance</th>
                                                                        <th>Medical</th>
                                                                        <th>Tuition</th>
                                                                       
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                       <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Acceptance</th>
                                                                        <th>Medical</th>
                                                                        <th>Tuition</th>
                                                                      

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <?php 
                                                                               $ses = str_replace("/","",$data->activesession);
                                                                               
                                                                             ?>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td>JUPEB</td>
                                                                            <td><?php echo e($data->activesession); ?> </td>  
                                                                            <td><a href="<?php echo e(route('DownloadJupebPayment', ['ses'=>$ses,'pat'=>'Acc'])); ?>" class="btn btn-primary">Download</a> </td>  
                                                                            <td><a href="<?php echo e(route('DownloadJupebPayment', ['ses'=>$ses,'pat'=>'Med'])); ?>" class="btn btn-success">Download</a></td>  
                                                                            <td><a href="<?php echo e(route('DownloadJupebPayment', ['ses'=>$ses,'pat'=>'Tut'])); ?>" class="btn" style="background:#c0a062;color:#FFF">Download</a> </td>  
                                                                            
                                                                         
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


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/downloadJupebPayment.blade.php ENDPATH**/ ?>