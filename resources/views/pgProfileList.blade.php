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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">PG Candidate Information</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>App.No</th>
                                                                        <th>Form No.</th>
                                                                        <th>Name</th>
                                                                        <th>Department</th>
                                                                        <th>Email</th>
                                                                       
                                                                        
                                                                        <th>Action</th>
                                                                      

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>App.No/th>
                                                                        <th>Form No.</th>
                                                                        <th>Name</th>
                                                                        <th>Department</th>
                                                                        <th>Email</th>
                                                                     
                                                                       
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
                                                                            
                                                                            <td>{{ $data->appnumber }}</td>

                                                                            <td>{{ $data->formnumber }}</td>
                                                                            <td>{{ $data->surname }} {{ $data->firstname }} {{ $data->othername }}</td>
                                                                            <td>{{ $data->department }}</td>
                                                                            <td>{{ $data->email }}</td>
                                                                           
                                                                            
                                                                            <td><a href="{{ route('EditProfile', $data->matricno) }}" class="btn"  style="background:#c0a062;color:white">Edit</a></td>

                                                                        
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
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
