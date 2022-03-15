
<?php $__env->startSection('content'); ?>

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
    $today = date("Y-m-d");
    $ck = DB::SELECT('CALL	FetchApplicationOpenInfo()');
    //dd($ck);
    foreach($ck as $item)
    {
        if($today > $item->closedate)
        {
            DB::UPDATE('CALL UpdateClosingStatus(?)',array($item->id));
        }
    }

  $amt=0;
  $ses = Auth::user()->activesession;
  $matricno = Auth::user()->matricno;
  $usr =   Auth::user()->usertype;
  $ispd = Auth::user()->ispaid;
  $isadm = Auth::user()->isadmitted;
  //Fetch Data
  
  $id     = 0; $ids = 0; $amount= 0;$amount1=0; $prod="";
  $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
  $data   = DB::SELECT('CALL FetchFailedPayments(?)', array($matricno));
  $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)', array($matricno));
  $p_1 =1;$p_2 =6; $p_3=10;$p_4=14; $p_5=12;$p_6=9; 
  $p3=0;$p4=0;$p5=0;$p6=0;
  $p1    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_1));
  $p2    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_2));
  $p3    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_3));
  $p4    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_4));
  $p5    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_5));
  $p6    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_6));
  $apptype = Auth::user()->apptype;
 // dd($p4);
  //Call Products
  $rol = DB::SELECT('CALL GetCurrentUserRole(?)', array($matricno));
   // dd($rol);
  //$datas    = DB::SELECT('CALL FetchApplicationListing()');
?>
   <!-- Content Row -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admission Dashboard</h1>
    
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Hello <i
            class="fas fa-info fa-sm text-white-50"></i> <?php echo e(Auth::user()->name); ?> <?php echo date("l, dS-M-Y") ?></a>
</div>

<!-- Content Row -->
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
<div class="row">
   <?php if($usr=="Candidate"): ?>                           
        <?php if($ispd==false && Auth::user()->formumber==''): ?>       
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><strong><?php if($p1): ?> <?php echo e($p1[0]->name); ?> <?php endif; ?></strong>                                            </div>
                                    <div class="row no-gutters align-items-center">
                                     <div class="col">     
                                            <?php if($p1 && $p1[0]->status == true): ?>
                                            
                                                <div class="col-auto">
                                                        <h7>&#8358;<?php echo e(number_format($p1[0]->amount,2)); ?> </h7>
                                                    <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                        <a href="<?php echo e(route('PayNow',['id'=>$p_1,'prod'=>$p1[0]->name])); ?>" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Pay Now</span>
                                                    </a>
                                                    <label><a href="" style="color:green ;font-size:12px;"  data-toggle="modal" data-target="#myModal" data-community="" >Read More</a></label>
                                                </div>                                
                                           
                                            <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Admission Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            <?php endif; ?>
                                        </div> 
                                    
                                    </div>
                                </div>
                               <!-- <a href="#" class="btn btn-sm btn-warning">Closes in  <i
                    class="fas fa-info fa-sm text-white-50"></i><p id="demo"></p></a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><strong><?php if($p2): ?> <?php echo e($p2[0]->name); ?> <?php endif; ?></strong></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                         <?php if($p2  && $p2[0]->status == true): ?>
                                          <div class="col-auto">
                                            <h7>&#8358;<?php echo e(number_format($p2[0]->amount,2)); ?> </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="<?php echo e(route('PayNow',['id'=>$p_2,'prod'=>$p2[0]->name])); ?>"
                                                                            class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Pay Now</span>
                                            </a>
                                            <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                            </div>
                                            <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Admission Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            <?php endif; ?>

                                        </div>
                                    
                                    </div>
                                </div>
                                <!--
                                <div class="col-auto">
                                <a href="#" class="btn btn-sm btn-warning">Closes in  <i
                    class="fas fa-info fa-sm text-white-50"></i><p id="demo1"></p></a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="color:red"><strong>POST UTME Application</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                        <?php if($p3 && $p3[0]->status == true): ?>    
                                            <div class="col-auto">
                                    
                                            <h7>&#8358;<?php echo e(number_format($p3[0]->amount,2)); ?> </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                            <button type="button" class="btn" data-toggle="modal" data-target="#myModal"  style="background:#c0a062;color:white">Pay Now </button>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    <?php else: ?>
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="<?php echo e(route('ugbiodata')); ?>" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text"> Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    <?php endif; ?>
                                        </div>
                                    
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="color:red"><strong>DE Application</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                        <?php if($p4 && $p4[0]->status == true): ?>    
                                            <div class="col-auto">
                                    
                                            <h7>&#8358;<?php echo e(number_format($p4[0]->amount,2)); ?> </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                            <button type="button" class="btn" data-toggle="modal" data-target="#deModal"  style="background:#c0a062;color:white">Pay Now </button>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    <?php else: ?>
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="<?php echo e(route('ugbiodata')); ?>" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text"> Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    <?php endif; ?>
                                        </div>
                                    
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" style="color:red">
                                    <strong>POST GRADUATE Application</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                            
                                    <?php if($p6 && $p6[0]->status == true): ?>    
                                            <div class="col-auto">
                                    
                                            <h7>&#8358;<?php echo e(number_format($p6[0]->amount,2)); ?> </h7>
                                                      <a href="<?php echo e(route('PayNow',['id'=>$p_6,'prod'=>$p6[0]->name])); ?>" class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Pay Now</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    <?php else: ?>
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                   
                                                <a href="<?php echo e(route('ugbiodata')); ?>" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    <?php endif; ?>
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          

        <?php endif; ?>
        <?php if(Auth::user()->ispaid == true && Auth::user()->iscomplete==true): ?>
        
                <?php if($dat): ?>
                        <div style="overflow-x:auto; ">
                                <table width="698" border="0" align="center">
                            <thead>
                                <tr>
                                
                                    <td width="132" class="noBorder" >Student Name</td>
                                    <td width="369" class="noBorder1"><?php echo e(Auth::user()->name); ?></td>
                                </tr>
                                <tr>
                                    <td class="noBorder">Form Number</td>
                                    <?php if($apptype=="UGD" || $apptype=="DE" || $apptype=="TRF"): ?>
                                      <td class="noBorder1"><?php echo e(Auth::user()->utme); ?></td>
                                    <?php else: ?>
                                      <td class="noBorder1"><?php echo e(Auth::user()->formnumber); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                <td class="noBorder">Category 1 </td>
                                    <td class="noBorder1"><?php echo e($dat[0]->category1); ?></td>
                                </tr>

                                <tr>
                                <td class="noBorder">Category 2 </td>
                                    <td class="noBorder1"><?php echo e($dat[0]->category2); ?></td>
                                </tr>

                                <tr>
                                <td class="noBorder">Session </td>
                                    <td class="noBorder1"><?php echo e($dat[0]->session); ?></td>
                                </tr>

                                <tr>
                                <td class="noBorder">Email</td>
                                    <td class="noBorder1"><?php echo e($dat[0]->email); ?></td>
                                </tr>
                                <tr>
                                <td class="noBorder">Phone</td>
                                    <td class="noBorder1"><?php echo e($dat[0]->phone); ?></td>
                                </tr>
                                <tr>
                                <td class="noBorder">Date of Birth</td>
                                    <td class="noBorder1"> <?php echo e(Carbon::parse($dat[0]->dob)->format('d-m-Y')); ?></td>
                                </tr> 
                                <tr>
                                <td class="noBorder">State of Orgin</td>
                                    <td class="noBorder1"><?php echo e($dat[0]->state); ?></td>
                                </tr>
                                </thead>
                        </table>
                    </div>
                <?php endif; ?>
        <?php elseif(Auth::user()->ispaid == true && Auth::user()->iscomplete==false): ?>
          
          <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1" style="color:red">Click To Start Registration Or Continue With Registration                                           </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div>
                               
                            </div>
                            <div class="col">
                            <?php if($apptype =="UGD" || $apptype =="DE" || $apptype =="TRF"): ?>
                                    <a href="<?php echo e(route('validateUTME')); ?>" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                        Validate UTME     
                                    </a>
                                <?php elseif($apptype =="PDS" || $apptype =="JUP"): ?>
                                    <a href="<?php echo e(route('ugbiodata')); ?>" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                    Registration
                                </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('pgdataPage')); ?>" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                       Registration
                                    </a>
                                <?php endif; ?>
                                <br/>
                                <!--
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 10%" aria-valuenow="10" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        
                    </div>
                </div>
            </div>
          </div>
          </div>
         <?php endif; ?>
    <?php endif; ?>
    
   
</div> 

<?php if(Auth::user()->isadmitted == true ): ?>
     <?php if(Auth::user()->isacceptance==true): ?>
         <div class="alert alert-success">
             <p>Congratulations!!!</p>
            <p>Your Acceptance Fee Payment Was Successful. Please Check Payment History</p>
        </div>
    <?php endif; ?>

         <a href="<?php echo e(route('paymentHome')); ?>" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Proceed To Payment Page</span>
                                                    </a>
    <?php endif; ?>

   <div class="col-lg-12">
      <div class="p-3">
      <?php if($ispd==0): ?>
         <?php if($data): ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                <div class="alert alert-danger">
                        Payment Transaction Failed
                 </div>
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Failed Payment Record</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Session</th>
                                    <th>Amount</th>                        
                                    <th>PaymentType</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                            </thead>
                             
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($data->session); ?></td>
                                                                            <td>&#8358;<?php echo e(number_format($data->amount,2)); ?></td>
                                                                          
                                                                            <td><?php echo e($data->description); ?></td>
                                                                            <td><?php echo e(Carbon::parse($data->created_at)->format('d-m-Y,h:m:s A')); ?></td>
                                                                            <td> 
                                                                              
                                                                              <?php if($data->response): ?>
                                                                              
                                                                                <span style="color:red"><?php echo e($data->response); ?></span>
                                                                              <?php else: ?>
                                                                              <span style="color:red">Pending</span>
                                                                              <?php endif; ?>
                                                                            </td> 
                                                                            <td> 
                                                                              <a href="<?php echo e(route('QueryTransaction', $data->transactionID)); ?>" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                             </td>

                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                             <h6 style="color:#da251d">Please Click Pay Now, Below To Try Again  </h6>
                                                        </div>
                                                    </div>
                                                </div>


         <?php endif; ?>
      <?php endif; ?>
</div>
</div>
<?php if($usr=="Staff" && $rol && $rol[0]->section=="Admission"): ?>
    <?php
        $tutme =DB::SELECT('CALL FetchTotalUTME()');
        $tde =DB::SELECT('CALL FetchTotalDE()');
        $reg = DB::SELECT('CALL GetRegisteredApplicants()');
        $apl = DB::SELECT('CALL GetPaidApplicants()');
    ?>
<div class="container-fluid">
    <div class="row">
    
    <!-- Earnings (Monthly) Card Example -->
            <?php if($tutme): ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Uploaded UTME</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($tutme[0]->utme,0)); ?>

                                
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($reg ): ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Registered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo e(number_format($reg[0]->ugd,0)); ?>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($tde): ?>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total DE Uploaded</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($tde[0]->de,0)); ?>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($reg): ?>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total DE Registered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($reg[0]->de,0)); ?>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
  
    </div> 

<?php endif; ?>
   <?php if($usr=="Admin"): ?> 
   <?php
      $tutme =DB::SELECT('CALL FetchTotalUTME()');
      $tde =DB::SELECT('CALL FetchTotalDE()');
      $reg = DB::SELECT('CALL GetRegisteredApplicants()');
      $apl = DB::SELECT('CALL GetPaidApplicants()');
   ?>
   <div class="container-fluid">
   <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <?php if($tutme): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Uploaded UTME</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($tutme[0]->utme,0)); ?>

                            
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($reg ): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($reg[0]->ugd,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($tde): ?>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total DE Uploaded</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($tde[0]->de,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($reg): ?>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total DE Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($reg[0]->de,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>


<!-- Earnings (Monthly) Card Example -->
        <?php if($apl): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PDS Total Paid Applicant</div>
                            <div class="h5 mb-0 font-weight-bold text-info">
                            <?php echo e(number_format($apl[0]->pds,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($apl): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PDS Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-info">
                            <?php echo e(number_format($reg[0]->pds,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Pending Requests Card Example -->
        <?php if($apl): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            JUPEB Total Paid Applicant</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($apl[0]->jup,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($reg): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            JUPEB Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e(number_format($reg[0]->jup,0)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

              <img src="logRegTemp/img/brand/admin.jpg" style="max-width:100%;height:auto;"/>
 <?php endif; ?>

</div> 


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Please Validate Your UTME No.</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="<?php echo e(route('CheckUTME')); ?>">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="id"  value="<?php echo e($p_3); ?>" class="form-control">
                    <input type="hidden" name="prod" value="<?php echo e($p3[0]->name); ?>" class="form-control">
                    <input type="text" name="utme" class="form-control" placeholder="Enter UTME">
                    <br/>
                    <input type="submit" class="btn btn-primary" id="payNow" value="Validate">    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>    

<div class="modal fade" id="deModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Please Validate Your UTME No.</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="<?php echo e(route('CheckDE')); ?>">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="id"  value="<?php echo e($p_4); ?>" class="form-control">
                    <input type="hidden" name="prod" value="<?php echo e($p4[0]->name); ?>" class="form-control">
                    <input type="text" name="utme" class="form-control" placeholder="Enter UTME">
                    <br/>
                    <input type="submit" class="btn btn-primary" id="payNow" value="Validate">    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 



 <script>
// Set the date we're counting down to
var countDownDate = new Date("Nov 30, 2021 23:59:59").getTime();
var countDownDate1 = new Date("Oct 31, 2021 23:59:59").getTime();
// Update the count down every 1 second
var x = setInterval(function() 
{

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;
  var distance1 = countDownDate1 - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  // Time calculations for days, hours, minutes and seconds
  var days1 = Math.floor(distance1 / (1000 * 60 * 60 * 24));
  var hours1 = Math.floor((distance1 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes1 = Math.floor((distance1 % (1000 * 60 * 60)) / (1000 * 60));
  var seconds1 = Math.floor((distance1 % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "days " + hours + "hours "
  + minutes + "mins " + seconds + "secs ";

  // Display the result in the element with id="demo"
  document.getElementById("demo1").innerHTML = days1 + "days " + hours1 + "hours "
  + minutes1 + "mins " + seconds1 + "secs ";

  // If the count down is finished, write some text
  if (distance < 0)
   {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }

  if (distance1 < 0)
   {
    clearInterval(x);
    document.getElementById("demo1").innerHTML = "EXPIRED";
  }
}, 1000);
</script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WebApps\ApplyApp\resources\views/home.blade.php ENDPATH**/ ?>