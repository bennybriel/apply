
<?php $__env->startSection('content'); ?>
<?php
   $matricno = Auth::user()->matricno;
   $y =date("Y");
   //$matricno ="PDS20219123614";
   $counter = DB::SELECT('CALL 	CounterPGEmailSentList(?)', array($matricno));
   //dd($counter);
?>

<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('PGSendReferences')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-5">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Reference Information</h1>
                                    </div>
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

                                                <?php endif; ?>

                                      
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            </div>
                                        </div>
                                                                             
                                     
                                        <?php if($counter[0]->num < 3): ?>
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Send Email</button>

                                            </div>
                                          </div>
                                       <?php endif; ?>


                                        <div class="form-group">
                                           <div class="col-sm-12 mb-3 mb-sm-0">
                                            <!-- DataTales Example -->


                                            </div>
                                        </div>




                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        <?php if($data): ?>
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
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Email</th>
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
                                                                            <td><?php echo e($data->email); ?></td>
                                                                            <td><a href="<?php echo e(route('DeleteReferenceInfo', $data->id)); ?>" class="btn btn-danger">Delete</a></td>
      
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             <?php endif; ?>

                                             <?php if($counter[0]->num == 3): ?>
                                                  <div class="form-group">
                                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                                         <a href="<?php echo e(route('registrationConfrimationPage')); ?>" class="btn btn-primary">
                                                          Submit To Complete Application  
                                                     </a>
                                                     </div>
                                                </div>
                                                <?php endif; ?>

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/pgsendreferencePage.blade.php ENDPATH**/ ?>