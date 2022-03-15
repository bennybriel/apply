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




     <div class="container">
        <div class="row" style="align:center">
            <div class="col-5">
            </div>
            <div class="col-7">
                <img src="logRegTemp/img/brand/logo_predegree1.png" style="max-width:100%;height:auto;"/>
            </div>

          </div>

      <br/>
      <form class=""  id="" method="POST" action="<?php echo e(route('SubmitRegistration')); ?>">
                                                    <?php echo e(csrf_field()); ?>




      <div class="row justify-content-center">

        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
                                                   
              <h4  style="color:#da251d">Create Account</h4>
              <p class="text" style="color:#000000">Create your account</p>
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
                   <input class="form-control" type="text" name="surname" placeholder="Surname" value="<?php echo e(old('surname')); ?>" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-user"></i>
                        </span>
                    </div>
                   <input class="form-control" type="text" name="firstname" placeholder="Firstname" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="icon-user"></i>
                        </span>
                    </div>
                   <input class="form-control" type="text" name="othername" placeholder="Othername">
                </div>
                
                
           
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
      
                <input class="form-control" type="text" name="email" placeholder="Functional Email" required>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input class="form-control" type="password" name="password" placeholder="Password" required>
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input class="form-control" type="password" name="password2" placeholder="Repeat password" required>
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                     <i class="icon-lock"></i>
                  </span>
                </div>
                <select class="form-control" name="session" required>
                  <option value="">Select Session</option>
                  <?php $__currentLoopData = $lst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($lst->name); ?>"><?php echo e($lst->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
               
             </div>

              <button class="btn btn-success" type="submit" style="background:#c0a062;border-color:#da251d;">Create Account</button>
            </div>
            <div class="card-footer p-4">
             <p>Please use valid and correct Email</p>
            </div>
          </div>
        </div>
      </div>
  </form>

    </div>
    <script src="js/jquery-3.3.1.js"></script>


</div>

</div>

<script>


// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

$( document ).ready(function() {
    modal.style.display = "block";
});
// When the user clicks the button, open the modal 
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }

}
</script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.applogReg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WebApps\ApplyApp\resources\views/reg.blade.php ENDPATH**/ ?>