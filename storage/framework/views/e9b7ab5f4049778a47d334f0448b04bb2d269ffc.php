

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row" style="align:center">
    <div class="col-5">
    </div>
    <div class="col-7">
      <img src="logRegTemp/img/brand/logo.png" style="max-width:100%;height:auto;" />
    </div>

  </div>

  <br />
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-group">
        <div class="card p-4">
          <div class="card-body">
            <h3 style="color:#da251d">Signup Confirmation</h3>
            <p class="text-muted" style="color:#000000"></p>
            <p style="color:#da251d"><em>Congratulations!!!, Your account has been successfully created. Please check your email Inbox or Spam and click on the link to complete your registration.</em></p>

            <p>
            <h6 style="color:#da251d">For Complaints</h6>
            Call +2348079038989, +2349094507494 <br />
            OR Email to support@lautech.edu.ng
            </p>
          </div>
        </div>

        <div class="card text-white py-5 d-md-down" style="background:#c0a062">
          <div class="card-body text-center">
            <div>
              <h4 style="color:#000000">Important information</h2>
                <p style=" text-align:justify"> Please note for this, signup to be completed, you need to check your email and click on the link provided</p>
                <a href="<?php echo e(route('logon')); ?>" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                  Return Home
                </a>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.applogReg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/signupResponse.blade.php ENDPATH**/ ?>