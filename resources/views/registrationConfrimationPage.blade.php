@extends('layouts.appdashboard')

@section('content')
    <div class="container">
 
      <br/>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h3 style="color:#da251d">Registration Confirmation</h3>
                  <p class="text-muted" style="color:#000000"></p>
                  <p style="color:#da251d"><em>Congratulations!!!, Your have successfully submitted Application.
                       Please click on the link to download Confirmation.</em>
                       <a href="{{ route('screeningconf') }}" class="btn btn-primary" style="background:#c0a062;color:white">
                                                           Download Registration Confirm
                         </a>
                    </p>
             
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
                  <p style=" text-align:justify">Please note that, for this signup to be completed, you need to check your email and click on the link provided.</p>

<a href="{{ route('home') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                   Return Home
                                </a>                                
</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @endsection

