<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version  v2.1.10
* @link  https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Education, School, Academic, Admission, University">
    <meta name="author" content="Lautech University">
    <meta name="keyword" content="Education, School, Academic, Admission, University, Institution, Learning, Technology">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admission Portal</title>
    <!-- Icons-->
    <link href="logRegTemp/node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="logRegTemp/node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="logRegTemp/node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="logRegTemp/node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="logRegTemp/css/style.css" rel="stylesheet">
    <link href="logRegTemp/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'UA-118965717-3');
      // Bootstrap ID
      gtag('config', 'UA-118965717-5');
    </script>
  </head>
  <body class="app flex-row align-items-center">
  <!--
      <div class="row">
         <div class="col-7">
         </div>
         <div class="col-3">
            <img src="logRegTemp/img/brand/logo.png" style="max-width:100%;height:auto;"/>
         </div>

      </div> -->
        <?php echo $__env->yieldContent('content'); ?>


    <!-- CoreUI and necessary plugins-->
    
    <script src="logRegTemp/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="logRegTemp/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="logRegTemp/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="logRegTemp/node_modules/pace-progress/pace.min.js"></script>
    <script src="logRegTemp/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="logRegTemp/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
  </body>
</html>
<?php /**PATH E:\xampp\htdocs\admissions\resources\views/layouts/applogReg.blade.php ENDPATH**/ ?>