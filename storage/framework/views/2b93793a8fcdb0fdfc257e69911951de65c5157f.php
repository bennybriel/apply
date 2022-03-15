
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $utme = session('utme');
     $data = DB::table('users as us')
            ->join('u_g_pre_admission_regs as rg','rg.matricno','=','rg.matricno')
            ->where('us.utme',$utme)
            ->first();
?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<script src="js/jquery-3.3.1.js"></script>


<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('UpdateStudentInfos')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Update Student Instructions</h1>
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
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Update Student Information</h1>
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
                                    <?php if($data): ?>
                                    <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                 <label>Surname</label>
                                                    <input type="text" name="surname" value="<?php echo e($data->surname); ?>" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="First Name" required>
                                                    
                                            </div>
                                        
                                        </div>
                                        <input type="hidden" name="utme" value="<?php echo e($data->utme); ?>" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="">
                                                  
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <label>Firstname</label>
                                                    <input type="text" name="firstname" value="<?php echo e($data->firstname); ?>" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="First Name" required>
                                                    
                                            </div>
                                        
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <label>Othername</label>
                                                    <input type="text" name="firstname" value="<?php echo e($data->othername); ?>" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="">
                                                    
                                            </div>
                                        
                                        </div>
                                    <?php endif; ?>

                                     <div class="form-group row">
                                       <div class="col-sm-8 mb-3 mb-sm-0">
                                               <select name="state" id="state" class="form-control form-control" required>
                                                      <option value="">Select State</option>
                                                        <?php $__currentLoopData = $st; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <option value="<?php echo e($st->stateid); ?>"><?php echo e($st->name); ?></option>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   </select>
                                            
                                       </div>
                                      
                                     </div>
                                        <div class="form-group row">
                                           <div class="col-sm-10 mb-3 mb-sm-0">
                                           <select name="lga" id="lga" class="form-control form-control" required>
                                                      <option value="">Select LGA</option>
                                                      
                                                   </select>
                                          </div>
                                      </div>
                                        
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Update Student Info</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

           <?php
              session(['utme' => null]);
              //session(['data' => null]);
           ?>
                                       
        </div>
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){
  $('#state').change(function(){

     
     var id = $(this).val();
     $('#lga').find('option').not(':first').remove();
    
     $.ajax({
       url: 'GetLGA/'+id,
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

             var id = response['data'][i].lgaid;
             var name = response['data'][i].lga;
             // alert(name);
             var option = "<option value='"+name+"'>"+name+"</option>"

             $("#lga").append(option); 
           }
         }

       }
    });
  });

});

        </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/updateStudentInfo.blade.php ENDPATH**/ ?>