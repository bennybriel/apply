
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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('DownPassports')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Download Passport Instructions</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                  Download Passports
                                                  </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Download Passports</h1>
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

                                    </div>
                                       <div class="form-group row">
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                             <select class="form-control" name="application" required>
                                                     <option value="">Select Application</option>
                                                      <option value="JUP">JUP</option>
                                                      <option value="PDS">PDS</option>
                                              </select>
                                          </div>
                                       </div>
                               
                                       
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Download</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
        </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/downloadPassport.blade.php ENDPATH**/ ?>