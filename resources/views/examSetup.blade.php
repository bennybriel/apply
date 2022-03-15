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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('ExamSets') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h3 class="h4 mb-4" style="color:#da251d">Exam Setup Instructions</h3>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">Examination Setup</h1>
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
                                    
                                          <div class="col-sm-4 mb-3 mb-sm-0"><label>Exam Date</label>
                                              <input type="date" name="examdate" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Examination Date" required>
                                           </div>

                                           <div class="col-sm-4 mb-3 mb-sm-0">  <label>Exam Duration</label>
                                                <input type="number" name="examtime" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Exam Time" required>
                                             </div>   
                                             <div class="col-sm-4 mb-3 mb-sm-0">  
                                                 <label>Session</label>
                                                 <select name="session" id="session" class="form-control form-control" required>
                                                        <option value="">Session</option>
                                                       @foreach($ses as $ses)
                                                          <option value="{{ $ses->name }}">{{ $ses->name }}</option>
                                                      @endforeach
                                                 </select>
                                             </div>     
                                      </div>
                                       <div class="form-group row">
                                          
                                             <div class="col-sm-5 mb-3 mb-sm-0"><label>Start Time</label>
                                                <input type="time" name="examtime1" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Examination Time" required>
                                             </div>    
                                   
                                            <div class="col-sm-5 mb-3 mb-sm-0">  <label>End Time</label>
                                                <input type="time" name="examtime2" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Examination Time" required>
                                             </div>    
                                        </div>

                                         <div class="form-group row">
                                          
                                       
                                          <div class="col-sm-5 mb-3 mb-sm-0"><label></label>
                                             
                                       </div>
                                        
                                    </div>

                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Create </button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                          @if($data)
                                                 <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Examination Batching</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Hall</th>
                                                                        <th>Exam Date</th>
                                                                        <th>Exam Time</th>
                                                                        <th>Batch</th>
                                                                        <th>Session</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Hall</th>
                                                                        <th>Exam Date</th>
                                                                        <th>Exam Time</th>
                                                                        <th>Batch</th>
                                                                        <th>Session</th>
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
                                                                            <td>{{ $data->edate }}</td>
                                                                            <td>{{ $data->etime }}</td>
                                                                            <td>{{ $data->batch }}</td>
                                                                            <td>{{ $data->session }} </td>
                                                                            <td>
                                                                                                                                                                                                                            
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

@endsection
<?php
  function GetName($sta)
  {
      $st = DB::table('users')->where('matricno',$sta)->first();
      
      return $st->name;
  }
  function GetRole($rol)
  {
      $ro = DB::table('roles')->where('roleid',$rol)->first();
      
      return $ro->name;
  }
?>
