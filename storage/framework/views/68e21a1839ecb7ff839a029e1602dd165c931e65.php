<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admissions Portal</title>
    <?php
    $amt = 0;
    $ses = Auth::user()->activesession;
    $matricno = Auth::user()->matricno;
    $utme = Auth::user()->utme;
    $isadm = Auth::user()->isadmitted;
    $usr =   Auth::user()->usertype;
    $ispd = Auth::user()->ispaid;
    $iscomplete =Auth::user()->iscomplete;
    $coff   = DB::SELECT('CALL  GetCuttoffMarkBySession(?)', array($ses));
    $cscore = DB::SELECT('CALL 	GetCandidateResult(?)', array($matricno));
    $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)', array($matricno));
    $rol = DB::SELECT('CALL GetCurrentUserRole(?)', array($matricno));
    $apptype = Auth::user()->apptype;
    $lga = DB::SELECT('CALL CheckLGAExistence(?)',array($matricno));
    $pres = DB::SELECT('CALL CheckCandidateResult(?)',array($utme));
    $ol  = DB::SELECT('CALL CheckCandidateOlevelResult(?)',array($utme));
    $pds = DB::SELECT('CALL GetPDSResult(?)',array(Auth::user()->formnmuber)); 
   // dd($utme);
    // dd($data_c);
    ?>
    <!-- Custom fonts for this template-->
    <link href="dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="dashboard/css/sb-admin-2.css" rel="stylesheet">
    <!--- For count down  -->
    <script type="text/javascript" src="js/modernizr.js"></script>
    <script type="text/javascript" src="js/snap.svg-min.js"></script>
    <!-------------------------->
    <link href="dashboard/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                    <img src="logRegTemp/img/brand/logo2.png" style="max-width:100%;height:auto;" />
                    <sup></sup>
                </div>
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Menu</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Access Screens:</h6>
                        <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                         <?php if($apptype=="UGD" || $apptype=="DE"  || $apptype=="TRF"): ?>
                                 <a class="collapse-item" href="<?php echo e(route('validateUTME')); ?>">Validate UTME</a>
                                    <?php if($iscomplete==true && $apptype=="UGD"): ?>
                                        <a class="collapse-item" href="<?php echo e(route('UTMEPrintScreening')); ?>">Registration Confirmation</a>
                                    <?php else: ?>
                                       <a class="collapse-item" href="<?php echo e(route('screeningconf')); ?>">Registration Confirmation</a>
                                    <?php endif; ?>
                        <?php elseif($apptype=="PG"): ?>
                             <a class="collapse-item" href="<?php echo e(route('pgdataPage')); ?>">Bio Data</a>    
                             <?php if($iscomplete ==true): ?>
                                  <a class="collapse-item" href="<?php echo e(route('screeningconf')); ?>">Registration Confirmation</a>
                                  <a class="collapse-item" href="<?php echo e(route('pgResendReference')); ?>">Send Reference</a>  
                                  <a class="collapse-item" href="<?php echo e(route('PrintPGData')); ?>">Print Reg. Info</a>   
                                  <a class="collapse-item" href="<?php echo e(route('UploadDoc')); ?>">Upload Document</a>   
                              <?php endif; ?> 

                        <?php else: ?>

                        <?php if(empty($lga) || !$lga[0]->lga || $lga[0]->lga==null): ?>
                                    <a class="collapse-item" href="<?php echo e(route('addLGA')); ?>">Update LGA</a>
                        <?php else: ?>
                        
                          <?php if($result): ?>
                           
                            <a class="collapse-item" href="<?php echo e(route('ugbiodata')); ?>">Bio Data</a>
                            <a class="collapse-item" href="<?php echo e(route('ugpreQ')); ?>">Qualification</a>
                           <?php else: ?>
                            <a class="collapse-item" href="<?php echo e(route('ugbiodata')); ?>">Bio Data</a>
                            <a class="collapse-item" href="" readonly>Qualification</a>
                           <?php endif; ?>
                           <?php if($apptype=="JUP"): ?>
                               <?php if($isadm==true): ?>
                                     <a class="collapse-item" href="<?php echo e(route('admissionLetter')); ?>">Admission Letter</a>
                                     <a class="collapse-item" href="<?php echo e(route('stateIdentity')); ?>">State Identification</a>
                               <?php endif; ?>
                            <?php endif; ?>
                            <?php if($apptype=="PDS"): ?>
                               <?php if($isadm==true): ?>
                                     <a class="collapse-item" href="<?php echo e(route('pdsResultSlip')); ?>">PDS Result</a>
                                     <a class="collapse-item" href="<?php echo e(route('admissionPDSLetter')); ?>">Admission Letter</a>
                               <?php endif; ?>
                            <?php endif; ?>


                                <?php if($iscomplete==true): ?>
                                   
                                        <a class="collapse-item" href="<?php echo e(route('screeningconf')); ?>">Registration Confirmation</a>
                                  
                                <?php endif; ?>
                        <?php endif; ?>        
                    <?php endif; ?> 
                     <?php if($apptype=="UGD"): ?>
                       <?php if($pres && $ol): ?>  
                           <a class="collapse-item" href="<?php echo e(route('postUTMEResult')); ?>">Post UTME Result</a>
                       <?php endif; ?>
                     <?php endif; ?>

                        <a class="collapse-item" href="<?php echo e(route('payhistory')); ?>">Payment History</a>
                        <?php if($coff && $cscore): ?>
                        <?php if($cscore >=$coff): ?>
                        <a class="collapse-item" href="<?php echo e(route('ugbiodata')); ?>">Admission Letter</a>
                        <?php endif; ?>
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




            <?php endif; ?>


            <?php endif; ?>


            <?php if($usr=="Student"): ?>

                    <?php if($ispd==1): ?>
                        <!-- Divider -->
                        <hr class="sidebar-divider my-0">

                        <!-- Nav Item - Pages Collapse Menu -->
                            <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>Menu</span>
                            </a>

                            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Access Screens:</h6>
                                    <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                                 
                                    <a class="collapse-item" href="<?php echo e(route('admissionLetter')); ?>">Admission Letter</a>
                                    <a class="collapse-item" href="<?php echo e(route('stateIdentity')); ?>">State Identification</a>
                                    <h6 class="collapse-header">Reports:</h6>
                                    <a class="collapse-item" href="<?php echo e(route('payhistory')); ?>">Payment History</a>
                                    
                            </div>
                            </div>

                    </li>

                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>

                    <!-- Sidebar Message -->
                    <?php endif; ?>

        <?php endif; ?>
            <?php if($usr && $usr=="Staff"): ?>
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Menu</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">



                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Access Screens:</h6>
                        <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                        <!--Addmission Section -->
                        <?php if($rol && $rol[0]->section=="Predegree"): ?>
                                 <?php if($rol[0]->roleid == 2): ?><!--Admin  -->
                                        <a class="collapse-item" href="<?php echo e(route('createusers')); ?>">Create User</a>
                                        <a class="collapse-item" href="<?php echo e(route('uploadpdsResult')); ?>">Upload Results</a>
                                      
                                        <div class="collapse-divider"></div>
                                        <h6 class="collapse-header">Reports:</h6>
                                        <a class="collapse-item" href="<?php echo e(route('downloadJupebPayment')); ?>">Download JUPEB Payment </a>
                                        <a class="collapse-item" href="<?php echo e(route('jupebPaymentList')); ?>">JUPEB Payment </a>
                                        <a class="collapse-item" href="<?php echo e(route('jupebPaymentList')); ?>">JUPEB Payment </a>
                                        <a class="collapse-item" href="<?php echo e(route('ExportPDSJUPApplication')); ?>">Download Applications</a>
                                        <a class="collapse-item" href="<?php echo e(route('getCandidateData')); ?>">View Applicants</a>
                                       <!-- <a class="collapse-item" href="">Upload Admission List</a> -->
                                   
                                <?php elseif($rol[0]->roleid == 3): ?>
                                        <a class="collapse-item" href="<?php echo e(route('ExportPDSJUPApplication')); ?>">Download Applications</a>
                                        <a class="collapse-item" href="<?php echo e(route('getCandidateData')); ?>">View Applicants</a>

                                <?php elseif($rol[0]->roleid == 4): ?>



                                <?php endif; ?>
                     <?php elseif($rol && $rol[0]->section=="Admission"): ?>
                           
                            <?php if($rol[0]->roleid == 2): ?><!--Admin  -->
                                  <a class="collapse-item" href="<?php echo e(route('uploadAdmission')); ?>">Upload UGD List</a>
                                  <a class="collapse-item" href="<?php echo e(route('createusers')); ?>">Create User</a>
                                  <a class="collapse-item" href="<?php echo e(route('changeUTMEProgramme')); ?>">Change UTME Programme</a>
                                <div class="collapse-divider"></div>
                                <h6 class="collapse-header">Reports:</h6>
                                    <a class="collapse-item" href="<?php echo e(route('getPostUTMEList')); ?>">Download PostUTME </a>
                                    <a class="collapse-item" href="<?php echo e(route('GetPostUTMEAllList')); ?>">Download All PostUTME </a>

                            
                            <?php elseif($rol[0]->roleid == 3): ?>
                                    <a class="collapse-item" href="<?php echo e(route('getPostUTMEList')); ?>">Download PostUTME </a>
                                    <a class="collapse-item" href="<?php echo e(route('GetPostUTMEAllList')); ?>">Download All PostUTME </a>

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
            <!-- Nav Item - Charts 
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Change Password</span></a>
            </li>-->

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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Menu</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Access Screens:</h6>
                        <a class="collapse-item" href="<?php echo e(route('home')); ?>">Home</a>
                        <a class="collapse-item" href="<?php echo e(route('createusers')); ?>">Create User</a>
                        <a class="collapse-item" href="<?php echo e(route('setCutoff')); ?>">Set Cutoff</a>
                    
                        <a class="collapse-item" href="<?php echo e(route('appactivation')); ?>">Open/Close App</a>
                        <a class="collapse-item" href="<?php echo e(route('examSetup')); ?>">Exam Setup</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Changes:</h6>
                        <a class="collapse-item" href="<?php echo e(route('changeRegisteredProgramme')); ?>">Change Registered Programme</a>
                        <a class="collapse-item" href="<?php echo e(route('changeUTMEProgramme')); ?>">Change UTME Programme</a>
                           <div class="collapse-divider"></div>
                         <h6 class="collapse-header">Uploads:</h6>
                         <a class="collapse-item" href="<?php echo e(route('uploadAdmission')); ?>">Upload UGD List</a>
                         <a class="collapse-item" href="<?php echo e(route('uploadPDScreeningScore')); ?>">Upload PDS Results</a>
                        <a class="collapse-item" href="<?php echo e(route('uploadpdsResult')); ?>">Upload Results</a>
                        <a class="collapse-item" href="<?php echo e(route('uploadPassport')); ?>">Upload Passport</a>
                        <a class="collapse-item" href="<?php echo e(route('uploadPostUTMEResult')); ?>">Upload Post UTME</a>
                        <a class="collapse-item" href="<?php echo e(route('uploadUtmeInfo')); ?>">Upload UTME Info</a>
                        <a class="collapse-item" href="<?php echo e(route('uploadUTMESubject')); ?>">Upload UTME Subject</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Reports:</h6>
                        
                        <a class="collapse-item" href="<?php echo e(route('downloadJupebPayment')); ?>">Download JUPEB Payment </a>
                        <a class="collapse-item" href="<?php echo e(route('jupebPaymentList')); ?>">JUPEB Payment </a>
                        <a class="collapse-item" href="<?php echo e(route('postUtmeSummary')); ?>">PostUTME Summary </a>
                        <a class="collapse-item" href="<?php echo e(route('getPostUTMEList')); ?>">Download PostUTME </a>
                        <a class="collapse-item" href="<?php echo e(route('GetPostUTMEAllList')); ?>">Download All PostUTME </a>

                        <a class="collapse-item" href="<?php echo e(route('getCandidateData')); ?>">PDS/JUPEB View Applicants</a>
                        <a class="collapse-item" href="<?php echo e(route('ExportPDSJUPApplication')); ?>">Download Applications</a>
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
                <a class="nav-link" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
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
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, <?php echo e(Auth::user()->surname); ?> <?php echo e(Auth::user()->firstname); ?></span>
                                <?php if(Auth::user()->photo): ?>
                                
                                <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.Auth::user()->photo)); ?>" alt="Member's Photo" width="80px" height="70px" />
                                <?php else: ?>
                                <img src="../logRegTemp/img/brand/default.png" style="max-width:70px;height:70px;" />
                                <?php endif; ?>



                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                              
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                        <span>Logout</span></a>


                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form>

                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <?php echo $__env->yieldContent('content'); ?>


            </div>
            <!-- Clock Countdown -->


            <!-- End of Main Content -->

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
    <script src="dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="dashboard/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="dashboard/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="dashboard/js/demo/chart-area-demo.js"></script>
    <script src="dashboard/js/demo/chart-pie-demo.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
    <script src="dashboard/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="dashboard/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="dashboard/js/demo/datatables-demo.js"></script>






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

</html><?php /**PATH E:\xampp\htdocs\admissions\resources\views/layouts/appdashboard.blade.php ENDPATH**/ ?>