@extends('layouts.appfront1')
@section('content')
<?php
   $mat = $res[0]->matricno;
   $y =date("Y");
?>
 <div class="row">
         <div class="col-5">
         </div>
         <div class="col-7">
            <img src="../logRegTemp/img/brand/logo.png" style="max-width:100%;height:auto;"/>
         </div>

      </div> 
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('PGReferences') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                            <label></label>
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">  @if($res) {{ strtoupper($res[0]->surname) }}  {{ $res[0]->firstname }}@endif Reference Information</h1>
                                    </div>
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
                                                <input type="hidden" value="{{ $guid }}" name="guid">
                                                <input type="hidden" value="{{  $res[0]->myemail }}" name="myemail">
                                                <input type="hidden" value="{{ $res[0]->matricno }}" name="matricno">
                                       <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                 <select name="title" id="title" class="form-control form-control" required>
                                                        <option value="">Select Title</option>
                                                    
                                                        @foreach($tit as $tit)
                                                           <option value="{{ $tit->name }}">{{ $tit->name }}</option>
                                                        @endforeach
                                                    
                                                    </select>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="name" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Full Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="email" name="email"  value="{{ $res[0]->email }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" readonly>
                                            </div>
                                        </div>
                                                                             
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="rank" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Position" required>
                                              </div>
                                             
                                        </div>
                                         
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                                <textarea name="remark" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Remark/Comments" required></textarea>
                                              </div>
                                             
                                        </div>
                                       
                                     
                                       
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Save</button>

                                            </div>
                                          </div>
                                      


                                        <div class="form-group">
                                           <div class="col-sm-12 mb-3 mb-sm-0">
                                            <!-- DataTales Example -->


                                            </div>
                                        </div>




                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>

 
                                    <h4 style="color:#000000">Important information</h2>
                  <p style=" text-align:justify">You are to log in with your Matric Number and password. Once you are logged in, pay close attention to any information appearing in a green box.
           Click here to create a portal account if you are a fresh student. However, if you are not a fresh student, and you do not have a portal account, visit the Admission Office first for profiling and then click here..</p>
                 

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
@endsection
