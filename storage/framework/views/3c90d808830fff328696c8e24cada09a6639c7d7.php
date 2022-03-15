
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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('UploadPDSResult')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Upload Admission List Instructions</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                     Please note: To upload admission list, the excel sheet should have only two columns with no heading or header. For example JUP0000001 
                                                     as the first column and 'Q' as the second column. Please click to <a href="templates/admissionlist_template.xlsx">download Template</a>
                                                     to use for the upload.
                                                    
                                                  </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Upload Admission List</h1>
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
                                             <select class="form-control" name="session" required>
                                                <option value="">Select Session</option>
                                                <?php $__currentLoopData = $lst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($lst->name); ?>"><?php echo e($lst->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                               </select>
                                          </div>
                                       </div>
                               
                                       <div class="form-group row">
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                               <input type="file" name="resultfile" class="form-control form-control"
                                                 id="exampleFirstName"  required>
                                          </div>
                                       </div>       
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Upload Results</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                <?php if($data): ?>
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Uploaded Admission List</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Form Number</th>
                                                                        <th>Name</th>
                                                                        <th>Score</th>
                                                                        <th>Session</th>
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Form Number</th>
                                                                        <th>Name</th>
                                                                        <th>Status</th>
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
                                                                            <td><?php echo e($data->formnumber); ?></td>
                                                                            <td><?php echo e($data->name); ?></td>
                                                                            <td>
                                                                                <?php if($data->status==true): ?>
                                                                                  <span style="color:green">Qualified</span>
                                                                                <?php else: ?>
                                                                                  <span style="color:red">Not Qualified</span>
                                                                                <?php endif; ?>
                                                                            
                                                                            </td>  
                                                                            <td><?php echo e($data->session); ?> </td>  
                                                                          
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


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/uploadpdsResult.blade.php ENDPATH**/ ?>