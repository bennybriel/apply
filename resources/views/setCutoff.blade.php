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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('CreateCutoff') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Setup CutOff Instructions</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">Setup Cutoff Mark</h1>
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
                                         <div class="col-sm-8 mb-3 mb-sm-0">
                                         <select class="form-control" name="session" required>
                                                <option value="">Select Session</option>
                                                @foreach($lst as $lst)
                                                    <option value="{{ $lst->name }}">{{ $lst->name }}</option>
                                                @endforeach
                                           </select>
                                         </div>  
                                     </div>

                                     <div class="form-group row">
                                         <div class="col-sm-8 mb-3 mb-sm-0">
                                              <input type="number" name="cutoff" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Cut Off Score" required>
                                         </div>  
                                     </div>

                               

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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">CutOff Record</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Score</th>
                                                                        <th>Session</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Score</th>
                                                                        <th>Session</th>
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
                                                                            <td>{{ $data->score }}</td>
                                                                            <td>{{ $data->session }}</td>
                                                                            <td>

                                                                                 @if($data->status==0)
                                                                                    <span style="color:red">Inactive</span>
                                                                                 @else
                                                                                     <span style="color:green">Active</span>
                                                                                 @endif

                                                                            </td>
                                                                            
                                                                              
                                                                            <td> 
                                                                            <div class="modal fade" id="myModal" role="dialog">
                                                                                <div class="modal-dialog">
                                                                                    <!-- Modal content-->
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                        
                                                                                            <h4 class="modal-title">Update CutOff</h4>
                                                                                            <form class="form-group" action="/UpdateCutoff/{{ $data->id}}" method="post" id="editCommunityForm_{{$data->id}}">
                                                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                                                <input type="text" name="cutoff" class="form-control" value="{{ $data->score }}">
                                                                                            </form>
                                                                                            <button class="btn btn-custom" style="background:#c0a062;color:white" type="submit" form="editCommunityForm_{{$data->id}}">Update Cutoff</button><br /><br />
                                                                                        
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                           
                                                                                 <button type="button" class="btn" data-toggle="modal" data-target="#myModal" data-community="{{ json_encode($data) }}" style="background:#c0a062;color:white">Edit</button>
        |                                                                </td>                                  
                                                                         

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                        @endif
        </div>

 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>
            <div class="modal-body">
                <form class="form-group" method="post" id="editCommunityForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="cutoff" class="form-control" placeholder="Edit Cutoff">
                </form>
                <button class="btn btn-custom waves-light" style="background:#c0a062;color:white" type="submit" form="editCommunityForm">Update Cutoff</button><br /><br />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
