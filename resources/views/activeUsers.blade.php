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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Active Users</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name</th>
                                                                        <th>Formnumber</th>
                                                                        <th>Email</th>
                                                                        <th>Apptype</th>
                                                                        <th>LastSeen</th>
                                                                        <th>Action</th>
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Name</th>
                                                                        <th>Formnumber</th>
                                                                        <th>Email</th>
                                                                        <th>Apptype</th>
                                                                        <th>LastSeen</th>
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
                                                                            <td>{{ $data->name }} </td>
                                                                            <td>{{ $data->formnumber }} </td>
                                                                            <td>{{ $data->email }} </td>
                                                                            <td>{{ $data->apptype }} </td>
                                                                            <td>{{ Carbon\Carbon::parse($data->last_seen)->diffForHumans() }} </td>
                                                                            <td>
                                                                              @if(Cache::has('user-is-online-' . $data->id))
                                                                                    <span class="text-success">Online</span>
                                                                                @else
                                                                                    <span class="text-secondary">Offline</span>
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
        </div>


@endsection

