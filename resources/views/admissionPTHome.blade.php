@extends('layouts.appdashboard')
@section('content')
<?php
   $stgid =1;
   $stag = DB::table('ptregistrationstages')->where('stageid',$stgid)->get();
   $matricno = Auth::user()->matricno;
   $stg = DB::table('ptregistrationstages')->get();

   
?>
  <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Part Time Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Admission Letter
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">

                                            
                                     <a href="{{ route('admissionLetterPT') }}" class="btn btn-success">
                                           Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Acceptance Fee</div>
                                           
                                        </div>
                                        <div class="col-auto">
                                        <a href="#" class="btn btn-success">
                                                Pay Now
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        @if($stag)
                           @foreach($stag as $items)                          
                                  <div class="col-xl-3 col-md-6 mb-4">
                                     <div class="card {{ $items->cardcolor }} shadow h-100 py-2">
                                           <div class="card-body">
                                              <div class="row no-gutters align-items-center">
                                                 <div class="col mr-2">
                                                   <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   {{ $items->name }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                    <span style="color:red">Pending</span>
                                                @else
                                                    <span style="color:green">Completed</span>
                                                @endif
                                                </div>
                                            </div>
                                           
                                            <div class="col-auto">
                                          
                                                  @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                            <a href="{{ route('PTPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                        <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                           
                                                        </a>
                                                   @endif        
                                                 
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                           @endforeach               
                         @endif
                        
                         @foreach($stg as $st)
                                @if(RegistrationStatus($matricno,$st->stageid)==true)
                                        <?php ++$stgid; 
                                          $stag = DB::table('ptregistrationstages')->where('stageid',$stgid)->get();
                                        ?>
                                            @if($stag)
                                                @foreach($stag as $items)
                                                
                                                    <div class="col-xl-3 col-md-6 mb-4">
                                                        <div class="card {{ $items->cardcolor }} shadow h-100 py-2">
                                                            <div class="card-body">
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    {{ $items->name }}</div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    @if(RegistrationStatus($matricno,$items->stageid)==false && $items->ispay=='1')
                                                                      
                                                                        <span style="color:red">Pending</span>

                                                                    @else
                                                                        <span style="color:green">Completed</span>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-auto">
                                                                 @if($items->ispay=='1')
                                                                    @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                                                <a href="{{ route('PTPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                                            <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                                            
                                                                            </a>
                                                                    @endif        
                                                                @else
                                                                    <span class="text" style="color:red;"><b>2020202222</b></span>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                
                                                
                                                @endforeach               
                                            @endif
                                 @else
                                 
                                 @endif
                           @endforeach

                        <!-- Earnings (Monthly) Card Example 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!-- Pending Requests Card Example 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <!-- Content Row -->

                   

                    <!-- Content Row -->
                    <div class="row">

                        

                       
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
@endsection
<?php 
 
  function RegistrationStatus($mat,$sid)
  {
     $stag = DB::table('ptregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',$sid)
                                              ->first();  
                                            
     if($stag)
     {
        if($stag->status=="1")
        {
           return true;
        }
        else
        {
            return false;
        }
     }
     else
     {
        return 0;
     }
  }
  function NextStageStatus($mat,$sid)
  {
     $stag = DB::table('ptregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',1)
                                              ->first();   //DB::SELECT('CALL GetRegistrationStatus(?,?)',array($mat,$sid));
     if($stag)
     {
        if($stag->status=="1")
        {
           return true;
        }
        else
        {
            return false;
        }
     }
     else
     {
        return 0;
     }
  }
?>