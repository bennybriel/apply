

<?php $__env->startSection('content'); ?>
    <script type="text/javascript" src="js/modernizr.js"></script>
    <script type="text/javascript" src="js/snap.svg-min.js"></script>
    <div class="container">
    <div class="row" style="align:center">
         <div class="col-5">
         </div>
         <div class="col-7">
            <img src="logRegTemp/img/brand/logo_predegree1.png" style="max-width:100%;height:auto;"/>
         </div>

      </div>
  <!-- Clock Countdown
        <div id="clock-countdown" class="animated bounceInDown" data-animation-delay="700"></div>
         <h4 class="color-white top-margin animated bounceInDown" data-animation-delay="300" ></h4>
-->
      <br/>

      <form class=""  id="" method="POST" action="<?php echo e(route('ResetForgotPassword')); ?>">
                                                    <?php echo e(csrf_field()); ?>

      <div class="row justify-content-center">
        <div class="col-md-8">


          <div class="card-group">
            <div class="card p-4">

              <div class="card-body">
                <h4 style="color:#da251d">Admission Portal</h4>
                <p class="text-muted" style="color:#000000">Reset Password</p>
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
                                                        <?php
                                                           // $memberID = session('memberID');
                                                        ?>
                                                <?php endif; ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                  </div>
                  <input class="form-control" type="email" name="email" placeholder="Email" required>
                </div>

                
                <div class="row">
                  <div class="col-6">
                    <button class="btn px-4" type="submit" style="background:#c0a062">Reset Password</button>
                  </div>
                  <!--
                  <div class="col-6">
                    <button class="btn px-4" type="submit" style="background:#c0a062">Login with Google</button>
                  </div> -->
                  <div class="col-6 text-right">
                    <button class="btn btn-link px-0" style="color:#da251d" type="button">Forgot password?</button>
                  </div>
                  <p style="color:#000000"><em>To secure your account, always log out once you are done!</em></p>

                  <p><h6 style="color:#da251d">For Complaints</h6>
                  Call +2348079038989, +2349094507494 <br/>
                  OR Email to support@lautech.edu.ng
                  </p>
                </div>
              </div>
            </div>
            <div class="card text-white py-5 d-md-down" style="background:#c0a062">
              <div class="card-body text-center">
                <div>
                  <h4 style="color:#000000">Reset Password Important information</h2>
                  <p style=" text-align:justify">You are to log in with your Matric Number and password. Once you are logged in, pay close attention to any information appearing in a green box.
           Click here to create a portal account if you are a fresh student. However, if you are not a fresh student, and you do not have a portal account, visit the Admission Office first for profiling and then click here..</p>
                  <h4 style="color:#da251d">Sign up</h2>

                 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/retina.min.js"></script>
<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
<script type="text/javascript" src="js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="js/jquery.parallaxify.min.js"></script>
<script type="text/javascript" src="js/jquery.particleground.min.js"></script>
<script type="text/javascript" src="js/vegas.min.js"></script>
<script type="text/javascript" src="js/trianglify.min.js"></script>
<script type="text/javascript" src="js/jquery.mb.YTPlayer.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery.appear.js"></script>
<script type="text/javascript" src="js/classie.js"></script>
<script type="text/javascript" src="js/sidebar.js"></script>
<script type="text/javascript" src="js/main.js"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.applogReg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lautechp/apply.lautech.edu.ng/resources/views/forgotPassword.blade.php ENDPATH**/ ?>