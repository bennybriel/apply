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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('UploadPassports') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-4">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Upload Passport</h1>
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
                                        <h1 class="h4  mb-4" style="color:#da251d">Update Passport</h1>
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
                                           <input type="text" name="utme" placeholder="Enter UTME" class="form-control form-control" id="utme" >
                                       </div>
                                       <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Search</button>

                                     </div>
                                        <div class="form-group row">
                                           <div class="col-sm-10 mb-3 mb-sm-0">
                                           
                                          </div>
                                      </div>
                                        
                                      
                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                       
        </div>


@endsection
