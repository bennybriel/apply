
<?php $__env->startSection('content'); ?>
<?php
   $mat = $res[0]->matricno;
   $y =date("Y");
?>
 <div class="row">
         <div class="col-5">
         </div>
         <div class="col-7">
            <img src="../logRegTemp/img/brand/logo.png" style="max-width:100%;height:auto;"/>
         </div>

      </div> 
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('PGReferences')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                            <label></label>
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">  <?php if($res): ?> <?php echo e(strtoupper($res[0]->surname)); ?>  <?php echo e($res[0]->firstname); ?><?php endif; ?> Reference Information</h1>
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
                                                <input type="hidden" value="<?php echo e($guid); ?>" name="guid">
                                                <input type="hidden" value="<?php echo e($res[0]->myemail); ?>" name="myemail">
                                                <input type="hidden" value="<?php echo e($res[0]->matricno); ?>" name="matricno">
                                       <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                 <select name="title" id="title" class="form-control form-control" required>
                                                        <option value="">Select Title</option>
                                                    
                                                        <?php $__currentLoopData = $tit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                           <option value="<?php echo e($tit->name); ?>"><?php echo e($tit->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    </select>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="name" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Full Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="email" name="email"  value="<?php echo e($res[0]->email); ?>" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" readonly>
                                            </div>
                                        </div>
                                                                             
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="rank" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Position" required>
                                              </div>
                                             
                                        </div>
                                         
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                                <textarea name="remark" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Remark/Comments" required></textarea>
                                              </div>
                                             
                                        </div>
                                       
                                     
                                       
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Save</button>

                                            </div>
                                          </div>
                                      


                                        <div class="form-group">
                                           <div class="col-sm-12 mb-3 mb-sm-0">
                                            <!-- DataTales Example -->


                                            </div>
                                        </div>




                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>

 
                                    <h4 style="color:#000000">Important information</h2>
                  <p style=" text-align:justify">You are to log in with your Matric Number and password. Once you are logged in, pay close attention to any information appearing in a green box.
           Click here to create a portal account if you are a fresh student. However, if you are not a fresh student, and you do not have a portal account, visit the Admission Office first for profiling and then click here..</p>
                 

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appfront1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/pgreferencePage.blade.php ENDPATH**/ ?>