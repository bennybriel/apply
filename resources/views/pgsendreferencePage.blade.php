@extends('layouts.appdashboard')
@section('content')
<?php
   $matricno = Auth::user()->matricno;
   $y =date("Y");
   //$matricno ="PDS20219123614";
   $counter = DB::SELECT('CALL 	CounterPGEmailSentList(?)', array($matricno));
   //dd($counter);
?>

<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            <div class="card-body p-0">
           
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('PGSendReferences') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-5">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Reference Information</h1>
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
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            </div>
                                        </div>
                                                                             
                                     
                                        @if($counter[0]->num < 3)
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" type="submit" style="background:#c0a062;color:white">Send Email</button>

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
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d"></h1>
                                    </div>



                                        @if($data)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Reference Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Email</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
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
                                                                            <td>{{ $data->email }}</td>
                                                                            <td><a href="{{ route('DeleteReferenceInfo', $data->id) }}" class="btn btn-danger">Delete</a></td>
      
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif

                                             @if($counter[0]->num == 3)
                                                  <div class="form-group">
                                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                                         <a href="{{ route('registrationConfrimationPage') }}" class="btn btn-primary">
                                                          Submit To Complete Application  
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
