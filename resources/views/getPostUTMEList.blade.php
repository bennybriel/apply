@extends('layouts.appdashboard')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
              
                    <div class="row">
              
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        @if($data)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Download Post UTME Candidate Information</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Session</th>
                                                                        <th>Application</th>                                                                       
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Session</th>
                                                                        <th>Application</th>                                                                      
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->activesession }}</td>
                                                                            <td>{{ $data->apptype }}</td>
                                                                           
                                                                             <?php 
                                                                               $ses = str_replace("/","",$data->activesession);
                                                                             ?>
                                                                            <td><a href="{{ route('GetPostUTMEListByAppType', [$ses,$data->apptype]) }}" class="btn"  style="background:#c0a062;color:white">Download</a></td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                Total Amount:
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif

                                             

                                </div>

                             </div>


                        </div>
                    </div>
           
        </div>

@endsection
