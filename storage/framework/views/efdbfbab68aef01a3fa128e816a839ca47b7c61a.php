
<?php $__env->startSection('content'); ?>
<?php
   $mat = Auth::user()->matricno;
   $y =date("Y");
?>

<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('PGEducationForms')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-5">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Education Data</h1>
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
                                                <input type="text" name="schoolname" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="School Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="town" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Town" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                              <div class="col-sm-12 mb-3 mb-sm-0">
                                                   <select name="country" id="country" class="form-control form-control" required>
                                                        <option value="">Select Country</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <?php $__currentLoopData = $cou; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cou): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                           <option value="<?php echo e($cou->name); ?>"><?php echo e($cou->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    </select>

                                              </div>
                                        </div>
                                      
                                        <div class="form-group row">
                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                 <select name="startyear" id="" class="form-control form-control" required>
                                                    <option value="">Start Year</option>
                                                    <?php
                                                   
                                                       for($k=1900;$k<=$y; $k++)
                                                       {
                                                     ?>
                                                       <option value="<?php  echo $k  ?>"><?php  echo $k  ?></option>
                                                      <?php } ?>
                                                 </select>
                                              </div>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                 <select name="endyear" id="" class="form-control form-control" required>
                                                    <option value="">End Year</option>
                                                    <?php
                                                       for($k=1900;$k<=$y; $k++)
                                                       {
                                                     ?>
                                                       <option value="<?php  echo $k  ?>"><?php  echo $k  ?></option>
                                                      <?php } ?>
                                                 </select>
                                              </div>
                                        </div>
                                         
                                       
                                       
                                     
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Add Record</button>

                                            </div>
                                          </div>
                                      


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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">School Details</h6>
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
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name(s) of School(s)</th>
                                                                        <th>Town</th>
                                                                        <th>Country</th>
                                                                        <th>Start Year</th>
                                                                        <th>End Year</th>
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
                                                                            <td><?php echo e($data->schoolname); ?></td>
                                                                            <td><?php echo e($data->town); ?></td>
                                                                            <td><?php echo e($data->country); ?></td>
                                                                            <td><?php echo e($data->startyear); ?></td>
                                                                            <td><?php echo e($data->endyear); ?></td>  
                                                                            <td><a href="<?php echo e(route('DeleteEducation', $data->id)); ?>" class="btn btn-danger">Delete</a></td>
      
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             <?php endif; ?>

                                            <?php if($data): ?>
                                                <div class="form-group">
                                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                                    <a href="<?php echo e(route('pgqualificationPage')); ?>" class="btn btn-primary">
                                                         Proceed To Qualification
                                                     </a>

                                                </div>
                                           <?php endif; ?>

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/pgeducationPage.blade.php ENDPATH**/ ?>