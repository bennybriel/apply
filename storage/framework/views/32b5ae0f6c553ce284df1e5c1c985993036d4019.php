
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('AddUsers')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Create Users Instructions</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">New Users Details</h1>
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
                                            <input type="text" name="staffid" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Staff ID" required>
                                       </div>
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="surname" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Surname" required>
                                       </div>
                                     </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="firstname" class="form-control form-control"
                                                 id="exampleFirstName"
                                                    placeholder="First Name" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="othername" class="form-control form-control" 
                                                id="exampleLastName"
                                                    placeholder="Othername">
                                            </div>
                                        </div>
                                      <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            </div>

                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="phone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                            </div>
                                       </div>


                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                   <select name="role" id="role" class="form-control form-control" required>
                                                      <option value="">Role</option>
                                                        <?php $__currentLoopData = $rol; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <option value="<?php echo e($rol->roleid); ?>"><?php echo e($rol->name); ?></option>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   </select>
                                                </div>

                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                   <select name="section" id="section" class="form-control form-control" required>
                                                      <option value="">Section</option>
                                                      <?php if($usr=="Admin"): ?>
                                                         <?php $__currentLoopData = $sec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <option value="<?php echo e($sec->name); ?>"><?php echo e($sec->name); ?></option>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      <?php else: ?>

                                                         <?php $__currentLoopData = $u; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($u->section); ?>"><?php echo e($u->section); ?></option>
                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      <?php endif; ?>
                                                   </select>
                                                </div>
                                                
                                            
                                                
                                        </div>
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                          <?php if($data): ?>
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Users Record</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>StaffID</th>
                                                                        <th>Name</th>
                                                                        <th>Role</th>
                                                                        <th>Section</th>
                                                                         <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>StaffID</th>
                                                                        <th>Name</th>
                                                                        <th>Role</th>
                                                                        <th>Section</th>
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
                                                                            <td><?php echo e($data->staffid); ?></td>
                                                                            <td><?php echo e(GetName($data->staffid)); ?></td>
                                                                            <td><?php echo e(GetRole($data->roleid)); ?></td>
                                                                            <td><?php echo e($data->section); ?></td>
                                                                            <td>

                                                                                 <?php if($data->isactive==0): ?>
                                                                                    <span style="color:red">Inactive</span>
                                                                                 <?php else: ?>
                                                                                     <span style="color:green">Active</span>
                                                                                 <?php endif; ?>

                                                                            </td>
                                                                            <td>
                                                                                <?php if($usr=="Admin"): ?>
                                                                                   
                                                                                         <?php if($data->isactive==0): ?>
                                                                                             <a href="<?php echo e(route('SuspendRoleByAdmin',[$data->id,$data->isactive])); ?>" class="btn px-4" style="background:#c0a062;color:black">Unsuspend</a>
                                                                                
                                                                                         <?php else: ?>
                                                                                             <a href="<?php echo e(route('SuspendRoleByAdmin',[$data->id,$data->isactive])); ?>" class="btn px-4" style="background:#c0a062;color:white">Suspend</a>
                                                                                
                                                                                        <?php endif; ?>


                                                                                 
                                                                                <?php else: ?>
                                                                                  <a href="<?php echo e(route('SuspendRoleByAdmin',  [$data->id,$data->isactive])); ?>"  class="btn px-4" style="background:#c0a062;color:white">Suspend</a>
                                                                                  <a href="<?php echo e(route('DeleteRoleBySection', [$data->staffid, $data->createdbyrole])); ?>" class="btn btn-danger">Delete</a>
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
<?php
  function GetName($sta)
  {
      $st = DB::table('users')->where('matricno',$sta)->first();
      
      if($st)
      {
         return $st->name;
      }
      else
      {
          return $sta;
      }
  }
  function GetRole($rol)
  {
      $ro = DB::table('roles')->where('roleid',$rol)->first();
      
      return $ro->name;
  }
?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WebApps\ApplyApp\resources\views/createusers.blade.php ENDPATH**/ ?>