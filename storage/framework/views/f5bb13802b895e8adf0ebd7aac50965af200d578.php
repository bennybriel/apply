
<?php $__env->startSection('content'); ?>
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="<?php echo e(route('PaymentBiodatas')); ?>">
                                        <?php echo e(csrf_field()); ?>


                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Biodata Payment</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                     Please note that by clicking here to login, you affirm that you have read and understood all the instructions
                                                     documented in this guide. If you are a fresh student and yet to create a Portal Account, click here. However,
                                                     if you are not a fresh student, and you do not have a portal account, visit the Admission Office first for profiling
                                                     and then click here. After completely studying this guide, if you still have any further enquiries, please feel free
                                                     to contact us.
                                                  </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Biodata Payment </h1>
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
                                       <div class="col-sm-8 mb-3 mb-sm-0">
                                            <input type="text" name="utme" id="utme" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="UTME Registration No." required>
                                       </div>
                                     
                                     </div>
                               

                                        <button class="btn px-4" id="btnSubmit" type="submit" style="background:#c0a062;color:white"> Pay Now</button>

                                        <hr>
                               </div>





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
     document.getElementById("btnSubmit").style.display = "none";
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
                     var k=0;
                    for (i = 0; i<len; i++) 
                    {
                        k++;
                     
                       var nam = data['data'][i].name;
                       var utme = data['data'][i].utme;
                       var prog = data['data'][i].programme;
                    }
                    alert(nam +"  "+utme+"  "+prog);
                  
            });

      
    });

    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appdashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\admissions\resources\views/paymentBiodata.blade.php ENDPATH**/ ?>