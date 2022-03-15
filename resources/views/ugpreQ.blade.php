@extends('layouts.appdashboard')
@section('content')
<?php
   $mat = Auth::user()->matricno;
   $sat  = DB::SELECT('CALL FetchNumberOfSeatings(?)', array($mat));
   $locbtn = DB::SELECT('CALL FetchQualificationRecordByMatricNo(?)', array($mat));
   $data  = DB::SELECT('CALL FetchPrequalificationRecordByMatricNo(?)', array($mat));

?>

<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('PreQdata') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-4">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Pre Qualification Data</h1>
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


                                        </div>
                                        <div class="form-group">
                                              <div class="col-sm-12 mb-3 mb-sm-0">
                                                   <select name="examname" id="" class="form-control form-control" required>
                                                        <option value="">Select Examination Name</option>
                                                        <option value="NECO">NECO</option>
                                                        <option value="WAEC">WAEC</option>
                                                        <option value="NABTEB">NABTEB</option>
                                                    </select>

                                              </div>
                                        </div>
                                        <!--
                                        <div class="form-group">
                                             <div class="col-sm-8 mb-3 mb-sm-0">
                                                 <select name="seatings" id="" class="form-control form-control" required>
                                                    <option value="">Select No. of Seatings</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                 </select>
                                           </div>
                                        </div>
                                          -->
                                        <div class="form-group">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="date" name="examdate" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Examination Date" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                                <input type="text" name="examnumber" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Examination Number" required>
                                            </div>
                                        </div>
                                        @if($sat[0]->Seat < 2)
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Add Record</button>

                                            </div>
                                          </div>
                                        @endif


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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Examination Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Exam Name</th>
                                                                        <th>Exam No.</th>
                                                                        <th>Exam Date</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Exam Name</th>
                                                                        <th>Exam No.</th>
                                                                        <th>Exam Date</th>
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
                                                                            <td>{{ $data->examname }}</td>
                                                                            <td>{{ $data->examnumber }}</td>
                                                                            <td>{{ $data->examdate }}</td>
                                                                            <td>
                                                                              @if($locbtn)
                                                                                <span style="color:green">Completed</span>
                                                                              @else
                                                                                  <a href="{{ route('DeletePreQ', $data->id) }}" class="btn btn-danger">Delete</a>    
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

                                             @if($sat[0]->Seat > 0)
                                                <div class="form-group">
                                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                                    <a href="{{ route('ugQualification') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                                         Proceed
                                                     </a>

                                                </div>
                                          </div>
                                        @endif

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
@endsection
