@extends('layouts.appdashboard')
@section('content')
<?php
   $mat = Auth::user()->matricno;
   $y =date("Y");
  // dd($data);
?>

<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('PGQualifications') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-4">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Educational Qualification Data</h1>
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
                                                   <select name="degree" id="degree" class="form-control form-control" required>
                                                        <option value="">Select Degree</option>
                                                       
                                                        @foreach($deg as $deg)
                                                           <option value="{{ $deg->name }}">{{ $deg->name }}</option>
                                                        @endforeach
                                                    
                                                    </select>

                                              </div>
                                        </div>
                                        <div class="form-group row">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="award" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Discipline " required>
                                            </div>
                                        </div>
                                                                               
                                      
                                        <div class="form-group row">
                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                 <select name="year" id="year" class="form-control form-control" required>
                                                    <option value="">Year</option>
                                                    <?php
                                                   
                                                       for($k=1900;$k<=$y; $k++)
                                                       {
                                                     ?>
                                                       <option value="<?php  echo $k  ?>"><?php  echo $k  ?></option>
                                                      <?php } ?>
                                                 </select>
                                              </div>
                                             
                                        </div>
                                         
                                        <div class="form-group row">
                                                <div class="col-sm-12 mb-3 mb-sm-0">
                                                   <select name="degreeclass" id="degreeclass" class="form-control form-control" required>
                                                        <option value="">Select Class of Degree</option>
                                                       
                                                        @foreach($cla as $cla)
                                                           <option value="{{ $cla->name }}">{{ $cla->name }}</option>
                                                        @endforeach
                                                    
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
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        @if($data)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Qualification Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Degree</th>
                                                                        <th>Date</th>
                                                                        <th>Award</th>
                                                                        <th>Class of Degree</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Degree</th>
                                                                        <th>Date</th>
                                                                        <th>Award</th>
                                                                        <th>Class of Degree</th>
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
                                                                            <td>{{ $data->degree }}</td>
                                                                            <td>{{ $data->year }}</td>
                                                                            <td>{{ $data->award }}</td>
                                                                            <td>{{ $data->classofdegree }}</td>
                                                                         
                                                                            <td>
                                                                                <a href="{{ route('DeleteQualification', $data->id) }}" class="btn btn-danger">Delete</a>
                                                                            </td>
      
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
                                                    <a href="{{ route('pgappointmentPage') }}" class="btn btn-primary">
                                                         Proceed To Appointment
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
