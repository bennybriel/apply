
<?php $__env->startSection('content'); ?>
<?php
   #Get Progress Registration
   $stgid =1;
   $tu =DB::table('u_g_student_accounts')->select(DB::raw('SUM(amount) AS amount'))
                                         ->where('session',Auth::user()->activesession)
                                         ->orwhere('description','100L INDIGENE FULL')    
                                         ->orwhere('description','100L NON INDIGENE FULL') 
                                         ->orwhere('description','100L INDIGENE HALF (HARMATTAN)')   
                                         ->orwhere('description','100L NON-INDIGENE HALF (HARMATTAN)') 
                                         ->where('ispaid',1)
                                         ->get();

   $acc =DB::table('u_g_student_accounts')->select(DB::raw('SUM(amount) AS amount'))
                                         ->where('session',Auth::user()->activesession)
                                         ->where('description','ACCEPTANCE FEE (UNDERGRADUATE)')    
                                         ->where('ispaid',1)
                                         ->get();
    $med =DB::table('u_g_student_accounts')->select(DB::raw('SUM(amount) AS amount'))
                                         ->where('session',Auth::user()->activesession)
                                         ->where('description','100L Medical')    
                                         ->where('ispaid',1)
                                         ->get();

?>


  <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Bursary Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Total Tuition
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">

                                            
                                        <a href="" class="btn btn-success">
                                           &#8358;<?php echo e(number_format($tu[0]->amount ,2)); ?>

                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                     
                    
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Acceptance Fee
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                              
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bars bg-infos" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="" class="btn btn-success">
                                                &#8358;<?php echo e(number_format($acc[0]->amount ,2)); ?>

                                             </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example-->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                              Medical Fee</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="" class="btn btn-success">
                                                &#8358;<?php echo e(number_format($med[0]->amount ,2)); ?>

                                             </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <!-- Content Row -->

                   

                    <!-- Content Row -->
                    <div class="row">

                        

                       
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
<?php $__env->stopSection(); ?>
<?php 
 
  function RegistrationStatus($mat,$sid)
  {
     $stag = DB::table('ptregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',$sid)
                                              ->first();  
                                            
     if($stag)
     {
        if($stag->status=="1")
        {
           return true;
        }
        else
        {
            return false;
        }
     }
     else
     {
        return 0;
     }
  }
  function NextStageStatus($mat,$sid)
  {
     $stag = DB::table('ptregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',1)
                                              ->first();   //DB::SELECT('CALL GetRegistrationStatus(?,?)',array($mat,$sid));
     if($stag)
     {
        if($stag->status=="1")
        {
           return true;
        }
        else
        {
            return false;
        }
     }
     else
     {
        return 0;
     }
  }
?>
<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/bursaryHome.blade.php ENDPATH**/ ?>