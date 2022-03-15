
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $prog = $ulist[0]->programme;
     $u = DB::SELECT('CALL   GetCurrentUserRole(?)', array($staffid));
     $sp  = DB::SELECT('CALL GetSpecialProgramme(?)',array($prog));  
     $ad = DB::SELECT('CALL  FetchDISTINCTUTMESubjectBrochure()');
//dd($ad);
     //dd($u);

?>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('ChangeProgrammes')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-8">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Change Programme</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                             <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">2021/2022 CHANGE OF PROGRAMME </h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Course</th>
                                                                        <th>Cutoff</th>
                                                                        <th>O'level Requirment</th>
                                                                        <th>UTME Requirment</th>
                                                                   
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                    <th>SN</th>
                                                                        <th>Course</th>
                                                                        <th>Cutoff</th>
                                                                        <th>O'level Requirment</th>
                                                                        <th>UTME Requirment</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $dat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($dat->name); ?> </td>
                                                                            <td><?php echo e($dat->cutoff); ?>  </td>  
                                                                            <td> <?php echo e($dat->requirement); ?> </td>
                                                                            <td> <?php echo e($dat->utmerequirement); ?> </td>
                                                                         </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Change Programme </h1>
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

                                                <?php endif; ?>

                                    </div>
                                    <div class="form-group row">
                                        
                                                   <div class="col-sm-12 mb-3 mb-sm-0">
                                                     
                                                         <select name="category1" id="category1" class="form-control form-control" required>
                                                       
                                                            <option value="">Select Programme</option>
                                                                <?php $__currentLoopData = $pro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                     <option value="<?php echo e($pro->name); ?>"><?php echo e($pro->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      
                                                    </select>
                                                    
                                                  </div>

                                            
                                                  


                                          
                                            
                                   </div>
                                   <button class="btn px-4" id="" type="submit" style="background:#c0a062;color:white">Submit</button>

                                    <hr>

                                     
                                     </div>
                               

                                     <?php if($data): ?>
                                              <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Change Programme</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Name</th>
                                                                        <th>Old Programme</th>
                                                                        <th>New Programme</th>
                                                                   
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                       <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Name</th>
                                                                        <th>Old Programme</th>
                                                                        <th>New Programme</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($data->utme); ?> </td>
                                                                            <td><?php echo e($data->surname); ?>  <?php echo e($data->firstname); ?></td>  
                                                                            <td> <?php echo e($data->category1); ?> </td>
                                                                            <td> <?php echo e($data->changeprogramme); ?> </td>
                                                                         </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php endif; ?>
                                                                    





                            </div>
                        </div>
                    </div>
            </form>                               
         </div>


<!-- View Category Price -->
<div class="modal fade" id="myDisplayInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-target=".bd-example-modal-lg">
   <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="edit-modal-label">View Category Type Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
              
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

          
        
            <table id="myTablePrice" class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size:12px">
                <thead>
                    <tr>
                       <th>SN</th>
                       <th>UTME </th>
                       <th>Name</th>
                       <th>Programme</th>
                   
                    </tr>
                </thead>
                <tbody>

                </tbody>
             </table>


        </div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>


<script src="js/jquery-3.3.1.js"></script>
<script type='text/javascript'>
   
    $(document).ready(function()
    {
      $('#utme').change(function()
      {
         k=0;
            var id = $(this).val();
           $.get( "GetAdmissionInformation/" + id, function( data )
             {
                // console.log(id);
                   $('#myTable > tbody > tr').remove();
                    var rows = "";
                    //console.log(data['data'][0].name);
                    if(data['data'] != null)
                    {
                      len = data['data'].length;
                      document.getElementById("btnSubmit").style.display = "block";
                    }
                    else
                    {
                        alert("Record Not Found");
                    }
                     var k=0;
                    for (i = 0; i<len; i++) 
                    {
                        k++;
                     
                       var nam = data['data'][i].name;
                       var utme = data['data'][i].utme;
                       var prog = data['data'][i].programme;
                    }
                    if(nam)
                    {
                        alert(nam +"  "+utme+"  "+prog);
                    }
                   else
                   {
                    alert("Record Not Found");
                   }
                  
            });

      
    });

    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/changeProgramme.blade.php ENDPATH**/ ?>