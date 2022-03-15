@extends('layouts.appdashboard')

@section('content')
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h3 style="color:#da251d">Course Registration Confirmation</h3>
                  <p class="text-muted" style="color:#000000"></p>
                  <p style="color:#da251d"><em>{{ $res }}</em></p>

                  <p><h6 style="color:#da251d">For Complaints</h6>
                  Call +2348079038989, +2349094507494 <br/>
                  OR Email to support@lautech.edu.ng
                  </p>
                </div>
              </div>


          </div>
        </div>
      </div>
    </div>

    @endsection

