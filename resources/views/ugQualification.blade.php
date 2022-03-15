@extends('layouts.appdashboard')
@section('content')
<?php
   $mat = Auth::user()->matricno;
   $grad  = DB::SELECT('CALL FetchNumberOfGrades(?)', array($mat));
   $apptype = Auth::user()->apptype;
?>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" method="post" action="{{ route('QuaData') }}">
                     {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-4">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Qualification Data</h1>
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
                                                   <select name="examnumber" id="examnumber" class="form-control form-control" required>
                                                        <option value="">Select Examination Number</option>
                                                        @foreach($rec as $rec)
                                                        <option value="{{ $rec->examnumber }}">{{ $rec->examname }}</option>
                                                        @endforeach
                                                    </select>

                                              </div>
                                        </div>

                                        <div class="form-group">
                                              <div class="col-sm-12 mb-3 mb-sm-0">
                                                   <select name="subject" id="subject" class="form-control form-control" required>
                                                        <option value="">Select Subject</option>
                                                        @foreach($sub as $sub)
                                                            <option value="{{ $sub->subject }}">{{ $sub->subject  }}</option>
                                                        @endforeach

                                                    </select>

                                              </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-sm-8 mb-3 mb-sm-0">
                                                 <select name="grade" id="grade" class="form-control form-control" required>
                                                    <option value="">Select Grade</option>
                                                    <option value="AR">AR</option>
                                                    <option value="A1">A1</option>
                                                    <option value="B2">B2</option>
                                                    <option value="B3">B3</option>
                                                    <option value="C4">C4</option>
                                                    <option value="C5">C5</option>
                                                    <option value="C6">C6</option>
                                                    <option value="D7">D7</option>
                                                    <option value="E8">E8</option>
                                                    <option value="F9">F9</option>
                                                 </select>
                                           </div>
                                        </div>



                                        @if($grad[0]->Counter < 9)
                                           <div class="form-group">
                                              <div class="col-sm-8 mb-3 mb-sm-0">
                                                <button class="btn px-4" id="" type="submit" style="background:#c0a062;color:white"> Add Record</button>

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
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Examination Grade Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Exam No.</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                         <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Exam No.</th>
                                                                        <th>Grade</th>
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
                                                                            <td>{{ $data->subject }}</td>
                                                                            <td>{{ $data->grade }}</td>
                                                                            <td>{{ $data->examnumber }}</td>

                                                                            <td><a href="{{ route('DeleteQual', $data->id) }}" class="btn btn-danger">Delete</a></td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif

                                             @if($grad[0]->Counter >=5)
                                                <div class="form-group">
                                                    <div class="col-sm-8 mb-3 mb-sm-0">
                                                  
                                                    @if($apptype =="PG")
                                                         <a href="{{ route('pgeducationPage') }}" class="btn btn-primary" style="background:#c0a062;color:white">
                                                           Proceed To Education Info
                                                      </a>
                                                    @else
                                                      <a href="{{ route('registrationConfrimationPage') }}" class="btn btn-primary" style="background:#c0a062;color:white">
                                                           Submit To Complete Registration
                                                      </a>
                                                    @endif

                                                </div>
                                          </div>
                                        @endif

                                </div>

                             </div>


                        </div>
                    </div>
            </form>
        </div>
<script src="js/jquery-3.3.1.js"></script>
<script type='text/javascript'>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function()
{

 // Add record
  $('#AddRec').click(function()
  {
  
    var subject = $('#subject').val();
    var grade   = $('#grade').val();
    var examnumber = $('#examnumber').val();
     
    if(subject != '' && grade != '' && examnumber != '')
    {
        
      $.ajax({
        url: 'QuaData',
        type: 'post',
        data: {_token: CSRF_TOKEN, subject: subject, grade: grade, examnumber: examnumber },
        success: function(response)
        {
            alert('Submitted Successfully');
           window.location = "ugQualification";      
        }
      });

    }
    else
    {
      alert('Reguired Field, Please');
    }
  });

});

</script>


@endsection
