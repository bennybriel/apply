
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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('ValidateUTMES')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">UTME Validation Instructions</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">UTME Validation</h1>
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
                                            <input type="text" name="utme" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="UTME/Application Number" required>
                                       </div>
                                      
                                     </div>
                                     <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="apptype" id="apptype" class="form-control form-control" required>
                                                    <option value="">Application</option>
                                                    <option value="UTME">UTME</option>
                                                    <option value="Direct Entry">Direct Entry</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                               <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit</button>

                                            </div>
                                            
                                        </div>
                                        
                                     

                                                
                                            
                                                
                                    
                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
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

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/validateUTME.blade.php ENDPATH**/ ?>