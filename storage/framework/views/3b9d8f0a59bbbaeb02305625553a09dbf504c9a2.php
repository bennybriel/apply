
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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Tickets</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>TicketID</th>
                                                                        <th>Name</th>
                                                                        <th>Matricno</th>
                                                                        <th>Complain</th>
                                                                        <th>Status</th>
                                                                        <th>Application</th>
                                                                        <th>Category</th>
                                                                       
                                                                        <th>Action</th>
                                                                      

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>TicketID</th>
                                                                        <th>Name</th>
                                                                        <th>Matricno</th>
                                                                        <th>Complain</th>
                                                                        <th>Status</th>
                                                                        <th>Application</th>
                                                                        <th>Category</th>
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
                                                                            <td>
                                                                             
                                                                              <button type="button" class="btn btn-primary" id="editreply-item" data-item-ids="<?php echo e($data->ticketid); ?>" data-item-emails="<?php echo e($data->email); ?>" 
                                                                                  data-item-names="<?php echo e(GetName($data->email)); ?>" data-item-portals="<?php echo e($data->portal); ?>" data-item-subjects="<?php echo e($data->subject); ?>"
                                                                                  data-item-complains="<?php echo e($data->complain); ?>" ><?php echo e($data->ticketid); ?></button> 
                                                                            </td>
                                                                            <td><?php echo e(GetName($data->email)); ?></td>
                                                                            <td>
                                                                                <a href="" data-toggle="modal"  data-target-id="<?php echo e(GetMatricno($data->email)); ?>"  data-target="#myModalview" style="background:#c0a062;color:#FFF" class="btn" ><?php echo e(GetMatricno($data->email)); ?></a>
                         
                                                                            </td>
                                                                            <td><?php echo e($data->complain); ?></td>
                                                                            <td>
                                                                               <?php if($data->status=='0'): ?>
                                                                                 <span style="color:red">Pending</span>
                                                                               <?php else: ?>
                                                                               <span style="color:green">Resolved</span>
                                                                               <?php endif; ?>
                                                                              </td>
                                                                            <td><?php echo e($data->appid); ?></td>
                                                                            <td><?php echo e($data->category); ?></td>
                                                                           
                                                                             <td>
                                                                             <?php if($data->status=='0'): ?>
                                                                                  <button type="button" class="btn btn-success" id="edit-item" data-item-id="<?php echo e($data->ticketid); ?>" data-item-email="<?php echo e($data->email); ?>" 
                                                                                  data-item-name="<?php echo e(GetName($data->email)); ?>" data-item-portal="<?php echo e($data->portal); ?>" data-item-subject="<?php echo e($data->subject); ?>"
                                                                                  data-item-complain="<?php echo e($data->complain); ?>" >Reply</button>                                                                             
                                                                            <?php else: ?>
                                                                            <span style="color:red">Closed</span>
                                                                            <?php endif; ?>
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

      <!--Resolved  -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label" style="color:red">Reply Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
      
        <form  class="form-horizontal" id="edit-form" method="POST" action="<?php echo e(route('ReplyTicket')); ?>">
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
              <h2 class="m-0" style="color:brown">Reply Ticket</h2>
            </div>
            <div class="card-body">
              <!-- id -->
              
               
              
              <!-- /id -->
              <!-- name -->
              
              <!-- /name -->
              <!-- description -->
              <div class="form-group row">
                 <div class="col-sm-3 mb-3 mb-sm-0"> <label>Name</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" name="name" class="form-control form-control" id="name" readonly>
                    </div>                                     
               </div>
              <div class="form-group row">
                 <div class="col-sm-3 mb-3 mb-sm-0"> <label>TicketID</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        
                         <input type="text" name="ticketid" class="form-control form-control" id="ticketid" readonly>
                    </div>                                     
               </div>
               <input type="text" name="email" class="form-control form-control" id="email" readonly>
               <div class="form-group row">
                   <div class="col-sm-3 mb-3 mb-sm-0"> <label>Subject</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                      
                         <input type="text" name="subject" class="form-control form-control" id="subject" readonly>
                    </div>                                     
               </div>
               <div class="form-group row">
                   <div class="col-sm-3 mb-3 mb-sm-0"> <label>Complains</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                     <input type="text" name="complain" class="form-control form-control" id="complain" readonly>
                    </div>                                     
               </div>
              
              
               <div class="form-group row">
           
                     <div class="col-sm-3 mb-3 mb-sm-0"><label>Reply</label></div>
                      <div class="col-sm-6 mb-3 mb-sm-0">
                      <textarea name="reply" id="reply" cols="20" rows="5" placeholder="Please enter your reply" class="form-control form-control" required></textarea>
                                   
                    </div>                                     
               </div>


              <!-- /description -->
            </div>
          </div>
          <div class="modal-footer">
             <input type="submit" class="btn btn-success" value="Submit">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
<!--Further Reply--->

<div class="modal fade" id="editreply-modal" tabindex="-1" role="dialog" aria-labelledby="editreply-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label" style="color:red">Further Info Reply Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
      
        <form  class="form-horizontal" id="edit-form" method="POST" action="<?php echo e(route('ReplyTickets')); ?>">
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
              <h2 class="m-0" style="color:brown">Reply Ticket</h2>
            </div>
            <div class="card-body">
              <!-- id -->
              
               
              
              <!-- /id -->
              <!-- name -->
              
              <!-- /name -->
              <!-- description -->
              <div class="form-group row">
                 <div class="col-sm-3 mb-3 mb-sm-0"> <label>Name</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" name="names" class="form-control form-control" id="names" readonly>
                    </div>                                     
               </div>
              <div class="form-group row">
                 <div class="col-sm-3 mb-3 mb-sm-0"> <label>TicketID</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        
                         <input type="text" name="ticketids" class="form-control form-control" id="ticketids" readonly>
                    </div>                                     
               </div>
               <input type="text" name="emails" class="form-control form-control" id="emails" readonly>
               <div class="form-group row">
                   <div class="col-sm-3 mb-3 mb-sm-0"> <label>Subject</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                      
                         <input type="text" name="subjects" class="form-control form-control" id="subjects" readonly>
                    </div>                                     
               </div>
               <div class="form-group row">
                   <div class="col-sm-3 mb-3 mb-sm-0"> <label>Complains</label></div>
                     <div class="col-sm-6 mb-3 mb-sm-0">
                     <textarea name="complains" id="complains" cols="20" rows="5" placeholder="Please enter your reply" class="form-control form-control" readonly></textarea>
                 
                     </div>                                     
               </div>
              
              
               <div class="form-group row">
           
                     <div class="col-sm-3 mb-3 mb-sm-0"><label>Reply</label></div>
                      <div class="col-sm-6 mb-3 mb-sm-0">
                      <textarea name="replys" id="replys" cols="20" rows="5" placeholder="Please enter your reply" class="form-control form-control" required></textarea>
                                   
                    </div>                                     
               </div>


              <!-- /description -->
            </div>
          </div>
          <div class="modal-footer">
             <input type="submit" class="btn btn-success" value="Submit">
             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
<!-- View Category Type -->
<div class="modal fade" id="myModalview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-target=".bd-example-modal-lg">
   <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="edit-modal-label">Payment Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
              
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

          
        
            <table id="myTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                                    <th>SN</th>
                               
                                    <th>TransactionID</th>
                                    <th>Session</th>
                                    <th>Amount</th>                        
                                    <th>PaymentType</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                   
                    </tr>
                </thead>
                <tbody>

                </tbody>
             </table>


        </div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    //var name = row.children(".name").text();
    var name     = el.data('item-name');
    var subject = el.data('item-subject');
    var email    = el.data('item-email');
    var portal    = el.data('item-portal');
    var complain    = el.data('item-complain');
    // fill the data in the input fields
    $("#ticketid").val(id);
    $("#name").val(name);
    $("#email").val(email);
    $("#portal").val(portal);
    $("#complain").val(complain);
    $("#subject").val(subject);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })

  
})
</script>
<!--Reply--->
<script>
$(document).ready(function() {
  /**
   * for showing edit item popup
   */

  $(document).on('click', "#editreply-item", function() {
    $(this).addClass('editreply-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

    var options = {
      'backdrop': 'static'
    };
    $('#editreply-modal').modal(options)
  })

  // on modal show
  $('#editreply-modal').on('show.bs.modal', function() {
    var el = $(".editreply-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var ids = el.data('item-ids');
    //console.log(el.data('item-ids'));
    //var name = row.children(".name").text();
    var names     = el.data('item-names');
    var subjects = el.data('item-subjects');
    var emails   = el.data('item-emails');
    var portals    = el.data('item-portals');
    var complains    = el.data('item-complains');
    // fill the data in the input fields
    $("#ticketids").val(ids);
    $("#names").val(names);
    $("#emails").val(emails);
    $("#portals").val(portals);
    $("#complains").val(complains);
    $("#subjects").val(subjects);

  })

  // on modal hide
  $('#editreply-modal').on('hide.bs.modal', function() {
    $('.editreply-item-trigger-clicked').removeClass('editreply-item-trigger-clicked')
    $("#editreply-form").trigger("reset");
  })

  
})


//View Payment Record
$(document).ready(function(){
        $("#myModalview").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
             $.get( "GetPaymentRecord/" + id, function( data )
             {
                // console.log(id);
                   $('#myTable > tbody > tr').remove();
                    var rows = "";
                    //console.log(data['data'][0].name);
                    if(data['data'] != null)
                    {
                      len = data['data'].length;
                    }
                     var k=0;
                    for (i = 0; i<len; i++) 
                    {
                        k++;
                     
                       // console.log(data['data'][i].name);
                         $('#myTable > tbody:last-child').append(
                                          '<tr><td>' + k + '</td><td>'  
                                        
                                           + data['data'][i].transactionID + '</td><td>' 
                                           + data['data'][i].session + '</td><td>' 
                                           + data['data'][i].amount + '</td><td>' 
                                           + data['data'][i].description + '</td><td>' 
                                           + data['data'][i].created_at + '</td><td>' 
                                           + data['data'][i].response + '</td><td>' + '</td></tr>');
                         
                    }
            });

        });
    });
</script>



<?php $__env->stopSection(); ?>

<?php 
   function GetName($ema)
   {
        $name = DB::table('users')->where('email',$ema)->first();
        if($name)
        {
            return $name->name;
        }
        else
        {
            return $ema;
        }
   }
   function GetMatricno($ema)
   {
        $mat = DB::table('users')->where('email',$ema)->first();
        if($mat)
        {
            return $mat->matricno;
        }
        else
        {
            return $ema;
        }
   }
?>
<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/ticketList.blade.php ENDPATH**/ ?>