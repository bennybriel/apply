
<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Collection;
    $psurname   = session('psurname');
    $pfirstname = session('pfirstname');
    $pemail     = session('pemail');
    $relation   = session('relation');
    $pphone     = session('pphone');
    $paddress   = session('paddress');
    //$ap = DB::SELECT('CALL GetStudentAccountInfo(?)',array($matricno));

   
?>
<script src="js/jquery-3.3.1.js"></script>
<div class="card o-hidden border-0 shadow-lg my-5">
 
            <div class="card-body p-0">
             
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('UpdateParentData')); ?>">
                                        <?php echo e(csrf_field()); ?>


                

                        <div class="p-5">
                        <div class="text-center">
                            <img src="../logRegTemp/img/brand/logo2.png" style="max-width:100%;height:auto;"/>
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

                                      
                   


                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Parents/Guardian</h1>
                                    </div>
                                    <div class="form-group">
                                          
                                        <input type="name" name="name" value="<?php echo e($data->name); ?>" class="form-control form-control" id="exampleInputEmail"
                                            placeholder="" readonly>
                                         
                                       </div>



                                        <div class="form-group row">

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                            
                                                <input type="text" name="pfirstname"  class="form-control form-control" id="exampleFirstName"
                                                    placeholder="First Name" required>
                                               
                                            </div>


                                            <div class="col-sm-6">
                                               
                                                     <input type="text" name="psurname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          
                                            <input type="email" name="pemail"  class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                          
                                        </div>
                                        <div class="form-group">
                                        
                                            <input type="text" name="paddress"  class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
                                         
                                        </div>
                                        <div class="form-group row">

                                        
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="relation" id="" class="form-control form-control" required>
                                                  
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Uncle">Uncle</option>
                                                    <option value="Nephew">Nephew</option>
                                                    <option value="Cousin">Cousin</option>
                                                </select>
                                            </div>
                                         

                                            <div class="col-sm-6">
                                                <input type="text" name="pphone" value="<?php echo e($pphone); ?>" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                             
                                            </div>

                                        </div>
                                        
                               
                                           

                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit Info</button>

                                      
                                
                                        
                                        
                                        <hr>




                             

                               

                        

                         
                                         
                      
                 
                              </div>
                            </form>
                          </div>
                    </div>
                    

<?php
  function GetFaculty($fac)
  {
     $fa = DB::table('faculty')->where('facultyid', $fac)->first();
     return $fa->Faculty;
  }
?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.applogReg2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\apply\resources\views/updateParentInfo.blade.php ENDPATH**/ ?>