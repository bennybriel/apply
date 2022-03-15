
<?php $__env->startSection('content'); ?>

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
 // dd($data);
     $utme = session('utme');
     //dd($utme);
     $data = DB::table('admission_lists')->where('utme',$utme)->first();
     $dat = DB::table('users')->where('utme',$data->utme)->first();
     $dat1 = DB::table('u_g_pre_admission_regs')->where('utme',$data->utme)->first();
 
?>
    <br/> 
    <div class="container">
    <br/> 
        <div class="row">
             <div class="col-4">
             </div>
             <div class="col-6">
                <img src="logRegTemp/img/brand/logo_predegree1.png" style="max-width:100%;height:auto;"/>
             </div>
          </div>
   <?php if($data): ?>
   <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
             <div class="p-5">
          <div style="overflow-x:auto; ">
                   <h3 style="color:red">Congratulations!!!, You have been offered Admission</h3>
                <table width="830" border="0" align="center">
               <thead>
                 <tr>
                   <td width="232" rowspan="10" class="noBorder" >
				    <?php if($dat): ?>
				       <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.$dat->photo)); ?>" alt="image" width="183" height="200px" /></td>
				     <?php else: ?>
				       <img class="nav-user-photo" src="<?php echo e(asset('public/Passports/'.$dat1->photo)); ?>" alt="image" width="183" height="200px" /></td>
                    <?php endif; ?>
                    <td width="171" class="noBorder" >Student Name</td>
                    <td width="413" class="noBorder1"><b><?php echo e($data->name); ?></b></td>
                 </tr>
                  <tr>
                    <td class="noBorder">UTME Registration No.</td>
                    <td class="noBorder1"><b><?php echo e($data->utme); ?></b></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Department</td>
                    <td class="noBorder1"><b><?php echo e($data->programme); ?></b></td>
                 </tr>

                 <tr>
                   <td class="noBorder">Session </td>
                    <td class="noBorder1"><b><?php echo e($data->session); ?></b></td>
                 </tr>

                

                
                 
                
                 </thead>
          </table>
       </div>
  <?php endif; ?>
       <br/>
                <input type="hidden" name="utme" value="<?php echo e($utme); ?>" />
               <div class="col-lg-6">
                    
                    <div class="form-group row">
                         <div class="col-sm-3 mb-3 mb-sm-0">
                         </div>
                         <div class="col-sm-3 mb-3 mb-sm-0">
                               <a href="<?php echo e(route('logons')); ?>" style="background:green;color:#FFF" class="btn">Continue</a>
                            </div>
                   
                           
                         </div>
                         <div class="col-sm-3 mb-3 mb-sm-0">
                         </div>
                    </div>
                 </div>
          
</div>
</div>
</div></div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.appfront1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/displayAdmissionStatus.blade.php ENDPATH**/ ?>