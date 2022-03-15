@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
    // $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
           
            
                                @if($data)
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Programme</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Programme</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
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
                                                                            <td>{{ $data->name }}</td>
                                                                             <td>
                                                                               <button type="button" class="btn btn-primary btn-sm" id="edit-item" data-item-name="{{ $data->name }}" data-item-id="{{ $data->programmeid }}">Add Subject</button>                                                                             
                                                                               <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target-id="{{ $data->programmeid }}" data-target="#myModalview">View Subject</button>
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


 <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label">Add Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
      
        <form  class="form-horizontal" id="edit-form" method="POST" action="{{ route('AddBrochures') }}">
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
          <div class="card text-white bg-white mb-0">
            <div class="card-header">
              <h2 class="m-0" style="color:#c0a062">
                 <input type="text" name="programme" class="form-control" id="programme" readonly>
              </h2>
            </div>
            <div class="card-body">
              <!-- id -->
              
               
                <input type="hidden" name="programmeid" class="form-control" id="programmeid" readonly>
              
                <br/>
                  <div class="form-group row">
                     <div class="col-sm-6 mb-3 mb-sm-0">
                          <select name="subject" id="subject" class="form-control form-control" required>
                                <option value="">Select Subject</option>
                                    @foreach($sbj as $sbj)
                                         <option value="{{ $sbj->subjectid }}">{{ $sbj->subject }}</option>
                                    @endforeach
                            </select>
                     </div>
                </div>
                <div class="form-group row">
                         <div class="col-sm-6 mb-3 mb-sm-0">
                            <select name="status" id="status" class="form-control form-control" required>
                               <option value="">Select Status</option>
                               <option value="1">Required</option>    
                               <option value="0">Optional</option>          
                            </select>
                         </div>
                </div>


              <!-- /description -->
            </div>
          </div>
          <div class="modal-footer">
             <input type="submit" class="btn btn-primary" value="Add Subject">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
        </form>
      </div>
     
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-target=".bd-example-modal-lg">
   <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="edit-modal-label">View Subjects</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
              
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

          
        
            <table id="myTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       <th>SN</th>
                       <th>Programme</th>
                       <th>Subject</th>
                       <th>Status</th>
                       <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
             </table>


        </div>
    </div>
</div>
<!---DELETE MODAL -->
<div id="applicantDeleteModal" class="modal modal-danger fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
             <form action="{{route('DeleteBrochure')}}" method="POST" class="remove-record-model">
               {{ csrf_field() }}

            <div class="modal-header">
                
                <h4 class="modal-title text-center" id="custom-width-modalLabel">Delete <input type="text", name="app_name" id="app_name" disabled></h4>
            </div>
            <div class="modal-body">
                <h4>You Want You Sure Delete This Record?</h4>
                <input type="hidden", name="applicant_id" id="app_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger waves-effect remove-data-from-delete-form">Delete</button>
            </div>

             </form>
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
    var nameid = el.data('item-name');
    var name = row.children(".name").text();
    var description = row.children(".description").text();
    var programme = row.children(".programme").text();

    // fill the data in the input fields
    $("#programmeid").val(id);
    $("#programme").val(nameid);
    $("#subjectid").val(name);
    $("#status").val(description);
  

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})


function GetProduct() {
            $.ajax({
                type: "POST",
                contentType: "application/json; charset=utf-8",
                url: "WebService.asmx/GetData",
                data: {},
                dataType: "json",
                success: function (data) {
                    var table = $('#tblgrid');
                    var rows = "";
                    for (var i = 0; i < data.d.length; i++) {
                        rows += "<div class=trclass>" +
                            "<tr><td class=tdcolumn>" +
                            "<div class=tablediv>" +
                            "<div class=Productid>" + data.d[i].ProductId + "</div>" +
                            "<div class=sproductname>" + data.d[i].ProductName + "</div><br />" +
                            '<p><a class="btn btdeal" target="_blank" onclick = Getproductname(this) data-id="' + data.d[i].ProductId + '" id=btnDeal role="button" data-toggle="modal" data-target="#DesPopUp" >submit</a></p>' +
                            "</div></td></tr></div>"
                    }
                    table.append(rows);
                },
                failure: function (response) { alert(response.d); },
                error: function (response) { alert(response.d); }
            });
        }

</script>
<script>
    $(document).ready(function(){
        $("#myModalview").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
             $.get( "/GetBrochureSubject/" + id, function( data )
             {
                 console.log(id);
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
                                           + data['data'][i].name + '</td><td>' 
                                           + data['data'][i].subject + '</td><td>' 
                                           + data['data'][i].status + '</td><td>'
                                           + '<button class="btn btn-danger deleteUser" data-item-name="'+ data['data'][i].subject +'" data-userid="'+ data['data'][i].id +'">Delete</button>' + '</td></tr>');
                         
                    }
            });

        });
    });
</script>

<script>
$(document).on('click','.deleteUser',function(){
    var ID    =$(this).attr('data-userid');
    var name  = $(this).attr('data-item-name'); 
    $('#app_id').val(ID); 
    $('#app_name').val(name); 
    $('#applicantDeleteModal').modal('show'); 
});
</script>
@endsection

