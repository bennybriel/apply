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
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('UploadBiodataUpdates') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Upload Biodata Updates Instructions</h1>
                                    </div>
                                  
                                      
                                        
                                        <div class="form-group row">
                                             <div class="col-sm-12 mb-3 mb-sm-0">
                                             
                                                  <p style="text-align:justify">
                                                     Please note: To upload admission list, the excel sheet should have only two columns with no heading or header. For example JUP0000001 
                                                     as the first column and 'Q' as the second column. Please click to <a href="templates/admissionlist_template.xlsx">download Template</a>
                                                     to use for the upload.
                                                    
                                                  </p>
                                            </div>

                                         </div>
                                            

                                        
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Upload Biodata Updates</h1>
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

                                    </div>
                                       <div class="form-group row">
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                             <select class="form-control" name="session" required>
                                                <option value="">Select Session</option>
                                                @foreach($lst as $lst)
                                                    <option value="{{ $lst->name }}">{{ $lst->name }}</option>
                                                @endforeach

                                               </select>
                                          </div>
                                       </div>
                               
                                       <div class="form-group row">
                                          <div class="col-sm-8 mb-3 mb-sm-0">
                                               <input type="file" name="resultfile" class="form-control form-control"
                                                 id="exampleFirstName"  required>
                                          </div>
                                       </div>       
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Upload Biodata</button>

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                @if($data)
                                       <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Uploaded Admission List</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME Number</th>
                                                                        <th>Name</th>
                                                                        <th>Stage</th>
                                                                        
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME Number</th>
                                                                        <th>Name</th>
                                                                        <th>Stage</th>
                                                                        
                                                                     

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->utme }}</td>
                                                                            <td>{{ GetName($data->utme) }}</td>
                                                                            <td>
                                                                               {{ GetStageName($data->stageid) }} 
                                                                                 
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
<?php 
 function GetStageName($sid)
 {
     $s =DB::table('registrationstages')->where('stageid',$sid)->first();
     if($s)
     {
         return $s->name;
     }
     else
     {
         return $sid;
     }
 }
 function GetName($utme)
 {
     $ss =DB::table('admission_lists')->where('utme',$utme)->first();
     if($ss)
     {
         return $ss->name;
     }
     else
     {
         return $utme;
     }
 }
?>