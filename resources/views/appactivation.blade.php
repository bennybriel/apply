@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     //$u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('ActivateApp') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Application Activation Instructions</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">Open/Close Application</h1>
                                              @if(Session::has('error'))
                                                    <div class="alert alert-danger">
                                                        {{ Session::get('error') }}
                                                        @php
                                                            Session::forget('error');
                                                        @endphp
                                                        </div>
                                                   @endif
                                                        @if(Session::has('success'))
                                                     <div class="alert alert-success">
                                                        {{ Session::get('success') }}
                                                        @php
                                                            Session::forget('success');
                                                        @endphp

                                                        </div>

                                                @endif

                                    </div>

                                    <div class="form-group row">
                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                         <select class="form-control" name="appname" required>
                                                <option value="">Select Application</option>
                                                @foreach($lst as $lst)
                                                    <option value="{{ $lst->name }}">{{ $lst->name }}</option>
                                                @endforeach
                                           </select>
                                         </div>  

                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                         <select class="form-control" name="session" required>
                                                <option value="">Select Session</option>
                                                    @foreach($ses as $ses)
                                                        <option value="{{ $ses->name }}">{{ $ses->name }}</option>
                                                    @endforeach
                                           </select>
                                         </div>  
                                     </div>

                                     <div class="form-group row">

                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                             <label>Open Date</label>
                                              <input type="date" name="odate" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Opening Date" required>
                                         </div>  
                                         <div class="col-sm-6 mb-3 mb-sm-0">
                                         <label>Close Date</label>
                                              <input type="date" name="cdate" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Closing Date" required>
                                         </div>  
                                     </div>
                                   <!--
                                     <div class="form-group row">
                                         <div class="col-sm-8 mb-3 mb-sm-0">
                                              <input type="number" name="activedays" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Number of Days" required>
                                         </div>  
                                     </div> 
                                   -->
                               

                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Create</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                            @if($data)
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Open/Close Application Record</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Opening Date</th>
                                                                        <th>Closing Date</th>
                                                                        <th>Active Days</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Opening Date</th>
                                                                        <th>Closing Date</th>
                                                                        <th>Active Days</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->appname }}</td>
                                                                            <td>{{ $data->session }}</td>
                                                                            <td>{{ $data->opendate }}</td>
                                                                            <td>{{ $data->closedate }}</td>
                                                                            <td> {{ $data->activedays }}        <td>

                                                                                 @if($data->status==0)
                                                                                    <span style="color:red">Close</span>
                                                                                 @else
                                                                                     <span style="color:green">Open</span>
                                                                                 @endif

                                                                            </td>
                                                                            
                                                                              
                                                                            <td> 
                                                                                                                                     
                                                                            <button type="button" class="btn btn-success" 
                                                                                id="edit-item" 
                                                                                  data-item-id="{{  $data->id }}" 
                                                                                  data-item-open="{{  $data->opendate }}" 
                                                                                  data-item-close="{{ $data->closedate }}" 
                                                                                  data-item-prog="{{ $data->appname }}" 
                                                                                  data-item-remaining ="{{ $data->activedays}}"
                                                                               > Edit </button>
        |                                                                        <a href="{{ route('RemoveAppActivation',$data->id) }}" class="btn btn-danger" style="color:white">Delete</a>
                                                                        
                                                                             </td>                                  
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                        @endif
        </div>

        <div class="modal fade" id="edit-modal" role="dialog">
                                                                                <div class="modal-dialog">
                                                                                    <!-- Modal content-->
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                        
                                                                                            <h4 class="modal-title" style="color:red">Update <span id='programme'> </span></h4>
                                                                                           
                                                                                          
                                                                                            <form class="form-group" action="{{ route('UpdateAppActivation') }}" method="post" id="editCommunityForm">
                                                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                                                <input type="hidden" name="tid" value="" id='tid'>
                                                                                                 <label>Opening Date</label>
                                                                                                 <input type="date" name="open" class="form-control" id="open">
                                                                                                 <label>Closing Date</label>
                                                                                                 <input type="date" name="close" class="form-control" id="close">
                                                                                                 <label>Remaining Date</label>
                                                                                                 <input type="text" name="remaining" disabled class="form-control" id="remaining">
                                                                                                 <br/>
                                                                                            <button class="btn btn-custom" style="background:#c0a062;color:white" type="submit">Update</button><br /><br />
                                                                                         </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                               </div>   


 <script src="js/jquery-3.2.1.slim.min.js"></script>
<script>
$(document).ready(function()
 {
  //Update Transaction
  $(document).on('click', "#edit-item", function()
   {
    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function() 
  {
    var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var tid = el.data('item-id'); 
    var close = el.data('item-close');
    var open = el.data('item-open');
    var prog = el.data('item-prog');
    var remaining = el.data('item-remaining');
 // fill the data in the input fields
 //console.log(prog);
      $("#tid").val(tid);
      $("#close").val(close);
      $("#open").val(open);
      $("#prog").val(prog)
      $('#remaining').val(remaining);
      document.getElementById("programme").innerHTML = prog;

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })

})
</script>


@endsection
