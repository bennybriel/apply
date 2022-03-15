@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
     $data = session('data');
    /* $data = DB::table('users as us')
            ->join('u_g_pre_admission_regs as rg','rg.matricno','=','us.matricno')
            ->where('us.utme',$utme)
            ->first(); */
?>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="js/jquery-3.3.1.js"></script>


<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('UpdateStudentInfos') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Update Student Instructions</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">Update Student Information</h1>
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
                                    @if($data)
                                    <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                 <label>Surname</label>
                                                    <input type="text" name="surname" value="{{ $data->surname }}" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="First Name" required>
                                                    
                                            </div>
                                        
                                        </div>
                                        <input type="hidden" name="utme" value="{{ $data->utme }}" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="">
                                                  
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <label>Firstname</label>
                                                    <input type="text" name="firstname" value="{{ $data->firstname }}" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="First Name" required>
                                                    
                                            </div>
                                        
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-8 mb-3 mb-sm-0">
                                                <label>Othername</label>
                                                    <input type="text" name="firstname" value="{{ $data->othername }}" class="form-control form-control" id="exampleFirstName"
                                                                placeholder="">
                                                    
                                            </div>
                                        
                                        </div>
                                    @endif

                                     <div class="form-group row">
                                       <div class="col-sm-8 mb-3 mb-sm-0">
                                            @if(!$data->state)
                                                   <select name="state" id="state" class="form-control form-control" required>
                                                      <option value="">Select State</option>
                                                        @foreach($st as $st)
                                                             <option value="{{ $st->stateid }}">{{ $st->name }}</option>
                                                         @endforeach
                                                   </select>
                                           @else
                                                   <select name="state" id="state" class="form-control form-control" required>
                                                      
                                                             <option value="{{ GetStateID($data->state) }}">{{ $data->state }}</option>
                                                       
                                                   </select>
                                           @endif
                                       </div>
                                      
                                     </div>
                                        <div class="form-group row">
                                           <div class="col-sm-10 mb-3 mb-sm-0">
                                                @if(!$data->lga)
                                                   <select name="lga" id="lga" class="form-control form-control" required>
                                                      <option value="">Select LGA</option>
                                                      
                                                   </select>
                                                @else
                                                      <select name="lga" id="lga" class="form-control form-control" required>
                                                      
                                                             <option value="{{ $data->lga }}">{{ $data->lga }}</option>
                                                       
                                                   </select>
                                                @endif
                                          </div>
                                      </div>
                                        
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Update Student Info</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

           <?php
              session(['utme' => null]);
              //session(['data' => null]);
           ?>
                                       
        </div>
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){
  $('#state').change(function(){

     
     var id = $(this).val();
     $('#lga').find('option').not(':first').remove();
    
     $.ajax({
       url: 'GetLGA/'+id,
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

             var id = response['data'][i].lgaid;
             var name = response['data'][i].lga;
             // alert(name);
             var option = "<option value='"+name+"'>"+name+"</option>"

             $("#lga").append(option); 
           }
         }

       }
    });
  });

});

        </script>


@endsection

<?php 

  function GetStateID($st)
  {
      $sta = DB::table('statelist')->where('name',$st)->first();
      if($sta)
      {
          return $sta->stateid;
          
      }
      else
      {
           return 0;
      }
  }
?>