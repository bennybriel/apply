@extends('layouts.appdashboard')
@section('content')
<?php
     $usr=Auth::user()->usertype;
    
       
     //dd($u);

?>
<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('CreateHalls') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">


                        <div class="p-5">
                        <div class="text-center">
                               <h1 class="h4 mb-4" style="color:#da251d">Student Personal Information</h1>
                        </div>
                                                                                                       
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Student Name:</strong></label>
                                             {{ Auth::user()->name }}
                                                 
                                        </div>                                          
                                    </div> 

                                     <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Student MatricNo</strong></label>
                                             {{ Auth::user()->matricno }}
                                                 
                                        </div>                                          
                                    </div> 
                                     <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Date of Birth</strong></label>
                                             {{ $data[0]->dob }}
                                                 
                                        </div>                                          
                                    </div> 
                                     <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Email </strong></label>
                                             {{ Auth::user()->email }}
                                                 
                                        </div>                                          
                                    </div> 
                                     <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Phone</strong></label>
                                             {{ $data[0]->phone }}
                                                 
                                        </div>                                          
                                    </div> 
                                      <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Gender</strong></label>
                                             {{ $data[0]->gender }}
                                                 
                                        </div>                                          
                                    </div> 
                                      <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label><strong>Marital Status</strong></label>
                                             {{ $data[0]->maritalstatus }}
                                                 
                                        </div>                                          
                                    </div> 







                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                    <h1 class="h4 mb-4" style="color:#da251d">Educational Information</h1>
                                              
                                    </div>
                                     <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                             <label><strong>Department</strong></label>
                                             {{ GetProgramme($data[0]->programme) }}
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                             <label><strong>Admisson Year</strong></label>
                                             {{ $data[0]->admissionyear }}
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                             <label><strong>Admission Mode</strong></label>
                                             {{ $data[0]->admissionmode }}
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                         <div class="col-sm-12 mb-3 mb-sm-0">
                                             <label><strong>Address</strong></label>
                                             {{ $data[0]->address }}
                                         </div>
                                     </div>
                                     <div class="form-group row">
                                           <div class="col-sm-8 mb-3 mb-sm-0">
                                             <label><strong>State</strong></label>
                                             {{ $data[0]->state }}
                                          </div>
                                      </div>
                                       <div class="form-group row">
                                           <div class="col-sm-8 mb-3 mb-sm-0">
                                             <label><strong>LGA</strong></label>
                                             {{ $data[0]->lga }}
                                          </div>
                                      </div>
                                      <div class="form-group row">
                                           <div class="col-sm-8 mb-3 mb-sm-0">
                                             <label><strong>Nationality</strong></label>
                                             {{ $data[0]->nationality }}
                                          </div>
                                      </div>
                                       

                                        <hr>
                               </div>





                            </div>
                        </div>
                    </div>
            </form>

            
                                    
        </div>


@endsection
<?php
  function GetName($sta)
  {
      $st = DB::table('users')->where('matricno',$sta)->first();
      
      return $st->name;
  }
  
  function GetProgramme($pid)
 {
      $pro = DB::table('programme')->where('programmeid', $pid)->get()->first();
      if($pro)
       { return $pro->programme; }
      else{ return $pid; }
 }
?>
