
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<script src="js/jquery-3.3.1.js"></script>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('Supports')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-4">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Create Support Ticket Instructions</h1>
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
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Create New Ticket</h1>
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
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                            <select name="portal" id="portal" class="form-control form-control" required>
                                                    <option value="">Select Portal</option>
                                                       <?php $__currentLoopData = $p; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <option value="<?php echo e($p->portalid); ?>"><?php echo e($p->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </select>
                                           </div>
                                     </div>
                                       <div class="form-group row">
                                   
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="application" id="application" class="form-control form-control" required>
                                                    <option value="">Select Application</option>
                                                
                                                  </select>
                                           </div>
                                     
                                  
                              
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="category" id="category" class="form-control form-control" required>
                                                    <option value="">Select Category</option>
                                                       <?php $__currentLoopData = $c; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <option value="<?php echo e($c->catid); ?>"><?php echo e($c->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </select>
                                       </div>
                        
                                 </div>
                                    <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                           <input type="text" name="subject" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Subject" required>
                                           </div>
                                     </div>
                                     <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                          <textarea name="complains" cols="40" rows="10" placeholder="Please enter your complains" class="form-control form-control" required></textarea>
                                           </div>
                                     </div>
                                     <div class="form-group row">
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                               <input type="file" name="datafile" class="form-control form-control"
                                                 id="exampleFirstName">
                                          </div>
                                       </div>       
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit </button>

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
                                                                        <th>Session</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Session</th>
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
                                                                            <td><?php echo e($data->name); ?></td>
                                                                            <td>

                                                                                 <?php if($data->status==0): ?>
                                                                                    <span style="color:red">Inactive</span>
                                                                                 <?php else: ?>
                                                                                     <span style="color:green">Active</span>
                                                                                 <?php endif; ?>

                                                                            </td>
                                                                            <td>
                                                                              
                                                                                   
                                                                          <?php if($data->status==0): ?>
                                                                            <a href="<?php echo e(route('EnableSession',[$data->id,$data->status])); ?>" class="btn px-4" style="background:#c0a062;color:black">Inactive</a>
                                                                                
                                                                            <?php else: ?>
                                                                            <a href="<?php echo e(route('EnableSession',[$data->id,$data->status])); ?>" class="btn px-4" style="background:#c0a062;color:white">Active</a>
                                                                                
                                                                             <?php endif; ?>
                                                                                                         
                                                                        

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php endif; ?>
        </div>
        <script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){
  $('#portal').change(function(){

     
     var id = $(this).val();
     $('#application').find('option').not(':first').remove();
    
     $.ajax({
       url: 'GetTickets/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }
        
         if(len > 0)
         {
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].appid;
             var name = response['data'][i].name;
             // alert(name);
             var option = "<option value='"+name+"'>"+name+"</option>"

             $("#application").append(option); 
           }
         }

       }
    });
  });

});

        </script>
<?php $__env->stopSection(); ?>
<?php
  function GetName($sta)
  {
      $st = DB::table('users')->where('matricno',$sta)->first();
      
      return $st->name;
  }
  function GetRole($rol)
  {
      $ro = DB::table('roles')->where('roleid',$rol)->first();
      
      return $ro->name;
  }
?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/supportPage.blade.php ENDPATH**/ ?>