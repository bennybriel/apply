
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
    // $data =  session('res');

?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<script src="js/jquery-3.3.1.js"></script>


<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('ChangePassports')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Change Passport</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                    <?php if($data): ?>   
				                                       <img class="nav-user-photo" src="<?php echo e(asset('Passports/'.$data[0]->photo)); ?>" alt="image" width="183" height="200px" />		
                                                       <br/>
                                                       <label><?php echo e($data[0]->names); ?></label>
                                                       <br/>
                                                       <label><?php echo e($data[0]->utme); ?></label>
                                                       <br/>
                                                       <label><?php echo e($data[0]->category1); ?></label>
                                                   <?php endif; ?>
                                                  </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Change Passport</h1>
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
                                        <?php if($data): ?>
                                           <input type="hidden" name="matricno" value="<?php echo e($data[0]->matricno); ?>"/>
                                           <input type="hidden" name="utme" value="<?php echo e($data[0]->utme); ?>"/>
                                        <?php endif; ?>
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                               <input type="file" name="passfile" class="form-control form-control"
                                                 id="exampleFirstName"  required>
                                          </div>
                                          <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Upload</button>
                                       </div>   
                                        
                                      
                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                       
        </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/changePassport.blade.php ENDPATH**/ ?>