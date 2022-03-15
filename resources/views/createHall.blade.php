@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
    // $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="js/jquery-3.3.1.js"></script>


<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('CreateHalls') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Create Hall Instructions</h1>
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
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">New Hall</h1>
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
                                            <input type="text" name="hallid" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Hall ID" required>
                                       </div>
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="hall" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Hall Name" required>
                                       </div>
                                     </div>
                                        <div class="form-group row">
                                           <div class="col-sm-8 mb-3 mb-sm-0">
                                              <input type="text" name="capacity" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Hall Capacity" required>
                                          </div>
                                      </div>
                                        
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Create Hall</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                          @if($data)
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Users Record</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name</th>
                                                                        <th>HallID</th>
                                                                        <th>Capacity</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name</th>
                                                                        <th>HallID</th>
                                                                        <th>Capacity</th>
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
                                                                            <td>{{ $data->name }}</td>
                                                                            <td>{{ $data->hallid }}</td>
                                                                            <td>{{ $data->capacity }}</td>
                                                                     
                                                                            <td>

                                                                                 @if($data->status==0)
                                                                                    <span style="color:red">Inactive</span>
                                                                                 @else
                                                                                     <span style="color:green">Active</span>
                                                                                 @endif

                                                                            </td>
                                                                            <td>
                                                                               
                                                                                   
                                                                                         @if($data->status==0)
                                                                                             <a href="{{ route('SuspendHalls',[$data->id,$data->status]) }}" class="btn btn-danger">Inactive</a>
                                                                                
                                                                                         @else
                                                                                             <a href="{{ route('SuspendHalls',[$data->id,$data->status]) }}" class="btn px-4" style="background:#c0a062;color:white">Active</a>
                                                                                
                                                                                        @endif
             
                                                                                       <!-- <a href="" style="background:#c0a062;color:white" class="btn" data-toggle="modal" data-target="#modalRegisterForm">Update Capacity</a>
                                                                                       -->

                                                                                        <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                           
                                                                                            <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	                                                                                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                                                                </div>
                                                                                                <div class="alert alert-danger alert-dismissible" id="failure" style="display:none;">
                                                                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                                                                </div>
	                                                                                        <div class="modal-header text-center">
                                                                                                <h4 class="modal-title w-100 font-weight-bold">Update Hall Capacity</h4>
                                                                                                
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body mx-3">
                                                                                            <div class="form-group">
                                                                                                <i class="fas fa-user prefix grey-text"></i>
                                                                                                <label data-error="wrong" data-success="right" for="orangeForm-name">Hall name</label>
                                                                                                <input type="text" id="hname"  value="{{ $data->name }}"  class="form-control validate">
                                                                                               
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                <i class="fas fa-number prefix grey-text"></i>
                                                                                                <label data-error="wrong" data-success="right" for="orangeForm-email">Number of Seaters</label>
                                                                                                <input type="number" id="num" class="form-control validate">
                                                                                                </div>

                                                                                            

                                                                                            </div>
                                                                                            <div class="modal-footer d-flex justify-content-center">
                                                                                                <button class="btn btn-deep-orange" id="Seaters">Update</button>
                                                                                            </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        </div>

                                                         
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

        <script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$(document).ready(function() {
	$('#Seaters').on('click', function() 
    {
		
		var num   = $('#num').val();
		var hname = $('#hname').val();

        //alert(num+hname);

		if(num!="" || hname!="")
		{
			$.ajax({
				url: "UpdateHallCapacity",
				type: "GET",
				data: {_token: CSRF_TOKEN,
					num: num,
					hname: hname,						
				},
				cache: false,
				success: function(dataResult)
                {
					var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200)
                    {
						$("#success").show();
						$('#success').html(dataResult.msg); 
                        return;						
					}
					else if(dataResult.statusCode==201){
                        $("#failure").show();
						$('#failure').html(dataResult.msg); 	
					}
					
				}
			});
		}
		else{
			alert('Please fill all the field !');
		}
	});
});
</script>


@endsection
