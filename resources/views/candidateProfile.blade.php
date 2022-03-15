@extends('layouts.appdashboard1')
@section('content')

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
 
  $amt=0;
  $ses = Auth::user()->activesession;
  $ispd = Auth::user()->ispaid;
  $matricno = Auth::user()->matricno;
  $isadm = Auth::user()->isadmitted;
  $usr =   Auth::user()->usertype;


       #Debit Student Account
      
      // Auth::user()->photo;
       //dd(Auth::user()->photo);

?>
   <!-- Content Row -->

   @if($data)
          <div style="overflow-x:auto; ">
                <table width="830" border="0" align="center">
               <thead>
                 <tr>
                   <td width="232" rowspan="9" class="noBorder" >
				    
				   <img class="nav-user-photo" src="{{ asset('public/Passports/'.$data[0]->photo) }}" alt="image" width="183" height="200px" />		
            
				   </td>
                  
                    <td width="144" class="noBorder" >Student Name</td>
                    <td width="440" class="noBorder1">{{ $data[0]->names}}</td>
                 </tr>
                  <tr>
                    <td class="noBorder">FormNumber</td>
                    <td class="noBorder1">{{ $data[0]->formnumber}}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Category 1 </td>
                    <td class="noBorder1">{{ $data[0]->category1 }}</td>
                 </tr>

                 <tr>
                   <td class="noBorder">Category 2 </td>
                    <td class="noBorder1">{{ $data[0]->category2 }}</td>
                 </tr>

                 <tr>
                   <td class="noBorder">Session </td>
                    <td class="noBorder1">{{ $data[0]->session }}</td>
                 </tr>

                 <tr>
                   <td class="noBorder">Email</td>
                    <td class="noBorder1">{{ $data[0]->email }}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Phone</td>
                    <td class="noBorder1">{{ $data[0]->phone }}</td>
                 </tr>
                 <tr>
                   <td class="noBorder">Date of Birth</td>
                    <td class="noBorder1"> {{ Carbon::parse($data[0]->dob)->format('d-m-Y') }}</td>
                 </tr> 
                 <tr>
                   <td class="noBorder">State of Orgin</td>
                    <td class="noBorder1">{{ $data[0]->state }}</td>
                 </tr>
                 </thead>
          </table>
       </div>
  @endif
  @if($result)

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
                                                                    @foreach($result as $res)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $res->examnumber }}</td>
                                                                            <td>{{ $res->subject}}</td>
                                                                            <td>{{ $res->grade  }}</td>
                                                                            <td>{{ $res->examname }}</td>                                                                        
                                                                          

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                         </div>
                                                    </div>
                                                </div>


     

  @endif








                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                       <div class="form-group">
                           <button class="btn px-4" type="submit" 
                           style="background:#c0a062;color:white">Admit Now</button>
                         </div>
                    </div>
                 </div>



@endsection

