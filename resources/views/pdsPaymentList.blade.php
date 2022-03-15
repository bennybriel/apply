@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
     $staffid = Auth::user()->matricno;
    // $u = DB::SELECT('CALL GetCurrentUserRole(?)', array($staffid));
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
              
            
                                @if($data)
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">JUPEB Payment Summary</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Formnumber</th>
                                                                        <th>Name</th>
                                                                        <th>Acceptance</th>
                                                                        <th>Medical</th>
                                                                        <th>Tuition</th>
                                                                        <th>Date</th>
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Formnumber</th>
                                                                        <th>Name</th>
                                                                        <th>Acceptance</th>
                                                                        <th>Medical</th>
                                                                        <th>Tuition</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->formnumber }} </td>
                                                                            <td>{{ $data->names }} </td>  
                                                                            <td> @if($data->isacceptance==true) 
                                                                                   <span style="color:green"> Yes </span>
                                                                                 @else
                                                                                    <span style="color:red"> No </span>
                                                                                 @endif   

                                                                            </td>
                                                                            <td> @if($data->ismedical==true) 
                                                                                   <span style="color:green"> Yes </span>
                                                                                 @else
                                                                                    <span style="color:red"> No </span>
                                                                                 @endif   

                                                                            </td>
                                                                            <td> {{ $data->paymenttype }} </td>
                                                                            <td> {{ $data->created_at }} </td>
                                                                         </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                        @endif
        </div>


@endsection

