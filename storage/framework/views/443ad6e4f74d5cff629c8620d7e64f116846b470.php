
<?php $__env->startSection('content'); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
              
                    <div class="row">
              
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        <?php if($data): ?>
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Change Applicant Programme</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Name</th>
                                                                        <th>Score</th>
                                                                        <th>Programme</th>
                                                                        <th>Action</th>
                                                                      

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Name</th>
                                                                        <th>Score</th>
                                                                        <th>Programme</th>
                                                                        <th>Action</th>
                                                                     </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e(++$i); ?></td>
                                                                            <td><?php echo e($data->utme); ?></td>
                                                                            <td><?php echo e($data->name); ?></td>
                                                                            <td><?php echo e($data->totalscore); ?></td>
                                                                            <td><?php echo e($data->programme); ?></td>
                                                                           
                                                                             <td>
                                                                                <button type="button" class="btn btn-success" id="edit-item" data-item-id="<?php echo e($data->utme); ?>" 
                                                                                  data-item-name="<?php echo e($data->name); ?>" data-item-total="<?php echo e($data->totalscore); ?>" 
                                                                                  data-item-programme="<?php echo e($data->programme); ?>" >Update</button>                                                                             

                                                                            </td>
                                                                   
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
                    </div>
           
        </div>

      <!-- Attachment Modal -->
      <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label" style="color:red">Change UTME Programme</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
      
        <form  class="form-horizontal" id="edit-form" method="POST" action="<?php echo e(route('UpdateProgramme')); ?>">
           <?php echo e(csrf_field()); ?>

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
          <div class="card text-black bg-white mb-0">
            <div class="card-header">
              <h2 class="m-0" style="color:brown">Change Programme</h2>
            </div>
            <div class="card-body">
              <!-- id -->
              
               
              
              <!-- /id -->
              <!-- name -->
              
              <!-- /name -->
              <!-- description -->
              <div class="form-group row">
                 <div class="col-sm-3 mb-3 mb-sm-0"> <label>Current Programme</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" name="cprogramme" class="form-control form-control" id="cprogramme" readonly>
                    </div>                                     
               </div>
              <div class="form-group row">
                 <div class="col-sm-3 mb-3 mb-sm-0"> <label>UTME Number</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        
                         <input type="text" name="utme" class="form-control form-control" id="utme" readonly>
                    </div>                                     
               </div>
               <div class="form-group row">
                   <div class="col-sm-3 mb-3 mb-sm-0"> <label>Name</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                      
                         <input type="text" name="name" class="form-control form-control" id="name" readonly>
                    </div>                                     
               </div>
               <div class="form-group row">
               <div class="col-sm-3 mb-3 mb-sm-0"> <label>UTME Score</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                     
                         <input type="text" name="totalscore" class="form-control form-control" id="totalscore" readonly>
                    </div>                                     
               </div>
              
               <div class="form-group row">
           
                     <div class="col-sm-3 mb-3 mb-sm-0"><label>Programme</label></div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                     <select name="programme" id="programme" class="form-control form-control" required>
                                                    
                        <option value="">Select New Programme</option>
                                <?php $__currentLoopData = $p; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($p->name); ?>"><?php echo e($p->name); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>                                     
               </div>


              <!-- /description -->
            </div>
          </div>
          <div class="modal-footer">
             <input type="submit" class="btn btn-success" value="Update Now">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
        </form>
      </div>
     
    </div>
  </div>
</div>




<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  /**
   * for showing edit item popup
   */

  $(document).on('click', "#edit-item", function() {
    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function() {
    var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var id = el.data('item-id');
    var name = row.children(".name").text();
    var nameid     = el.data('item-name');
    var totalscore = el.data('item-total');
    var cprogramme = el.data('item-programme');

    // fill the data in the input fields
    $("#utme").val(id);
    $("#name").val(nameid);
    $("#totalscore").val(totalscore);
    $("#cprogramme").val(cprogramme);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\admissions\resources\views/changeUTMEProgramme.blade.php ENDPATH**/ ?>