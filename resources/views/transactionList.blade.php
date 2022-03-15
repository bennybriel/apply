@extends('layouts.appdashboard')
@section('content')

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
  $amt=0;
  $matricno = $data[0]->matricno;



?>
   <!-- Content Row -->

      @if($data)
           <div class="card shadow mb-4">
                <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Transaction History</h6>
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
                                                                            
                                                                               @if($data->response=="Approved Successful")
                                                                                  <span style="color:green">{{ $data->response }}</span>
                                                                                @else
                                                                                  <span style="color:red">{{ $data->response }}</span>
                                                                                @endif
                                                                            </td> 
                                                                            <td> 
                                                                                @if($data->response=="Approved Successful" || $data->response=="Transaction Successful")
                                                                                  <a href="{{ route('ReceiptSlip', $data->transactionID) }}" style="background:#c0a062;color:#FFF" class="btn">Get Receipt</a>
                                                                                @else
                                                                                <a href="{{ route('QueryTransactAdmin', $data->transactionID) }}" style="background:#da251d;color:white" class="btn">Check Status</a>
                                                                       
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

</div>


@endsection