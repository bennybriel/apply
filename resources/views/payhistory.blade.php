@extends('layouts.appdashboard')
@section('content')

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
  $amt=0;
  $ses = Auth::user()->activesession;
  $matricno = Auth::user()->matricno;
//dd($data);


?>
   <!-- Content Row -->

      @if($data)
           <div class="card shadow mb-4">
                <div class="card-header py-3">
                     <h3 style="color:#da251d">Check Your Payment Status Here</h3>
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Payment History</h6>
                  
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>TransactionID</th>
                                    <th>Session</th>
                                    <th>Amount</th>                        
                                    <th>PaymentType</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                                                                            <td>{{ $data->transactionID }}</td>
                                                                            <td>{{ $data->session }}</td>
                                                                            <td>&#8358;{{ number_format($data->amount,2) }}</td>
                                                                          
                                                                            <td>{{ $data->description  }}</td>
                                                                            <td>{{ Carbon::parse($data->created_at)->format('d-m-Y,h:m:s A') }}</td>
                                                                            <td> 
                                                                            
                                                                               @if($data->response=="Approved Successful")
                                                                                  <span style="color:green">{{ $data->response }}</span>
                                                                                @else
                                                                                  <span style="color:red">{{ $data->response }}</span>
                                                                                @endif
                                                                            </td> 
                                                                              <td> 
                                                                               
                                                                                  <a href="{{ route('QueryTransactioning', $data->transactionID) }}"  class="btn btn-primary">Check Status</a>
                                                                              
                                                                             </td>

                                                                            <td> 
                                                                                @if($data->response=="Approved Successful" || $data->response=="Transaction Successful")
                                                                                  <a href="{{ route('ReceiptSlip', $data->transactionID) }}" style="background:#c0a062;color:#FFF" class="btn">Get Receipt</a>
                                                                                @endif
                                                                                @if($data->response=="Pending")
                                                                                    <a href="{{ route('CancelMyTransaction', $data->transactionID) }}" class="btn btn-danger">Cancel Transaction</a>  
                                                                                @endif
                                                                             </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>


      @endif






<div class="row">
<!-- Area Chart
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">

        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">

        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Registration Process</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
            </div>
            <div class="mt-4 text-center small">
                <span class="mr-2">
                    <i class="fas fa-circle text-primary"></i> Direct
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-success"></i> Social
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-info"></i> Referral
                </span>
            </div>
        </div>
    </div>
</div>
 -->
</div>


@endsection

<?php

function randomPassword() 
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		//return implode($pass); //turn the array into a string
		return implode($pass);
	}

?>