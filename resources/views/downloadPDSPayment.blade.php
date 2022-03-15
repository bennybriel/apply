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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Download Payment</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Acceptance</th>
                                                                        <th>Medical</th>
                                                                        <th>Tuition</th>
                                                                       
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                       <th>SN</th>
                                                                        <th>Application</th>
                                                                        <th>Session</th>
                                                                        <th>Acceptance</th>
                                                                        <th>Medical</th>
                                                                        <th>Tuition</th>
                                                                      

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <?php 
                                                                               $ses = str_replace("/","",$data->activesession);
                                                                               
                                                                             ?>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>PDS</td>
                                                                            <td>{{ $data->activesession }} </td>  
                                                                            <td><a href="{{ route('DownloadPDSPayment', ['ses'=>$ses,'pat'=>'Acc']) }}" class="btn btn-primary">Download</a> </td>  
                                                                            <td><a href="{{ route('DownloadPDSPayment', ['ses'=>$ses,'pat'=>'Med']) }}" class="btn btn-success">Download</a></td>  
                                                                            <td><a href="{{ route('DownloadPDSPayment', ['ses'=>$ses,'pat'=>'Tut']) }}" class="btn" style="background:#c0a062;color:#FFF">Download</a> </td>  
                                                                            
                                                                         
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

