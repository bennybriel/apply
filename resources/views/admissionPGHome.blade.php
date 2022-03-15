@extends('layouts.appdashboard')
@section('content')
<?php
 
 $stag = DB::table('pgregistrationstages')->where('degree','All')->get();
 $matricno = Auth::user()->matricno;
 $deg = DB::table('pgadmissionlist')->where('formnumber', Auth::user()->formnumber)->first();
 $stag1 = DB::table('pgregistrationstages')->where('degree',$deg->degree)->orderby('stageid','asc')->get();
 //dd($deg);
?>
  <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Post Graduate Dashboard</h1>
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

                                            
                                     <a href="{{ route('admissionLetterPG') }}" class="btn btn-success">
                                           Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Acceptance Form</div>
                                           
                                        </div>
                                        <div class="col-auto">
                                        <a href="{{ route('pgAcceptanceForm') }}" class="btn btn-success">
                                                Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                       @if($stag)
                           @foreach($stag as $items)
                                @if($items->stageid == '1')
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
                                                            <a href="{{ route('PGPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                        <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                           
                                                        </a>
                                                   @endif        
                                                 
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                                @endif
                            @endforeach               
                       @endif

                       
                     @if($stag1)
                        @foreach($stag1 as $items)
                                
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
                                                   @if(RegistrationStatus($matricno,$items->stageid)==true)
                                                           <a href="{{ route('PGPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                            <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                            @else
                                                            
                                                           @endif
                                                       </a> 
                                              @endif        
                                              
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                               
                            @endforeach 
                  
                     @endif

                     @if($stag)
                         @foreach($stag as $items)
                                @if($items->stageid == '4')
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
                                                          
                                                   @endif        
                                                 
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
                                @endif
                            @endforeach 
                   
                     @endif
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
     $stag = DB::table('pgregistrationprogress')
                                              ->where('matricno',$mat)
                                              ->where('stageid',$sid)
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

  function NextStageStatus($mat,$sid)
  {
     $stag = DB::table('pgregistrationprogress')
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