
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
  $ismedical = Auth::user()->ismedical;
  $ict = Auth::user()->isict;
  $apptype = Auth::user()->apptype;
  $p2 =""; $p_2=""; $p3 =""; 
  //dd($ismedical);
  //Fetch Data
  
  $id     = 0; $ids = 0; $amount= 0;$amount1=0; $prod=""; $p4="";$p_4="";
  $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
  $data   = DB::SELECT('CALL FetchFailedPayments(?)', array($matricno));
 
  if($apptype=="JUP" &&  $dat)
  {
    $p_1 =17; #Acceptance Fee
    $p1 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_1));
    $p_3=15;  
    $mgsfull =18;    #FULL MGS =18
    $sciencefull=20; #FULL SCIENCE = 20
    $med =15; #Medical Fee
    #Acceptance Fee
   
    $p3 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($med));
    #Tuition
    $cat = DB::SELECT("CALL GetJUPEBFeeCategory(?)",array($dat[0]->category1));
    if($cat)
    {
        $p_2=$mgsfull;
        $p2 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($mgsfull));
    }
    else
    {
        $p_2=$sciencefull;
        $p2 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($sciencefull));
    }
  }


 if($apptype=="PDS" &&  $dat)
  {
    $p_1 =73; #Acceptance Fee
    $p_4 =77;#ICT
    $p_3=74;//Medical fee  
    //$p3 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($med));
    $mgsfull =75;    #FULL MGS =18
    $sciencefull=76; #FULL SCIENCE = 20
    $med =74; #Medical Fee
    #Acceptance Fee
    $p1 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_1));
    #Medical Fee
    $p3 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($med));
    #ICT Fee
    $p4 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_4));
    #Tuition
    $cat = DB::SELECT("CALL GetCandidateState(?)",array($matricno));
  // dd($cat);
    
    if($cat && ($cat[0]->state=='Oyo State' || $cat[0]->state=='OYO State'))
    {
        $p_2=$mgsfull;
        $p2 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($mgsfull));
    }
    else
    {
        $p_2=$sciencefull;
        $p2 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($sciencefull));
    }
    
    
  }




  $apptype = Auth::user()->apptype;
  $accpt =Auth::user()->isacceptance;
  $istuition =Auth::user()->istuition;

?>
   <!-- Content Row -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payment Dashboard</h1>
    
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



   <?php if($usr=="Student"): ?>                           
        <?php if($accpt=='0' || $accpt=='NULL' || empty($accpt)): ?>   
            <?php if($data): ?>   
                
                <div class="col-lg-12">
                   <div class="p-3">
      
                 
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
                                                                                        <a href="<?php echo e(route('QueryTransactioning', $data->transactionID)); ?>" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                                        </td>

                                                                                    </tr>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>


                 
    
                    </div>
                </div>
                 
            <?php else: ?>
               <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><strong><?php if($p1): ?> <?php echo e($p1[0]->name); ?> <?php endif; ?></strong>                                            </div>
                                    <div class="row no-gutters align-items-center">
                                     <div class="col">     
                                            <?php if($p1 && $p1[0]->status == '1'): ?>
                                            
                                                <div class="col-auto">
                                                        <h7>&#8358;<?php echo e(number_format($p1[0]->amount,2)); ?> </h7>
                                                    <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                        <a href="<?php echo e(route('PayingNow',['id'=>$p_1,'prod'=>$p1[0]->name])); ?>" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Pay Now</span>
                                                    </a>
                                                    <label><a href="" style="color:green ;font-size:12px;"  data-toggle="modal" data-target="#myModal" data-community="" >Read More</a></label>
                                                </div>                                
                                          <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
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
                              
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
         <?php elseif($ismedical=='0'  || $ismedical=='NULL' || empty($ismedical)): ?>
              <?php if($data): ?>   
                
                <div class="col-lg-12">
                   <div class="p-3">
      
                 
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
                                                                                        <a href="<?php echo e(route('QueryTransactioning', $data->transactionID)); ?>" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                                        </td>

                                                                                    </tr>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>


                 
    
                    </div>
                </div>
                 
               <?php else: ?>
               <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><strong><?php if($p3): ?> <?php echo e($p3[0]->name); ?> <?php endif; ?></strong>                                            </div>
                                    <div class="row no-gutters align-items-center">
                                     <div class="col">     
                                            <?php if($p3 && $p3[0]->status == '1'): ?>
                                            
                                                <div class="col-auto">
                                                        <h7>&#8358;<?php echo e(number_format($p3[0]->amount,2)); ?> </h7>
                                                    <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                        <a href="<?php echo e(route('PayingNow',['id'=>$p_3,'prod'=>$p3[0]->name])); ?>" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Pay Now</span>
                                                    </a>
                                                    <label><a href="" style="color:green ;font-size:12px;"  data-toggle="modal" data-target="#myModal" data-community="" >Read More</a></label>
                                                </div>                                
                                          <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
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
                              
                            </div>
                        </div>
                    </div>
                </div>
              <?php endif; ?>
      
        <?php elseif($istuition=='0' || $istuition=='NULL' || empty($istuition)): ?>   
             <?php if($apptype=="JUP"): ?>
               <?php 
                // dd($apptype);
               ?>
                 <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><strong><?php if($p2): ?> <?php echo e($p2[0]->name); ?> <?php endif; ?></strong></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                         <?php if($p2  && $p2[0]->status == '1'): ?>
                                          <div class="col-auto">
                                            <h7>&#8358;<?php echo e(number_format($p2[0]->amount,2)); ?> </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                              
                                              <button type="button" class="btn-block btn" data-toggle="modal" data-target="#myModal"  style="background:#c0a062;color:white">Pay Now </button>
                              
                                           
                                            </div>
                                            <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Tuition Payment Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            <?php endif; ?>

                                        </div>
                                    
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
             <?php elseif($apptype=="PDS"): ?>
               <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><strong><?php if($p2): ?> <?php echo e($p2[0]->name); ?> <?php endif; ?></strong>                                            </div>
                                    <div class="row no-gutters align-items-center">
                                     <div class="col">     
                                             <?php if($p2  && $p2[0]->status == '1'): ?>
                                            
                                                <div class="col-auto">
                                                        <h7>&#8358;<?php echo e(number_format($p2[0]->amount,2)); ?> </h7>
                                                        <button type="button" class="btn-block btn" data-toggle="modal" data-target="#myModal"  style="background:#c0a062;color:white">Pay Now </button>
                              
                                                    </a>
                                                    <label><a href="" style="color:green ;font-size:12px;"  data-toggle="modal" data-target="#myModal" data-community="" >Read More</a></label>
                                                </div>                                
                                          <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
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
                              
                            </div>
                        </div>
                    </div>
                </div>
             <?php endif; ?>
        <!----------ICT--------------------------------------->
          <?php elseif($ict=='0'): ?>
              <?php if($data): ?>   
                
                <div class="col-lg-12">
                   <div class="p-3">
      
                 
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
                                                                                        <a href="<?php echo e(route('QueryTransactioning', $data->transactionID)); ?>" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                                        </td>

                                                                                    </tr>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>


                 
    
                    </div>
                </div>
                 
               <?php else: ?>
               <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><strong><?php if($p4): ?> <?php echo e($p4[0]->name); ?> <?php endif; ?></strong>                                            </div>
                                    <div class="row no-gutters align-items-center">
                                     <div class="col">     
                                            <?php if($p4 && $p4[0]->status == true): ?>
                                            
                                                <div class="col-auto">
                                                        <h7>&#8358;<?php echo e(number_format($p4[0]->amount,2)); ?> </h7>
                                                    <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                        <a href="<?php echo e(route('PayingNow',['id'=>$p_4,'prod'=>$p4[0]->name])); ?>" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Pay Now</span>
                                                    </a>
                                                    <label><a href="" style="color:green ;font-size:12px;"  data-toggle="modal" data-target="#myModal" data-community="" >Read More</a></label>
                                                </div>                                
                                          <?php else: ?>
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
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
                              
                            </div>
                        </div>
                    </div>
                </div>
              <?php endif; ?>
             
        <?php endif; ?>
        
            
 <?php endif; ?>
      



</div> 


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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Select Type of Payment</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="<?php echo e(route('TuitionPay')); ?>">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="id"  value="<?php echo e($p_2); ?>" class="form-control">
                    <input type="hidden" name="prod" value="<?php echo e($p2[0]->name); ?>" class="form-control">
                    <select name="paytype" id="paytype" class="form-control form-control" required>
                             <option value="1">Full</option>
                             <option value="0">Part</option>
                    </select> 
                 <br/>
                    <input type="submit" class="btn  btn-primary" id="payNow" value="Confirm"  style="background:#c0a062;color:white">  
                  </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>








<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/paymentHome.blade.php ENDPATH**/ ?>