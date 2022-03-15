
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
         

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                <h1 class="h4 mb-4" style="color:#da251d"><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->formnumber); ?></h1>
                        </div>
                                       <!--Surname-->
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                               <div class="form-group row">
                                                      <div class="col-sm-2 mb-3 mb-sm-0">
                                                    <label> Surname </label>
                                                  
                                                  </div>
                                                  <div class="col-sm-7 mb-3 mb-sm-0">
                                                    
                                                    <input type="text" name="surname" class="form-control form-control" id="surname"
                                                     value="<?php echo e($data[0]->surname); ?>" required>
                                                  </div>

                                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                                    <button class="btn btn-success" type="submit" id="btnsurname">Update</button>
                                                </div>
                                             </div>
                                            </div>
                                        </div>                                          
                                           <!--Firstname-->
                                         <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                               <div class="form-group row">
                                                      <div class="col-sm-2 mb-3 mb-sm-0">
                                                    <label> Firstname </label>
                                                  
                                                  </div>
                                                  <div class="col-sm-7 mb-3 mb-sm-0">
                                                    
                                                    <input type="text" name="firstname" class="form-control form-control" id="firstname"
                                                     value="<?php echo e($data[0]->firstname); ?>" required>
                                                  </div>

                                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                                    <button class="btn btn-success" type="submit" id="btnfirstname">Update</button>
                                                </div>
                                             </div>
                                            </div>
                                         </div>
                                       <!--Othername -->
                                       <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                               <div class="form-group row">
                                                      <div class="col-sm-2 mb-3 mb-sm-0">
                                                    <label> Othername </label>
                                                  
                                                  </div>
                                                  <div class="col-sm-7 mb-3 mb-sm-0">
                                                    
                                                    <input type="text" name="othername" class="form-control form-control" id="othername"
                                                     value="<?php echo e($data[0]->othername); ?>">
                                                  </div>

                                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                                    <button class="btn btn-success" type="submit" id="btnothername">Update</button>
                                                </div>
                                             </div>
                                            </div>
                                         </div>
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-4">
                                  
                                     <div class="form-group row">
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="hallid" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Hall ID" required>
                                       </div>
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="hall" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Hall Name" required>
                                       </div>
                                     </div>
                                        <div class="form-group row">
                                           <div class="col-sm-8 mb-3 mb-sm-0">
                                              <input type="text" name="capacity" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Hall Capacity" required>
                                          </div>
                                      </div>
                                        
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Create Hall</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            

            
                             
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

<?php echo $__env->make('layouts.appdashboard1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/editData.blade.php ENDPATH**/ ?>