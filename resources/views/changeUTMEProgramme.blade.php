@extends('layouts.appdashboard')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
              
                    <div class="row">
              
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        @if($data)
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
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->utme }}</td>
                                                                            <td>{{ $data->name }}</td>
                                                                            <td>{{ $data->totalscore }}</td>
                                                                            <td>{{ $data->programme }}</td>
                                                                           
                                                                             <td>
                                                                                <button type="button" class="btn btn-success" id="edit-item" data-item-id="{{ $data->utme }}" 
                                                                                  data-item-name="{{ $data->name }}" data-item-total="{{ $data->totalscore }}" 
                                                                                  data-item-programme="{{ $data->programme }}" >Update</button>                                                                             

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
      
        <form  class="form-horizontal" id="edit-form" method="POST" action="{{ route('UpdateProgramme') }}">
           {{ csrf_field() }}
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
                  <?php
                                                           // $memberID = session('memberID');
                   ?>
                 @endif
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
                                @foreach ($p as  $p)
                                   <option value="{{ $p->name }}">{{$p->name }}</option>
                                 @endforeach
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
@endsection
