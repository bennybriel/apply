<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admission Portal</title>
    <?php
        $amt=0;
        $ses = Auth::user()->activesession;
        $matricno = Auth::user()->matricno;
        $isadm = Auth::user()->isadmitted;
        $usr =   Auth::user()->usertype;
        $ispd = Auth::user()->ispaid;
        //$data = DB::SELECT('CALL FetchStudentAccountRecordByMatricNoSession(?,?)', array($matricno,$ses));
        $rol = DB::SELECT('CALL GetCurrentUserRole(?)', array($matricno));
       // $data_c = DB::SELECT('CALL FetchPaymentOnce(?)', array($matricno));
         $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)', array($matricno));

        //dd($usr);
        // dd($data_c);
    ?>
    <!-- Custom fonts for this template-->
    <link href="../dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../dashboard/css/sb-admin-2.css" rel="stylesheet">
    <!--- For count down  -->
    <script type="text/javascript" src="../js/modernizr.js"></script>
    <script type="text/javascript" src="../js/snap.svg-min.js"></script>
    <!-------------------------->
    <link href="../dashboard/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-winks"></i>
                </div>
                <div class="sidebar-brand-text mx-3">
                <img src="../logRegTemp/img/brand/logo2.png" style="max-width:100%;height:auto;"/>
                 <sup></sup></div>
            </a>
     
<?php
//dd($data_c[0]->ispaid);
?>
      <?php if($usr=="Candidate"): ?>
           
               <?php if($ispd==1): ?>                    
                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                            <!-- Nav Item - Pages Collapse Menu -->
                            <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                            aria-expanded="true" aria-controls="collapsePages">
                            <i class="fas fa-fw fa-wrench"></i>
                            <span>Menu</span>
                        </a>
                        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Access Screens:</h6>
                                <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                               <?php if($result): ?>
                                <a class="collapse-item" href="<?php echo e(route('ugbiodata')); ?>">Bio Data</a>
                                <a class="collapse-item" href="<?php echo e(route('ugpreQ')); ?>">Qualification</a>
                                 <a class="collapse-item" href="<?php echo e(route('screeningconf')); ?>">Registration Confirmation</a>

                                 <a class="collapse-item" href="<?php echo e(route('payhistory')); ?>">Payment History</a>
                               <?php else: ?>
                                   <a class="collapse-item" href="<?php echo e(route('ugbiodata')); ?>">Bio Data</a>
                                   <a class="collapse-item" href="" readonly>Qualification</a>
                               <?php endif; ?>
                                    
                               <!--
                                <a class="collapse-item" href="">Check Result</a>
                                <div class="collapse-divider"></div>
                                <h6 class="collapse-header">Reports:</h6>
                                <a class="collapse-item" href="">Print Course Form</a>
                                <a class="collapse-item" href="">Payment Invoice</a>
                                <a class="collapse-item" href="">Payment Receipt</a>
                                <a class="collapse-item" href="">Personal Data</a>  -->
                            </div>
                        </div>
                    </li>
                    
                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Addons
                    </div>
                    <!-- Nav Item - Charts -->
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Support</span></a>
                    </li>

                <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">
                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>

                    <!-- Sidebar Message -->
                    
                 <?php else: ?>
                  
                       <li class="nav-item">
                        <a class="nav-link" href="">
                        <i class="fas fa-dollar-sign"></i>
                            <span>Payment Now</span></a>
                      </li>

                  
                <?php endif; ?>

              
       <?php endif; ?>
   


    <?php if($usr && $usr=="Staff"): ?>
                 <hr class="sidebar-divider my-0">

                            <!-- Nav Item - Pages Collapse Menu -->
                            <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                            aria-expanded="true" aria-controls="collapsePages">
                            <i class="fas fa-fw fa-wrench"></i>
                            <span>Menu</span>
                        </a>
                        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">

                        

                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Access Screens:</h6>
                                <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                           <!--Addmission Section -->
                           <?php if($rol && $rol[0]->section=="Admission"): ?>
                                 <?php if($rol[0]->roleid == 2): ?><!--Admin  -->
                                        <a class="collapse-item" href="<?php echo e(route('createusers')); ?>">Create User</a>
                                        <a class="collapse-item" href="">Update User</a>
                                        <div class="collapse-divider"></div>
                                        <h6 class="collapse-header">Reports:</h6>
                                        <a class="collapse-item" href="<?php echo e(route('viewCandidateInfo')); ?>">View Addmission</a>
                                
                                        
                                   
                                <?php elseif($rol[0]->roleid == 3): ?>
                                   <a class="collapse-item" href="#">Upload Admission List</a>
                                   <a class="collapse-item" href="<?php echo e(route('viewCandidateInfo')); ?>">View Addmission</a>
                                

                                <?php elseif($rol[0]->roleid == 4): ?>



                                <?php endif; ?>
                          
                             <?php endif; ?>

                            </div>
                     

                        </div>
                    </li>
                    
                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Addons
                    </div>
                    <!-- Nav Item - Charts -->
                   <li class="nav-item">
                        <a class="nav-link" href="charts.html">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Change Password</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="charts.html">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Support</span></a>
                    </li>

                <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">
                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>


    <?php endif; ?>



    <?php if($usr && $usr=="Admin"): ?>

                 <hr class="sidebar-divider my-0">

                            <!-- Nav Item - Pages Collapse Menu -->
                            <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                            aria-expanded="true" aria-controls="collapsePages">
                            <i class="fas fa-fw fa-wrench"></i>
                            <span>Menu</span>
                        </a>
                        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Access Screens:</h6>
                                 <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                                

                                <div class="collapse-divider"></div>
                                <h6 class="collapse-header">Reports:</h6>
                                <a class="collapse-item" href="<?php echo e(route('viewCandidateInfo')); ?>">View Record</a>
                              
                            </div>
                        </div>
                    </li>
                    
                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Addons
                    </div>
                    <!-- Nav Item - Charts -->
                    <li class="nav-item">
                        <a class="nav-link" href="charts.html">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Support</span></a>
                    </li>

                <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">
                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>


    <?php endif; ?>
     <hr class="sidebar-divider d-none d-md-block">
                  <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('changeMyPassword')); ?>">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Change Password</span></a>
                    </li>
    <hr class="sidebar-divider d-none d-md-block">
           <!-- Nav Item - Tables -->
           <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                           <span>Logout</span></a>


                 <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                  <?php echo e(csrf_field()); ?>

                </form>


            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, <?php echo e(Auth::user()->surname); ?> <?php echo e(Auth::user()->firstname); ?></span>
                          <?php if(Auth::user()->photo): ?>
                             <img class="nav-user-photo" src="<?php echo e(asset('..//Passports/Students/'.Auth::user()->photo)); ?>" alt="Member's Photo" width="80px" height="70px" />
                        <?php else: ?>
                          <img src="../../logRegTemp/img/brand/default.png" style="max-width:70px;height:70px;"/> 
                        <?php endif; ?>          

                                

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Candidate Information</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                   







                    <div class="row">




                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
               <!-- Clock Countdown -->


            <!-- End of Main Content -->
            <?php echo $__env->yieldContent('content'); ?>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                       Copyright © <?php echo date("Y"); ?> LAUTECH ICT. All rights reserved.
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Bootstrap core JavaScript-->
    <script src="../dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="../dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../dashboard/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../dashboard/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../dashboard/js/demo/chart-area-demo.js"></script>
    <script src="../dashboard/js/demo/chart-pie-demo.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
    <script src="../dashboard/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../dashboard/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../dashboard/js/demo/datatables-demo.js"></script>






<!--
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
 -->
</body>

</html>
<?php /**PATH D:\xampp\htdocs\admissions\resources\views/layouts/appdashboard1.blade.php ENDPATH**/ ?>