
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
    // $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<script src="js/jquery-3.3.1.js"></script>


<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('LockAccesss')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Lock User Access Instructions</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                     Please note that by clicking here to login, you affirm that you have read and understood all the instructions
                                                       </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Lock Access </h1>
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
                                                <select name="apptype" id="apptype" class="form-control form-control" required>
                                                       <option value="">Select Application Type</option>
                                                            <?php $__currentLoopData = $ap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($ap->apptype); ?>"><?php echo e($ap->apptype); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      </select>
                                       </div>
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="lock" id="lock" class="form-control form-control" required>
                                                  <option value="">Select Action</option>
                                                  <option value="1">Unlock</option>     
                                                  <option value="0">Lock</option>          
                                             </select>
                                       </div>
                                     </div>
                                        <div class="form-group row">
                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="category" id="category" class="form-control form-control" required>
                                                    <option value="">Select Category</option>
                                                    <?php $__currentLoopData = $cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($cat->usertype); ?>"><?php echo e($cat->usertype); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>      
                                                </select>
                                          </div>
                                      </div>
                                        
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Submit</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                      
        </div>

        <script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$(document).ready(function() {
	$('#Seaters').on('click', function() 
    {
		
		var num   = $('#num').val();
		var hname = $('#hname').val();

        //alert(num+hname);

		if(num!="" || hname!="")
		{
			$.ajax({
				url: "UpdateHallCapacity",
				type: "GET",
				data: {_token: CSRF_TOKEN,
					num: num,
					hname: hname,						
				},
				cache: false,
				success: function(dataResult)
                {
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200)
                    {
						$("#success").show();
						$('#success').html(dataResult.msg); 
                        return;						
					}
					else if(dataResult.statusCode==201){
                        $("#failure").show();
						$('#failure').html(dataResult.msg); 	
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/lockAccess.blade.php ENDPATH**/ ?>