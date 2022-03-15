@extends('layouts.appdashboard')
@section('content')
<?php
   $stgid =1;
   $std =""; $bal=0;
   $stag = DB::table('pdsregistrationstages')->where('stageid',$stgid)->get();
   $matricno = Auth::user()->matricno;
   $stg = DB::table('pdsregistrationstages')->get();
   $sts =$st;
   $paid = GetTotalAmountPaid($matricno);
   $tu = DB::table('pdsregistrationstages')->select('amount')
                                           ->where('payprefix','TU')
                                           ->where('paytype',$sts)
                                           ->first();
   
   $bal = $tu->amount - $paid;
   if($bal > 0 &&  $paid > 0 )
   {
       $bal+=300;
   }
   //dd($bal);
   $pid  = DB::table('pdsregistrationstages')->where('amount',$bal)->first();

?>
  <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Predegree Student Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-dark shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                               Admission Letter
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">

                                            
                                     <a href="{{ route('admissionLetterPDS') }}" class="btn btn-success">
                                           Download
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                     
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
                                                            <a href="{{ route('PDSPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
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
                                     $stag = DB::table('pdsregistrationstages')->where('stageid',$stgid)->where('istate',$sts)->get();
                                     $stag1= DB::table('pdsregistrationstages')->where('stageid',$stgid)->where('istate','N')->get();
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
                                                               @if($bal > 0 && $items->payprefix=='TU')
                                                                  <span style="color:red">Pending</span>
                                                               @else
                                                                  <span style="color:green">Completed</span>
                                                                @endif
                                                            @endif
                                                            </div>
                                                        </div>
                                                    
                                                    <div class="col-auto">
                                                         @if($items->ispay=='1')
                                                          
                                                            @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                                        <a href="{{ route('PDSPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                                           <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                                    
                                                                       </a>
                                                            @else
                                                                  @if($bal > 0 && $items->payprefix=='TU')
                                                                          <a href="{{ route('PDSPayNow',['id'=>$pid->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                                              <span class="text">Pay &#8358;{{ number_format($bal,2)}}</span>
                                                                          </a>
                                                        
                                                                  @endif
                                                            @endif        
                                                        @else
                                                            <span class="text" style="color:red;"><b>{{ Auth::user()->formnumber }}</b></span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
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
                                                            @if(RegistrationStatus($matricno,$items->stageid)==false && $items->ispay=='1')
                                                              
                                                                <span style="color:red">Pending</span>

                                                            @else
                                                               @if($bal > 0 && $items->payprefix=='TU')
                                                                  <span style="color:red">Pending</span>
                                                               @else
                                                                  <span style="color:green">Completed</span>
                                                                @endif
                                                            @endif
                                                            </div>
                                                        </div>
                                                    
                                                    <div class="col-auto">
                                                         @if($items->ispay=='1')
                                                          
                                                            @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                                        <a href="{{ route('PDSPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                                           <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                                    
                                                                       </a>
                                                            @else
                                                                  @if($bal > 0 && $items->payprefix=='TU')
                                                                          <a href="{{ route('PDSPayNow',['id'=>$pid->productid,'prod'=>$items->name,'sid'=>$items->stageid,'prefix'=>$items->payprefix]) }}" class="btn btn-success">
                                                                              <span class="text">Pay &#8358;{{ number_format($bal,2)}}</span>
                                                                          </a>
                                                        
                                                                  @endif
                                                            @endif        
                                                        @else
                                                            <span class="text" style="color:red;"><b>{{ Auth::user()->formnumber }}</b></span>
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
                       

                     
                   

                    <!-- Content Row -->
                    <div class="row">

                        

                       
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
@endsection
<?php 
  function GetTotalAmountPaid($matricno)
  {
    $amt=0;
    //$matricno =Auth::user()->matricno;
    $pid = DB::table('u_g_student_accounts as st')->select(DB::raw("SUM(st.amount) as amounts")) 
                                                    ->join('pdsregistrationstages as pt','pt.productid','=','st.productid')            
                                                    ->where('matricno',$matricno)
                                                    ->where('payprefix', 'TU')
                                                    ->where('ispaid', 1)
                                                    ->get();
    //dd($pid);
   
    
     
     return $pid[0]->amounts;

  }
  function RegistrationStatus($mat,$sid)
  {
     $stag = DB::table('pdsregistrationprogress')
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
     $stag = DB::table('pdsregistrationprogress')
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