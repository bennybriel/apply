@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('AddUsers') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Create Users Instructions</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">New Users Details</h1>
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
                                            <input type="text" name="staffid" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Staff ID" required>
                                       </div>
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="surname" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Surname" required>
                                       </div>
                                     </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="firstname" class="form-control form-control"
                                                 id="exampleFirstName"
                                                    placeholder="First Name" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="othername" class="form-control form-control" 
                                                id="exampleLastName"
                                                    placeholder="Othername">
                                            </div>
                                        </div>
                                      <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            </div>

                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="phone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                            </div>
                                       </div>


                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                   <select name="role" id="role" class="form-control form-control" required>
                                                      <option value="">Role</option>
                                                        @foreach($rol as $rol)
                                                             <option value="{{ $rol->roleid }}">{{ $rol->name }}</option>
                                                         @endforeach
                                                   </select>
                                                </div>

                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                   <select name="section" id="section" class="form-control form-control" required>
                                                      <option value="">Section</option>
                                                      @if($usr=="Admin")
                                                         @foreach($sec as $sec)
                                                             <option value="{{ $sec->name }}">{{ $sec->name }}</option>
                                                         @endforeach
                                                      @else

                                                         @foreach($u as $u)
                                                            <option value="{{ $u->section }}">{{ $u->section }}</option>
                                                          @endforeach
                                                      @endif
                                                   </select>
                                                </div>
                                                
                                            
                                                
                                        </div>
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit</button>

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
                                                                        <th>StaffID</th>
                                                                        <th>Name</th>
                                                                        <th>Role</th>
                                                                        <th>Section</th>
                                                                         <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>StaffID</th>
                                                                        <th>Name</th>
                                                                        <th>Role</th>
                                                                        <th>Section</th>
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
                                                                            <td>{{ $data->staffid }}</td>
                                                                            <td>{{ GetName($data->staffid) }}</td>
                                                                            <td>{{ GetRole($data->roleid) }}</td>
                                                                            <td>{{ $data->section  }}</td>
                                                                            <td>

                                                                                 @if($data->isactive==0)
                                                                                    <span style="color:red">Inactive</span>
                                                                                 @else
                                                                                     <span style="color:green">Active</span>
                                                                                 @endif

                                                                            </td>
                                                                            <td>
                                                                                @if($usr=="Admin")
                                                                                   
                                                                                         @if($data->isactive==0)
                                                                                             <a href="{{ route('SuspendRoleByAdmin',[$data->id,$data->isactive]) }}" class="btn px-4" style="background:#c0a062;color:black">Unsuspend</a>
                                                                                
                                                                                         @else
                                                                                             <a href="{{ route('SuspendRoleByAdmin',[$data->id,$data->isactive]) }}" class="btn px-4" style="background:#c0a062;color:white">Suspend</a>
                                                                                
                                                                                        @endif


                                                                                 
                                                                                @else
                                                                                  <a href="{{ route('SuspendRoleByAdmin',  [$data->id,$data->isactive]) }}"  class="btn px-4" style="background:#c0a062;color:white">Suspend</a>
                                                                                  <a href="{{ route('DeleteRoleBySection', [$data->staffid, $data->createdbyrole]) }}" class="btn btn-danger">Delete</a>
                                                                                @endif
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
      
      if($st)
      {
         return $st->name;
      }
      else
      {
          return $sta;
      }
  }
  function GetRole($rol)
  {
      $ro = DB::table('roles')->where('roleid',$rol)->first();
      
      return $ro->name;
  }
?>
