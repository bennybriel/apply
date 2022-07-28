<?php $__env->startSection('content'); ?>
<?php
  //dd($ses);
?>
<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>


<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<script src="js/jquery-3.3.1.js"></script>
     <div class="container">
        <div class="row" style="align:center">
            <div class="col-5">
            </div>
            <div class="col-7">
                <img src="logRegTemp/img/brand/logo_predegree1.png" style="max-width:100%;height:auto;"/>
            </div>

          </div>

      <br/>
      <form   id="form1">
          <div class="row justify-content-center">

        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
                                                   
              <h4  style="color:#da251d">Create Account</h4>
              <p class="text" style="color:#000000">Create your account</p>

              <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	                   <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	              </div>
				        <div class="alert alert-danger alert-dismissible" id="failure" style="display:none;">
	                   <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
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
              <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-user"></i>
                        </span>
                    </div>
                   <input class="form-control" type="text" name="surname" id="surname" placeholder="Surname" value="<?php echo e(old('surname')); ?>" required>
                   <span class="text-danger" id="name-surname"></span>
                  </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-user"></i>
                        </span>
                    </div>
                   <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Firstname" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-user"></i>
                        </span>
                    </div>
                   <input class="form-control" type="text" name="othername" id="othername" placeholder="Othername">
                </div>
                
                
           
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
      
                <input class="form-control" type="email" name="email" id="email" placeholder="Functional Email" required>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input class="form-control" type="password" name="password2" id="password2" placeholder="Repeat password" required>
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                     <i class="icon-lock"></i>
                  </span>
                </div>
                <select class="form-control" name="session" id="session" required>
                  <option value="">Select Session</option>
                  <?php $__currentLoopData = $lst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($lst->name); ?>"><?php echo e($lst->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
               
             </div>

              <button class="btn btn-success" type="button" id="SaveRegister" style="background:#c0a062;border-color:#da251d;">Create Account</button>
            </div>
            <div class="card-footer p-4">
             <p>Please use valid and correct Email</p>
            </div>
          </div>
        </div>
      </div>
  </form>

    </div>
   


</div>

</div> 
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> -->
<script type='text/javascript'>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function()
{
$('#SaveRegister').on('click', function(e) 
  {
    e.preventDefault();
   
    var surname   = $('#surname').val();
    var firstname = $('#firstname').val();
    var othername = $('#othername').val();
    var email     = $('#email').val();
    var password  = $('#password').val();
    var password2 = $('#password2').val();
    var session   = $('#session').val();


    // if(surname != '' && firstname != '' && email != '' && password!='' && password2!='' && session!='')
    // {
    
      
        $.ajax({
        url: 'SignUpNow',
        type: 'POST',
        data: {_token: CSRF_TOKEN, surname: surname, 
                                   firstname: firstname, 
                                   othername: othername,
                                   email: email,
                                   password: password,
                                   password2: password2,
                                   session: session },
          cache: false,
          success: function(response)
          {
            var dataResult = JSON.(response);
            console.log(dataResult);
            debugger;
            if(response.statusCode==201)
						{
						       $("#failure").show();
				           $('#failure').html(response.msg); 
						       //return;
						}
            else if(response.statusCode==203)
						{
						       $("#failure").show();
				           $('#failure').html(response.msg); 
						      // return;
						}
            else if(response.statusCode==205)
						{
						       $("#failure").show();
				           $('#failure').html(response.msg); 
						       //return;
						}
            else if(response.statusCode==200)
            {
              window.location = "SignupResponse"; 
            }
            else
            {
              $("#failure").show();
		        	$('#failure').html('Operation Failed'); 
            }
          },
          error: function(response) {
            console.log(response);
            $('#surname-error').text(response.responseJSON.errors.name);
          }
        });
     
    //}
    // else{
    //   //alert('Required Field, Please');
    //   $("#failure").show();
		// 	$('#failure').html('Required Field!!!'); 
		// 	// return;
    // }
  });

});


    function checkEmail() {
        var email = document.getElementById('email');
        var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!filter.test(email.value)) {
          $("#failure").show();
			    $('#failure').html('Invalid Email Address'); 
			    return;
        }
    }

 </script>


   <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.applogReg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\apply\resources\views/reg.blade.php ENDPATH**/ ?>