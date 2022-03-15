
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     //$u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('ActivateApp')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Application Activation Instructions</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                     Please note that by clicking here to login, you affirm that you have read and understood all the instructions
                                                     documented in this guide. If you are a fresh student and yet to create a Portal Account, click here. However,
                                                     if you are not a fresh student, and you do not have a portal account, visit the Admission Office first for profiling
                                                     and then click here. After completely studying this guide, if you still have any further enquiries, please feel free
                                                     to contact us.
                                                  </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Open/Close Application</h1>
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
                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                         <select class="form-control" name="appname" required>
                                                <option value="">Select Application</option>
                                                <?php $__currentLoopData = $lst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($lst->name); ?>"><?php echo e($lst->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                           </select>
                                         </div>  

                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                         <select class="form-control" name="session" required>
                                                <option value="">Select Session</option>
                                                    <?php $__currentLoopData = $ses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($ses->name); ?>"><?php echo e($ses->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                           </select>
                                         </div>  
                                     </div>

                                     <div class="form-group row">

                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                             <label>Open Date</label>
                                              <input type="date" name="odate" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Opening Date" required>
                                         </div>  
                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                         <label>Close Date</label>
                                              <input type="date" name="cdate" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Closing Date" required>
                                         </div>  
                                     </div>
                                   <!--
                                     <div class="form-group row">
                                         <div class="col-sm-8 mb-3 mb-sm-0">
                                              <input type="number" name="activedays" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Number of Days" required>
                                         </div>  
                                     </div> 
                                   -->
                               

                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Create</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                            <?php if($data): ?>
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Open/Close Application Record</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Opening Date</th>
                                                                        <th>Closing Date</th>
                                                                        <th>Active Days</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Opening Date</th>
                                                                        <th>Closing Date</th>
                                                                        <th>Active Days</th>
                                                                        <th>Status</th>
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
                                                                            <td><?php echo e($data->appname); ?></td>
                                                                            <td><?php echo e($data->session); ?></td>
                                                                            <td><?php echo e($data->opendate); ?></td>
                                                                            <td><?php echo e($data->closedate); ?></td>
                                                                            <td> <?php echo e($data->activedays); ?>        <td>

                                                                                 <?php if($data->status==0): ?>
                                                                                    <span style="color:red">Close</span>
                                                                                 <?php else: ?>
                                                                                     <span style="color:green">Open</span>
                                                                                 <?php endif; ?>

                                                                            </td>
                                                                            
                                                                              
                                                                            <td> 
                                                                               <div class="modal fade" id="myModal" role="dialog">
                                                                                <div class="modal-dialog">
                                                                                    <!-- Modal content-->
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                        
                                                                                            <h4 class="modal-title">Update <?php echo e($data->appname); ?></h4>
                                                                                            <form class="form-group" action="/UpdateAppActivation/<?php echo e($data->id); ?>" method="post" id="editCommunityForm_<?php echo e($data->id); ?>">
                                                                                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                                                                <input type="date" name="closedate" class="form-control" value="<?php echo e($data->closedate); ?>">
                                                                                            </form>
                                                                                            <button class="btn btn-custom" style="background:#c0a062;color:white" type="submit" form="editCommunityForm_<?php echo e($data->id); ?>">Update</button><br /><br />
                                                                                        
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                               </div>                                                           
                                                                                 <button type="button" class="btn" data-toggle="modal" data-target="#myModal" data-community="<?php echo e(json_encode($data)); ?>" style="background:#c0a062;color:white">Edit</button>
        |                                                                        <a href="<?php echo e(route('RemoveAppActivation',$data->id)); ?>" class="btn btn-danger" style="color:white">Delete</a>
                                                                        
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

 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>
            <div class="modal-body">
                <form class="form-group" method="post" id="editCommunityForm">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="text" name="cutoff" class="form-control" placeholder="Edit Cutoff">
                </form>
                <button class="btn btn-custom waves-light" style="background:#c0a062;color:white" type="submit" form="editCommunityForm">Update Cutoff</button><br /><br />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/appactivation.blade.php ENDPATH**/ ?>