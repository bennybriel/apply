
<?php $__env->startSection('content'); ?>
<?php
   $matricno = Auth::user()->matricno;
   $utme =Auth::user()->utme;
   $stag = DB::SELECT('CALL FetchRegistrationStage()');
   $tu = DB::SELECT('CALL GetUGTuition(?)',array($st));;
   //Allocate Biodata Hall


   $startdate = date_create(date('Y-m-d'));
   $startdate = date_add($startdate, date_interval_create_from_date_string("1 days"));
  // dd($startdate);
   $med =GetMedicalPaymentStatus($utme);
   //$startdate = date($startdate, strtotime("+2 days"));
   // dd($startdate);
   //$date = date_create("2019-05-10");
  // Use date_add() function to add date object
   
   // dd($startdate);

    $dates = "Wednesday";
   if($med == true)
   {
       #Get last record 
       $lrec = DB::SELECT('CALL GetLastBiodataUpdateBatching()');
      
       if($lrec)
       {
            $ldate =$lrec[0]->batchdate; 
            $ca= DB::SELECT('CALL BiodataUpdateCounter(?)',array($ldate));
            if($ca && $ca[0]->counter == 2)
            {
              $ldate = date_create($ldate);
              $startdate = date_add($ldate, date_interval_create_from_date_string("1 days"));
              $dates = "Thursday";
            }
            else
            {
                $startdate = $ldate;
            }
            //Start Batching 
            $hs = DB::SELECT('CALL GetRegisteredBiodata()');
            $a =$hs[0]->mulika; $b =$hs[0]->oldict; $c= $hs[0]->zenith;
            $hn = min($a,$b,$c);
            if($a==$hn) $hall =1; if($b==$hn) $hall =2; if($c==$hn) $hall =3; 
            //dd($startdate);
            $ck = DB::SELECT('CALL CheckDuplicateBiodataBatching(?)',array($utme));
            if(!$ck)
            {
                $sav = DB::INSERT('CALL SaveBiodataBatchingUpdate(?,?,?,?)',array($utme,$hall,$startdate,$dates));
            }
        }

   }

 function isWeekend($date)
   {
    $weekDay = date('w', strtotime($date));
    dd($weekDay);
    return ($weekDay == 0 || $weekDay == 6);
 }
?>

                <!-- Begin Page Content -->
              
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                     <?php if(Auth::user()->isletter=='0'): ?>       
                         <?php if($stag): ?>
                           <!--  Acceptance Fee -->
                   
                           <?php $__currentLoopData = $stag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($items->stageid == '1'): ?>
                                  <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card <?php echo e($items->cardcolor); ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   <?php echo e($items->name); ?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                    <span style="color:red">Pending</span>
                                                <?php else: ?>
                                                  <?php if($items->stageid=='1'): ?>
                                                      <?php  //UpdateIsLetterPay($matricno)  ?>
                                                       <a href="<?php echo e(route('admissionLetterUGD')); ?>" class="btn btn-success">
                                                           <span class="text">Download </span>
                                                        </a>
                                                  <?php endif; ?>
                                                    <span style="color:green">Completed</span>
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                           
                                            <div class="col-auto">
                                              <?php if(RegistrationStatus($matricno,$items->stageid)==false): ?>
                                                    <a href="<?php echo e(route('UGDPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid])); ?>" class="btn btn-success">
                                                           
                                                            <?php if($items->ispay=='1'): ?>
                                                            <span class="text">Pay &#8358;<?php echo e(number_format($items->amount,2)); ?></span>
                                                            <?php else: ?>
                                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                                           <?php endif; ?>
                                                        </a>
                                              <?php endif; ?>        
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            
                          <?php endif; ?>
                      <?php endif; ?> 
                      
                     <?php if($stag): ?>  
                        <?php $__currentLoopData = $stag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card <?php echo e($item->cardcolor); ?> shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               <?php echo e($item->name); ?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php if(RegistrationStatus($matricno,$item->stageid)==false): ?>
                                                <span style="color:red">Pending</span>
                                            <?php else: ?>
                                              <?php if($item->stageid=='1'): ?>
                                                  <?php  ///UpdateIsLetterPay($matricno)  ?>
                                                        <a href="<?php echo e(route('admissionLetterUGD')); ?>" class="btn btn-success">
                                                           <span class="text">Download </span>
                                                        </a>
                                              <?php else: ?>
                                                <span style="color:green">Completed</span>
                                              <?php endif; ?>
                                                
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                       
                                <div class="col-auto">
                                       <?php if(Auth::user()->isletter=='1'): ?> 
                                          <?php if(RegistrationStatus($matricno,$item->stageid)==false): ?>
                                                       
                                                        <?php if($item->ispay=='1' && $item->amount > 0): ?>
                                                        
                                                                    <?php if($item->stageid == 4 && GetMedical($item->stageid)==true): ?>
                                                                        <a href="<?php echo e(route('UGDPayNow',['id'=>$item->productid,'prod'=>$item->name,'sid'=>$item->stageid])); ?>" class="btn btn-success">
                                                                        <span class="text">Pay &#8358;<?php echo e(number_format($item->amount,2)); ?></span>
                                                                        </a>
                                                                      
                                                                    <?php else: ?>
                                                                        <i class="fas fa-user fa-2x text-gray-300"></i>
                                                                    <?php endif; ?>
                                                                   
                                                        <?php else: ?>
                                                                   <?php if($item->stageid==7 && $med==true): ?>
                                                                         <a href="<?php echo e(route('BiodataBatchingClearance')); ?>" class="btn btn-success">
                                                                             <span class="text">Download Clearance</span>
                                                                         </a>
                                                                   <?php else: ?>
                                                                      <i class="fas fa-user fa-2x text-gray-300"></i>
                                                                   <?php endif; ?>
                                                         <?php endif; ?>
                                                    
                                          <?php endif; ?>        
                                        <?php endif; ?>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        
                    <?php endif; ?>
                    <?php if(BeforeNextStage(Auth::user()->utme) == true): ?>
                        <?php if($tu): ?>
                            <?php $__currentLoopData = $tu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card <?php echo e($item->cardcolor); ?> shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                  <?php echo e($item->name); ?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php if(RegistrationStatus($matricno,$item->stageid)==false): ?>
                                                    <span style="color:red">Pending</span>
                                                <?php else: ?>
                                                    <?php if($item->stageid=='1'): ?>
                                                        <?php // UpdateIsLetterPay($matricno)  ?>
                                                            <a href="<?php echo e(route('admissionLetterUGD')); ?>" class="btn btn-success">
                                                                <span class="text">Download </span>
                                                              </a>
                                                    <?php else: ?>
                                                      <span style="color:green">Completed</span>
                                                    <?php endif; ?>
                                                    
                                                <?php endif; ?>
                                                </div>
                                            </div>
                                          
                                            <div class="col-auto">
                                          <?php if(Auth::user()->isletter=='1'): ?> 
                                          
                                                    <?php if(RegistrationStatus($matricno,$item->stageid)==false): ?>
                                                            <?php if($item->ispay=='1' && $item->amount > 0): ?>
                                                              <a href="<?php echo e(route('UGDPayNow', ['id'=>$item->productid,'prod'=>$item->name,'sid'=>$item->stageid])); ?>" 
                                                                                              class="btn btn-success">
                                                                  <button type="button" class="btn" data-toggle="modal" data-target="#myModal"  style="background:#c0a062;color:white">Pay Now </button>                             
                                                                 
                                                                  <button type="button" class="btn btn-success"
                                                                          id="edit-item" 
                                                                          data-item-id="<?php echo e($item->productid); ?>" 
                                                                          data-item-name="<?php echo e($item->name); ?>"> Pay Now </button>                             
                                                                         <span class="text">Pay &#8358;<?php echo e(number_format($item->amount,2)); ?></span>
                                                                  </a>
                                                            <?php else: ?>
                                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                                          <?php endif; ?>
                                                    <?php endif; ?>
                                              
                                          <?php endif; ?>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        <?php endif; ?>
                    <?php endif; ?>
                      
                    <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                 Download Medical Data</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                               
                                                
                                                      <a href="documents/medical.pdf" class="btn btn-danger">
                                                                <span class="text">Download </span>
                                                      </a>
                                                   
                                                    
                                            
                                                </div>
                                            </div>
                                          
                                            <div class="col-auto">
                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




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
                <form method="post" action="<?php echo e(route('UGDTuitionPay')); ?>">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="id"  value="" class="form-control">
                    <input type="hidden" name="prod" value="" class="form-control">
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






<!---Support Note---->
 <div class="modal fade" id="myModalSupport" role="dialog">
             <div class="modal-dialog">
             <!-- Modal content-->
               <div class="modal-content">
             
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="card-header">
                       <h4 class="m-0" style="color:brown;text-align:center;">Portal Support System</h4>
                         <p style="text-align:justify">
                                                   Welcome to the Support Ticket Page. The following are the steps to follow:<br/>
                                                        <b style="color:red">Note: Click on Support Menu at the left-hand-side of the portal to begin.
                                                        All requests will be proceed from this page. Any complain not from this page may be not processed</b><br/>
                                                        1. Select portal e.g apply or transcript or undergrate portal <br/>
                                                        2. Select application e.g PDS, JUP, Post graduate or Post UTME registration<br/>
                                                        3. Select category of complains e.g payment, or biodata or course registration<br/>
                                                        4. Enter the subject for the complain<br/>
                                                        5. Enter details of what happened and what you are requesting for.<br/>
                                                        6. if there is any image for clarification please upload. Note. It is optional NOT complusory<br/>
                                                        7. Click on Submit button<br/>
                                                        8. You will receive ticket confirmation in your email address. And you are to wait patiently
                                                        for the complain to be processed within 48-hours<br/>
                                                        NOTE: DO NOT OPEN MULTIPLE TICKETS ON A SINGLE ISSUE
 
                                                  </p>
                  </div>
                 
                <div class="modal-body">
                     
                <h5>  </h5>
                </div>
               <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
             </div>  

<script src="js/jquery-3.3.1.js"></script>
<script>
	$(document).ready(function(){
     	$("#myModalSupport").modal('show');
	});
</script>
<?php $__env->stopSection(); ?>

<?php 
function GetMedicalPaymentStatus($utme)
{
    
    $mat = Auth::user()->utme;
    $stag = DB::SELECT('CALL GetMedicalPaymentStatus(?)',array($utme));
    if($stag)
    {
      if($stag[0]->status=="1")
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
 function GetMedical()
 {
     $mat = Auth::user()->utme;
     $stag = DB::SELECT('CALL GetMedicalPayment(?)',array($mat));
    if($stag)
    {
       if($stag[0]->status=="1")
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

 
 function BeforeNextStage($mat)
 {
    $st = DB::SELECT('CALL GetNextStage(?)',array($mat));
    if($st  && $st[0]->status==1)
    {
      return true;
    }
    else
    {
        return false;
    }
 }
 function UpdateIsLetterPay($mat)
 {
    DB::UPDATE('CALL UpdateIsLetter(?)',array($mat));
 }
  function RegistrationStatus($mat,$sid)
  {
     $stag = DB::SELECT('CALL GetRegistrationStatus(?,?)',array($mat,$sid));
     if($stag)
     {
        if($stag[0]->status=="1")
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
<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/admissionHome.blade.php ENDPATH**/ ?>