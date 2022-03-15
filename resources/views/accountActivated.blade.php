@extends('layouts.applogReg2')

@section('content')
    <div class="container">
    <div class="row" style="align:center">
         <div class="col-5">
         </div>
         <div class="col-7">
            <img src="../logRegTemp/img/brand/logo.png" style="max-width:100%;height:auto;"/>
         </div>

      </div>
      
      <br/>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h3 style="color:#da251d">Signup Verification</h3>
                  <p class="text-muted" style="color:#000000"></p>
                  <p style="color:#000000"><em>{{ $rec }}</em></p>
                  @if($m==1)
                  <div class="col-6">
                       <button class="btn px-4" type="button" style="background:#c0a062"><a href="{{ route('logon') }}">Login</a></button>
                  </div>
             
                  @endif
                  <p><h6 style="color:#da251d">For Complaints</h6>
                    Call +2348079038989, +2349094507494 <br/>
                     OR Email to support@lautech.edu.ng
                  </p>
                </div>
              </div>
            
            <div class="card text-white py-5 d-md-down" style="background:#c0a062">
              <div class="card-body text-center">
                <div>
                  <h4 style="color:#000000">Important information</h2>
                  <p style=" text-align:justify">You are to log in with your Matric Number and password. Once you are logged in, pay close attention to any information appearing in a green box.
Click here to create a portal account if you are a fresh student. However, if you are not a fresh student, and you do not have a portal account, visit the Admission Office first for profiling and then click here..</p>
                                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @endsection

