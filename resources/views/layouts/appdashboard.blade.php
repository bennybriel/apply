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
    $admitted =  DB::SELECT('CALL IsAdmitted(?)',array($utme));
    $pds = DB::SELECT('CALL GetPDSResult(?)',array(Auth::user()->formnmuber)); 
  // dd(Auth::user()->isletter);
  //  dd($usr);
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
            @if($usr=="Candidate")

                @if($ispd==1)
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
                                <a class="collapse-item" href="{{  route('home') }}">Home</a>
                                 @if($apptype=="UGD" || $apptype=="DE"  || $apptype=="TRF")
                                         <a class="collapse-item" href="{{ route('validateUTME') }}">Validate UTME</a>
                                            @if($iscomplete==true && $apptype=="UGD")
                                                <a class="collapse-item" href="{{ route('UTMEPrintScreening') }}">Registration Confirmation</a>
                                            @else
                                               <a class="collapse-item" href="{{ route('screeningconf') }}">Registration Confirmation</a>
                                            @endif
                                            @if(Auth::user()->isChange=='1' && $apptype=="UGD")
                                                        <a class="collapse-item" href="{{ route('changeProgramme') }}">Change Programme</a>
                                            @endif
                                @elseif($apptype=="PG")
                                     <a class="collapse-item" href="{{ route('pgdataPage') }}">Bio Data</a>    
                                     @if($iscomplete ==true)
                                          <a class="collapse-item" href="{{ route('screeningconf') }}">Registration Confirmation</a>
                                          <a class="collapse-item" href="{{ route('pgResendReference') }}">Send Reference</a>  
                                           <a class="collapse-item" href="{{ route('PrintPGData') }}">Print Reg. Info</a>   
                                      @endif 
        
                                @else
        
                                @if(empty($lga) || !$lga[0]->lga || $lga[0]->lga==null)
                                            <a class="collapse-item" href="{{ route('addLGA') }}">Update LGA</a>
                                @else
                                
                                  @if($result)
                                   
                                    <a class="collapse-item" href="{{ route('ugbiodata') }}">Bio Data</a>
                                    <a class="collapse-item" href="{{ route('ugpreQ') }}">Qualification</a>
                                   @else
                                    <a class="collapse-item" href="{{ route('ugbiodata') }}">Bio Data</a>
                                    <a class="collapse-item" href="" readonly>Qualification</a>
                                   @endif
                                   @if($apptype=="JUP")
                                    @if($isadm==true)
                                            <a class="collapse-item" href="{{ route('admissionLetter') }}">Admission Letter</a>
                                        
                                             <a class="collapse-item" href="{{ route('stateIdentity') }}">State Identification</a>
                                         
                                     @endif
                                  @endif
                                    @if($apptype=="PDS")
                                       @if($isadm==true)
                                              <a class="collapse-item" href="{{ route('pdsResultSlip') }}">PDS Result</a>
                                              <a class="collapse-item" href="{{ route('admissionLetterPDS') }}">Admission Letter</a>
                                              <a class="collapse-item" href="{{ route('stateIdentity') }}">State Identification</a>
                                       @endif
                                    @endif
                                        @if($iscomplete==true)
                                           
                                                <a class="collapse-item" href="{{ route('screeningconf') }}">Registration Confirmation</a>
                                          
                                        @endif
                                @endif        
                            @endif 
                              @if($apptype=="UGD" && $admitted)
                                       @if($isadm==true)
                                             <a class="collapse-item" href="{{ route('admissionLetterUGD') }}">Admission Letter</a>
                                             <a class="collapse-item" href="{{ route('stateIdentity') }}">State Identification</a>
                                       @endif
                                    @endif
                             @if($apptype=="UGD" || $apptype=="PD")
                               @if($pres && $ol)  
                                  <a class="collapse-item" href="{{ route('postUTMEResult') }}">Check Post-UTME Result</a> 
                               @endif
                             @endif
        
                                <a class="collapse-item" href="{{ route('payhistory') }}">Payment History</a>
                                @if($coff && $cscore)
                                @if($cscore >=$coff)
                                <a class="collapse-item" href="{{ route('ugbiodata') }}">Admission Letter</a>
                                @endif
                                @endif
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
                   
        
                    <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">
                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>
        
                    <!-- Sidebar Message -->

                 @else

                  <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>Menu</span>
                            </a>

                            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Access Screens:</h6>
                                    <a class="collapse-item" href="{{  route('home') }}">Home</a>
                                </div>
                           </div>
                   </li>


            @endif

         @endif


            @if($usr=="Student" && $isadm=='1')

                    @if($ispd==1)
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
                                    <a class="collapse-item" href="{{  route('home') }}">Home</a>
                                    @if(trim($apptype)=="PT" && $isadm=='1')
                                       <a class="collapse-item" href="{{ route('admissionLetterPT') }}">Admission Letter</a>
                                    @endif
                                    @if($apptype=="JUP" && $isadm==true)
                                        <a class="collapse-item" href="{{ route('admissionLetter') }}">Admission Letter</a>
                                        <a class="collapse-item" href="{{ route('stateIdentity') }}">State Identification</a>
                                       
                                         
                                     @endif
                                      @if($apptype=="PG" && $isadm=='1')
                                        <a class="collapse-item" href="{{ route('admissionLetterPG') }}">Admission Letter</a>
                                        <a class="collapse-item" href="{{ route('pgAcceptanceForm') }}">Acceptance Form</a>
                                      @endif
                                      
                                      @if($apptype=="PDS")
                                         @if($isadm==true)
                                              <a class="collapse-item" href="{{ route('pdsResultSlip') }}">PDS Result</a>
                                              <a class="collapse-item" href="{{ route('admissionLetterPDS') }}">Admission Letter</a>
                                              <a class="collapse-item" href="{{ route('stateIdentity') }}">State Identification</a>
                                          @endif
                                       @endif
                                    @if($iscomplete=='1' && $apptype=="UGD")
                                        <a class="collapse-item" href="{{ route('UTMEPrintScreening') }}">Registration Confirmation</a>
                                    @endif
                                   @if($apptype=="UGD" || $apptype=="PD")
                                       @if(Auth::user()->isletter=='1')
                                         <a class="collapse-item" href="{{ route('admissionLetterUGD') }}">Admission Letter</a>
                                       @endif
                                       @if($pres && $ol)  
                                          <a class="collapse-item" href="{{ route('postUTMEResult') }}">Check Post-UTME Result</a> 
                                       @endif
                                     @endif
                                 
                                    <h6 class="collapse-header">Reports:</h6>
                                    <a class="collapse-item" href="{{ route('payhistory') }}">Payment History</a>
                                    
                            </div>
                            </div>

                    </li>

                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>

                    <!-- Sidebar Message -->
                    @endif

        @endif
            @if($usr && $usr=="Staff")
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
                        <a class="collapse-item" href="{{  route('home') }}">Home</a>
                        <!--Addmission Section -->
                        
                        @if($rol && $rol[0]->section=="Predegree")
                                 @if($rol[0]->roleid == 2)<!--Admin  -->
                                        <a class="collapse-item" href="{{ route('createusers') }}">Create User</a>
                                        <a class="collapse-item" href="{{ route('uploadPDScreeningScore') }}">Upload PDS Results</a>
                                        <a class="collapse-item" href="{{ route('uploadpdsResult') }}">Upload JUPEB Results</a>
                                        <a class="collapse-item" href="{{ route('lgaList') }}">Update LGA</a>
                                      
                                        <div class="collapse-divider"></div>
                                        <h6 class="collapse-header">Reports:</h6>
                                         <a class="collapse-item" href="{{ route('jupebPaymentReport') }}">Download JUPEB Payment </a>
                                         <a class="collapse-item" href="{{ route('downloadPDSPayment') }}">Download PDS Payment </a>
                                         <a class="collapse-item" href="{{ route('pdsPaymentList') }}">PDS Payment </a>
                                         <a class="collapse-item" href="{{ route('downloadJupebPayment') }}">Download JUPEB Payment </a>
                                         <a class="collapse-item" href="{{ route('jupebPaymentList') }}">JUPEB Payment </a>
                                         <a class="collapse-item" href="{{ route('ExportPDSJUPApplication') }}">Download Applications</a>
                                         <a class="collapse-item" href="{{ route('getCandidateData') }}">View Applicants</a>
                                       <!-- <a class="collapse-item" href="">Upload Admission List</a> -->
                                   
                                @elseif($rol[0]->roleid == 3)
                                        <a class="collapse-item" href="{{ route('ExportPDSJUPApplication') }}">Download Applications</a>
                                        <a class="collapse-item" href="{{ route('getCandidateData') }}">View Applicants</a>

                                @endif
                         
                                
                     @elseif($rol && $rol[0]->section=="PartTime")
                                 @if($rol[0]->roleid == 2)<!--Admin  -->
                                        <a class="collapse-item" href="{{ route('createusers') }}">Create User</a>
                                        <a class="collapse-item" href="{{ route('ptRegisteredList') }}">Download PT List </a>
                                      
                                        <div class="collapse-divider"></div>
                                        <h6 class="collapse-header">Reports:</h6>
                                        
                                       <!-- <a class="collapse-item" href="">Upload Admission List</a> -->
                                   
                                @elseif($rol[0]->roleid == 3)
                                     <a class="collapse-item" href="{{ route('ptRegisteredList') }}">Download PT List </a>

                                @endif
                                   
                     @elseif($rol && $rol[0]->section=="PostGraduate")
                                 @if($rol[0]->roleid == 2)<!--Admin  -->
                                        <a class="collapse-item" href="{{ route('createusers') }}">Create User</a>
                                        <a class="collapse-item" href="{{ route('pgApplicantList') }}">Download PG Application List </a>
                                        <a class="collapse-item" href="{{ route('uploadPGAdmission') }}">Upload PG Admission</a>
                                        <div class="collapse-divider"></div>
                                        <h6 class="collapse-header">Reports:</h6>
                                        
                                       <!-- <a class="collapse-item" href="">Upload Admission List</a> -->
                                   
                                @elseif($rol[0]->roleid == 3)
                                     <a class="collapse-item" href="{{ route('pgApplicantList') }}">Download PG List </a>
                                     <a class="collapse-item" href="{{ route('uploadPGAdmission') }}">Upload PG Admission</a>
                                @endif           
                                
                     @elseif($rol && $rol[0]->section=="Support")
                       
                       
                        <a class="collapse-item" href="{{ route('ticketList') }}">Support Ticket</a>
                        <a class="collapse-item" href="{{ route('getTransaction') }}">Transactions</a>
                        <a class="collapse-item" href="{{ route('sendEmail') }}">Send Email</a>
                        <!--Addmission Section -->
                     
                      @elseif($rol && $rol[0]->section=="Bursary")
                            <a class="collapse-item" href="{{ route('paymentReport') }}">Payment Report</a>

                  

                     
                     @elseif($rol && $rol[0]->section=="Admission")
                           
                            @if($rol[0]->roleid == 2)<!--Admin  -->
                                  <a class="collapse-item" href="{{ route('createusers') }}">Create User</a>
                                  <a class="collapse-item" href="{{ route('changeUTMEProgramme') }}">Change UTME Programme</a>
                                  <a class="collapse-item" href="{{ route('uploadAdmission') }}">Upload UGD List</a>
                                  <a class="collapse-item" href="{{ route('documentScreening') }}">Document Screening</a>
                                  <a class="collapse-item" href="{{ route('documentScreeningList') }}">Document Screening List</a>
                                  <a class="collapse-item" href="{{ route('paymentReport') }}">Payment Report</a>
                                <div class="collapse-divider"></div>
                                <h6 class="collapse-header">Reports:</h6>
                                    <a class="collapse-item" href="{{ route('postUtmeSummary') }}">PostUTME Summary </a>
                                    <a class="collapse-item" href="{{ route('getPostUTMEList') }}">Download PostUTME </a>
                                    <a class="collapse-item" href="{{ route('GetPostUTMEAllList') }}">Download All PostUTME </a>
                                   @if(Auth::user()->email="osolaosebikan@lautech.edu.ng")
                                       <a class="collapse-item" href="{{ route('downloadPostUTME') }}">Check Post UTME</a>
                                   @endif
                            
                            @elseif($rol[0]->roleid == 3)
                                    <a class="collapse-item" href="{{ route('getPostUTMEList') }}">Download PostUTME </a>
                                    <a class="collapse-item" href="{{ route('GetPostUTMEAllList') }}">Download All PostUTME </a>

                            @elseif($rol[0]->roleid == 4)

                            @endif



                     @endif   
           

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

            

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


            @endif

       

            @if($usr && $usr=="Admin")

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
                         <a class="collapse-item" href="{{ route('home') }}">Home</a>
                          <a class="collapse-item" href="{{ route('studentInfo') }}">Update StudentInfo</a>
                         <a class="collapse-item" href="{{ route('downloadPostUTME') }}">Check Post UTME</a>
                         <a class="collapse-item" href="{{ route('activeUsers') }}">Active Users</a>
                         <a class="collapse-item" href="{{ route('sendEmail') }}">Send Email</a>
                         <a class="collapse-item" href="{{ route('cancelTransaction') }}">Cancel Transaction</a>
                         <a class="collapse-item" href="{{ route('removeChangedProgramme') }}">Remove Programme</a>
                         <a class="collapse-item" href="{{ route('lockAccess') }}">Lock User</a>
                         <a class="collapse-item" href="{{ route('paymentBiodata') }}">Biodata Payment</a>
                         <a class="collapse-item" href="{{ route('ticketList') }}">Ticket</a>
                         <a class="collapse-item" href="{{ route('getTransaction') }}">Transactions</a>
                         <a class="collapse-item" href="{{ route('createusers') }}">Create User</a>
                         <a class="collapse-item" href="{{ route('setCutoff') }}">Set Cutoff</a>
                         <a class="collapse-item" href="{{ route('documentScreening') }}">Document Screening</a>
                         <a class="collapse-item" href="{{ route('documentScreeningList') }}">Document Screening List</a>
                         <a class="collapse-item" href="{{ route('lgaList') }}">Update JUP/PDS LGA</a>
                    
                        <a class="collapse-item" href="{{ route('appactivation') }}">Open/Close App</a>
                        <a class="collapse-item" href="{{ route('examSetup') }}">Exam Setup</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Changes:</h6>
                        <a class="collapse-item" href="{{ route('changeRegisteredProgramme') }}">Change Registered Programme</a>
                        <a class="collapse-item" href="{{ route('changeUTMEProgramme') }}">Change UTME Programme</a>
                           <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Uploads:</h6>
                         <a class="collapse-item" href="{{ route('uploadPTAdmission') }}">Upload PT Admission</a>
                         <a class="collapse-item" href="{{ route('uploadPGAdmission') }}">Upload PG Admission</a>
                        <a class="collapse-item" href="{{ route('uploadBiodataUpdates') }}">Upload Biodata</a>
                        <a class="collapse-item" href="{{ route('uploadAdmission') }}">Upload UGD List</a>
                        <a class="collapse-item" href="{{ route('uploadPDScreeningScore') }}">Upload PDS Results</a>
                        <a class="collapse-item" href="{{ route('uploadpdsResult') }}">Upload Results</a>
                        <a class="collapse-item" href="{{ route('uploadPassport') }}">Upload Passport</a>
                        <a class="collapse-item" href="{{ route('uploadPostUTMEResult') }}">Upload Post UTME</a>
                        <a class="collapse-item" href="{{ route('uploadUtmeInfo') }}">Upload UTME Info</a>
                        <a class="collapse-item" href="{{ route('uploadUTMESubject') }}">Upload UTME Subject</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Reports:</h6>
                        <a class="collapse-item" href="{{ route('pgApplicantList') }}">Download PG List </a>
                        <a class="collapse-item" href="{{ route('jupebPaymentReport') }}">Download JUPEB Payment </a>
                        <a class="collapse-item" href="{{ route('ptRegisteredList') }}">Download PT List </a>
                        <a class="collapse-item" href="{{ route('downloadPDSPayment') }}">Download PDS Payment </a>
                        <a class="collapse-item" href="{{ route('pdsPaymentList') }}">PDS Payment </a>
                        <a class="collapse-item" href="{{ route('paymentReport') }}">Payment Report</a>
                        <a class="collapse-item" href="{{ route('downloadJupebPayment') }}">Download JUPEB Payment </a>
                        <a class="collapse-item" href="{{ route('jupebPaymentList') }}">JUPEB Payment </a>
                        <a class="collapse-item" href="{{ route('postUtmeSummary') }}">PostUTME Summary </a>
                        <a class="collapse-item" href="{{ route('getPostUTMEList') }}">Download PostUTME </a>
                        <a class="collapse-item" href="{{ route('GetPostUTMEAllList') }}">Download All PostUTME </a>

                        <a class="collapse-item" href="{{ route('getCandidateData') }}">PDS/JUPEB View Applicants</a>
                        <a class="collapse-item" href="{{ route('ExportPDSJUPApplication') }}">Download Applications</a>
                        <a class="collapse-item" href="{{ route('viewCandidateInfo') }}">View Record</a>

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
          

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


            @endif
             @if($ispd==0  && $usr=='Candidate' )
              
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('payhistory')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Payment History</span></a>
            </li>
             @endif
              <li class="nav-item">
                <a class="nav-link" href="{{ route('supportPage')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Support</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('changeMyPassword') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Change Password</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    <span>Logout</span></a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, {{ Auth::user()->surname }} {{ Auth::user()->firstname }}</span>
                                @if(Auth::user()->photo)
                                
                                <img class="nav-user-photo" src="{{ asset('public/Passports/'.Auth::user()->photo)}}" alt="Member's Photo" width="80px" height="70px" />
                                @else
                                <img src="../logRegTemp/img/brand/default.png" style="max-width:70px;height:70px;" />
                                @endif



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
                              
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                        <span>Logout</span></a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')


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

</html>