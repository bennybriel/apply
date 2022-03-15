@extends('layouts.appdashboard')
@section('content')

   <!-- Content Row -->
<?php

  use Carbon\Carbon;
  $today = date("Y-m-d");
  $amt=0;
  $ses = Auth::user()->activesession;
  $matricno = Auth::user()->matricno;
  $usr =   Auth::user()->usertype;
  $ispd = Auth::user()->ispaid;
  $isadm = Auth::user()->isadmitted;
  $ismedical = Auth::user()->ismedical;
  $apptype = Auth::user()->apptype;
  $accpt =Auth::user()->isacceptance;
  $istuition =Auth::user()->istuition;
  //Fetch Data
  
  $amount= 0;$amount1=0; $prod="";
  $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
  
  $data   = DB::SELECT('CALL FetchFailedPayments(?)', array($matricno));
  ///dd($id);
  $p2 = DB::SELECT('CALL FetchApplicationListingByID(?)',array($id));
 
?>
   <!-- Content Row -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payment Dashboard</h1>
    
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Hello <i
            class="fas fa-info fa-sm text-white-50"></i> {{ Auth::user()->name }} <?php echo date("l, dS-M-Y") ?></a>
</div>

<!-- Content Row -->
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
                                                        <?php
                                                           // $memberID = session('memberID');
                                                        ?>
                               @endif


   @if($usr=="Student")                           
       
   <div class="col-lg-12">
      <div class="p-3">
   
         @if($data)
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                <div class="alert alert-danger">
                        Payment Transaction Failed
                 </div>
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Failed Payment Record</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Session</th>
                                    <th>Amount</th>                        
                                    <th>PaymentType</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                            </thead>
                             
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->session }}</td>
                                                                            <td>&#8358;{{ number_format($data->amount,2) }}</td>
                                                                          
                                                                            <td>{{ $data->description  }}</td>
                                                                            <td>{{ Carbon::parse($data->created_at)->format('d-m-Y,h:m:s A') }}</td>
                                                                            <td> 
                                                                              
                                                                              @if($data->response)
                                                                              
                                                                                <span style="color:red">{{ $data->response }}</span>
                                                                              @else
                                                                              <span style="color:red">Pending</span>
                                                                              @endif
                                                                            </td> 
                                                                            <td> 
                                                                              <a href="{{ route('QueryTransaction', $data->transactionID) }}" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                             </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                             <h6 style="color:#da251d">Please Click Pay Now, Below To Try Again  </h6>
                                                        </div>
                                                    </div>
                                                </div>
            @else
                 <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><strong>@if($p2) {{ $p2[0]->name }} @endif</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                         @if($id  && $pname)
                                            <div class="col-auto">
                                                <h7>&#8358;{{ number_format($p2[0]->amount,2) }} </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="{{ route('PayingNow',['id'=>$id,'prod'=>$pname])  }}"
                                                                                class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Pay Now</span>
                                                </a>
                                                <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                                </div>
                                            @else
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Payment Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            @endif

                                        </div>
                                    
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
                                             

         @endif
 
      </div>
    </div>
@endif







@endsection

