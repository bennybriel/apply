@extends('layouts.appdashboard1')
@section('content')

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
 // dd($data);
?>
   <!-- Content Row -->

   @if($data)
          <div style="overflow-x:auto; ">
                <table width="830" border="0" align="center">
               <thead>
                 <tr>
                   <td width="232" rowspan="10" class="noBorder" >
				    
				   <img class="nav-user-photo" src="{{ asset('../Passports/'.$data[0]->photo) }}" alt="image" width="183" height="200px" /></td>
                  
                    <td width="171" class="noBorder" >Student Name</td>
                    <td width="413" class="noBorder1"><b>{{ $data[0]->name}}</b></td>
                 </tr>
                  <tr>
                    <td class="noBorder">UTME Registration No.</td>
                    <td class="noBorder1"><b>{{ $data[0]->utme}}</b></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Department</td>
                    <td class="noBorder1"><b>{{ $data[0]->programme }}</b></td>
                 </tr>

                 <tr>
                   <td class="noBorder">Session </td>
                    <td class="noBorder1"><b>{{ $data[0]->session }}</b></td>
                 </tr>

                 <tr>
                   <td class="noBorder">Marital Status </td>
                    <td class="noBorder1"><b>{{ $data[0]->maritalstatus }}</b></td>
                 </tr>

                 <tr>
                   <td class="noBorder">Email</td>
                    <td class="noBorder1"><b>{{ $data[0]->email }}</b></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Phone</td>
                    <td class="noBorder1"><b>{{ $data[0]->phone }}</b></td>
                 </tr>
                 <tr>
                   <td class="noBorder">Date of Birth</td>
                    <td class="noBorder1"><b>{{ Carbon::parse($data[0]->dob)->format('d-m-Y') }}</b></td>
                 </tr> 
                 <tr>
                   <td class="noBorder">State of Orgin</td>
                    <td class="noBorder1"><b>{{ $data[0]->state }}</b></td>
                 </tr>
                 <tr>
                 <td class="noBorder">Local Govt. Area </td>
                   <td class="noBorder1"><b>{{ $data[0]->lga }}</b></td>
                 </tr>
                 </thead>
          </table>
       </div>
  @endif
  @if($olevel)

           <div class="card shadow mb-4">
                <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">OLevel Qualification</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Exam Number</th>
                                    <th>Subject</th>                        
                                    <th>Grade</th>
                                    <th>Exam Name</th>

                                 </tr>
                            </thead>
                             
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($olevel as $res)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $res->examnumber }}</td>
                                                                            <td>{{ $res->subject}}</td>
                                                                            <td>{{ $res->grade  }}</td>
                                                                            <td>{{ $res->examtype }}</td>                                                                        
                                                                          

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                         </div>
                                                    </div>
                                                </div>


     

  @endif

               <div class="col-lg-6">

                    <div class="form-group row">
                         <div class="col-sm-3 mb-3 mb-sm-0">
                         </div>
                         <div class="col-sm-3 mb-3 mb-sm-0">
                         <a href="{{ route('documentScreening') }}" style="background:red;color:#FFF" class="btn">Rejected</a>
                            </div>
                   
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <a href="{{ route('AdmissionProcess', $data[0]->utme) }}" style="background:#c0a062;color:#FFF" class="btn">Accepted</a>
                         </div>
                         <div class="col-sm-3 mb-3 mb-sm-0">
                         </div>
                    </div>
                 </div>



@endsection

