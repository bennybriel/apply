@extends('layouts.appdashboard')
@section('content')
<?php
   $mat = Auth::user()->matricno;
   $y =date("Y");
?>

<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('PGAppointments') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-5">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Appointment Data</h1>
                                    </div>
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

                                                @endif

                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="employer" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Employer's Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="post" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Position" required>
                                            </div>
                                        </div>
                                                                             
                                        <div class="form-group row">
                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                 <select name="startyear" id="" class="form-control form-control" required>
                                                    <option value="">Start Year</option>
                                                    <?php
                                                   
                                                       for($k=1900;$k<=$y; $k++)
                                                       {
                                                     ?>
                                                       <option value="<?php  echo $k  ?>"><?php  echo $k  ?></option>
                                                      <?php } ?>
                                                 </select>
                                              </div>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                 <select name="endyear" id="" class="form-control form-control" required>
                                                    <option value="">End Year</option>
                                                    <?php
                                                       for($k=1900;$k<=$y; $k++)
                                                       {
                                                     ?>
                                                       <option value="<?php  echo $k  ?>"><?php  echo $k  ?></option>
                                                      <?php } ?>
                                                 </select>
                                              </div>
                                        </div>
                                         
                                       
                                       
                                     
                                       
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Add Record</button>

                                            </div>
                                          </div>
                                      


                                        <div class="form-group">
                                           <div class="col-sm-12 mb-3 mb-sm-0">
                                            <!-- DataTales Example -->


                                            </div>
                                        </div>




                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        @if($data)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Appointment Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Employer</th>
                                                                        <th>Post</th>
                                                                        <th>Start Year</th>
                                                                        <th>End Year</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Employer</th>
                                                                        <th>Post</th>
                                                                        <th>Start Year</th>
                                                                        <th>End Year</th>
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
                                                                            <td>{{ $data->employer }}</td>
                                                                            <td>{{ $data->post }}</td>
                                                                            <td>{{ $data->startyear }}</td>
                                                                            <td>{{ $data->endyear }}</td>  
                                                                            <td><a href="{{ route('DeleteAppointment', $data->id) }}" class="btn btn-danger">Delete</a></td>
      
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif

                                             @if($data)
                                                <div class="form-group">
                                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                                    <a href="{{ route('pgpublicationPage') }}" class="btn btn-primary">
                                                         Proceed To Publications
                                                     </a>

                                                </div>
                                                @endif

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
@endsection
