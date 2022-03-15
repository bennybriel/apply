
<?php $__env->startSection('content'); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
              
                    <div class="row">
              
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        <?php if($data): ?>
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Document Screening Candidate Information</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                       
                                                                        <th>UTME No.</th>
                                                                        <th>Name</th>
                                                                        <th>Programme</th>
                                                                        <th>Session</th>
                                                                     </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME No.</th>
                                                                        <th>Name</th>
                                                                        <th>Programme</th>
                                                                        <th>Session</th>
                                                                      

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            
                                                                            <td><?php echo e($data->utme); ?></td>
                                                                            <td><?php echo e($data->name); ?></td>
                                                                            <td><?php echo e($data->programme); ?></td>
                                                                            <td><?php echo e($data->session); ?></td>
                                                                          
                                                                        
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             <?php endif; ?>

                                             

                                </div>

                             </div>


                        </div>
                    </div>
           
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/documentScreeningList.blade.php ENDPATH**/ ?>