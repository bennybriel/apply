@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="js/jquery-3.3.1.js"></script>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('Supports') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-4">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Create Support Ticket Instructions</h1>
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
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Create New Ticket</h1>
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
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                            <select name="portal" id="portal" class="form-control form-control" required>
                                                    <option value="">Select Portal</option>
                                                       @foreach($p as $p)
                                                         <option value="{{ $p->portalid }}">{{ $p->name }}</option>
                                                        @endforeach
                                                  </select>
                                           </div>
                                     </div>
                                       <div class="form-group row">
                                   
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="application" id="application" class="form-control form-control" required>
                                                    <option value="">Select Application</option>
                                                
                                                  </select>
                                           </div>
                                     
                                  
                              
                                       <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="category" id="category" class="form-control form-control" required>
                                                    <option value="">Select Category</option>
                                                       @foreach($c as $c)
                                                         <option value="{{ $c->catid }}">{{ $c->name }}</option>
                                                        @endforeach
                                                  </select>
                                       </div>
                        
                                 </div>
                                    <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                           <input type="text" name="subject" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Subject" required>
                                           </div>
                                     </div>
                                     <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                          <textarea name="complains" cols="40" rows="10" placeholder="Please enter your complains" class="form-control form-control" required></textarea>
                                           </div>
                                     </div>
                                     <div class="form-group row">
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                               <input type="file" name="datafile" class="form-control form-control"
                                                 id="exampleFirstName">
                                          </div>
                                       </div>       
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit </button>

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
                                                                        <th>Session</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
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
                                                                            <td>{{ $data->name }}</td>
                                                                            <td>

                                                                                 @if($data->status==0)
                                                                                    <span style="color:red">Inactive</span>
                                                                                 @else
                                                                                     <span style="color:green">Active</span>
                                                                                 @endif

                                                                            </td>
                                                                            <td>
                                                                              
                                                                                   
                                                                          @if($data->status==0)
                                                                            <a href="{{ route('EnableSession',[$data->id,$data->status]) }}" class="btn px-4" style="background:#c0a062;color:black">Inactive</a>
                                                                                
                                                                            @else
                                                                            <a href="{{ route('EnableSession',[$data->id,$data->status]) }}" class="btn px-4" style="background:#c0a062;color:white">Active</a>
                                                                                
                                                                             @endif
                                                                                                         
                                                                        

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
$(document).ready(function(){
  $('#portal').change(function(){

     
     var id = $(this).val();
     $('#application').find('option').not(':first').remove();
    
     $.ajax({
       url: 'GetTickets/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }
        
         if(len > 0)
         {
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].appid;
             var name = response['data'][i].name;
             // alert(name);
             var option = "<option value='"+name+"'>"+name+"</option>"

             $("#application").append(option); 
           }
         }

       }
    });
  });

});

        </script>
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
