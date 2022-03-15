@extends('layouts.appdashboard')
@section('content')
<?php
    $psurname   = session('psurname');
    $pfirstname = session('pfirstname');
    $pemail   = session('pemail');
    $relation = session('relation');
    $pphone   = session('pphone');
    $paddress = session('paddress');

    $dob   = session('dob');
    $phone = session('phone');
    $address   = session('address');
    $gender = session('gender');
    $marital   = session('marital');
    $town = session('town');
    $state = session('state');

    $faculty   = session('faculty');
    $photo = session('photo');
    $religion   = session('religion');
    $admissiontype = session('admissiontype');
    $category1   = session('category1');
    $category2 = session('category2');
    $department = session('department');
    $matricno = Auth::user()->matricno;

    $sname   = session('sname');
    $saddress = session('saddress');
    $semail   = session('semail');
    $sphone   = session('sphone');

    $ap = DB::SELECT('CALL GetStudentAccountInfo(?)',array($matricno));
  
  $apt = Auth::user()->apptype;

?>
<script src="js/jquery-3.3.1.js"></script>
<div class="card o-hidden border-0 shadow-lg my-5">
 
            <div class="card-body p-0">
            <div class="col-xl-3 col-md-6 mb-4">
           
            </div>
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('PGDataForms') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">
  

                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Data Page Post Graduate</h1>
                                        <h6 style="color:red">Note: Your Passport Should Not Be More Than 20KB </h6>
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

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($data)
                                                    <input type="text" name="surname" value="{{ $data[0]->surname }}" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" readonly>
                                                @else
                                                <input type="text" name="surname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                @endif

                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($data)
                                                    <input type="text" name="firstname" locked="false" value="{{ $data[0]->firstname }}" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name" readonly>
                                                @else
                                                    <input type="text" name="firstname" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name" required>
                                                @endif
                                            </div>

                                           
                                        </div>
                                        <div class="form-group row">
                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($data)
                                                    <input type="text" name="othername" locked="false" value="{{ $data[0]->othername }}" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="Other Name" readonly>
                                                @else
                                                    <input type="text" name="othername" value="{{ $othername }}" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="Other Name">
                                                @endif
                                            </div>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($data)
                                                    <input type="hidden" value="{{ $data[0]->matricno }}" name="utme" class="form-control form-control"
                                                    id="exampleInputPassword" placeholder="UTME Reg/MatricNo" readonly>
                                                @else
                                                    <input type="hidden" name="utme" class="form-control form-control"
                                                    id="exampleInputPassword" placeholder="UTME Registration Number" required>
                                                @endif

                                            </div>

                                         </div>
                                            

                                        <div class="form-group">
                                            @if($data)
                                                <input type="email" name="email" value="{{ $data[0]->email }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" readonly>
                                            @else
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            @endif
                                        </div>



                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
											@if($result)
                                                 <input type="date" name="dob" value="{{ $result[0]->dob }}" class="form-control form-control"
                                                        id="exampleRepeatPassword" placeholder="Date of DOB">
									        @else
												        <input type="date" name="dob" value="{{ $dob }}" class="form-control form-control"
                                                        id="exampleRepeatPassword" placeholder="Date of DOB" required>
											
											@endif

                                            </div>
                                          
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              @if($result)
                                                <input type="text" name="phone" value={{ $result[0]->phone }} class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
										     @else
												  <input type="text" value="{{ $phone }}" name="phone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
											 @endif
                                            </div>
                                        </div>


                                        <div class="form-group">
										 @if($result)
                                            <input type="text" name="address" value="{{ $result[0]->address }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address">
										@else
											  <input type="text" name="address" value="{{ $address }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
										@endif
                                        </div>
                                        <div class="form-group row">  
                                         @if($result)
                                          <div class="col-sm-6 mb-3 mb-sm-0">
                                         
                                               <select name="gender" id="" class="form-control form-control" required>
                                                    <option value="{{ $result[0]->gender }}">{{ $result[0]->gender }}</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                           </div>  
                                          @else
                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="gender" id="" class="form-control form-control" required>
                                                   @if($gender)
                                                       <option value="{{ $gender }}">{{$gender}}</option>
                                                       <option value="Male">Male</option>
                                                       <option value="Female">Female</option>
                                                   @else
                                                      <option value="">Gender</option>
                                                   @endif
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select> 
                                           
                                            </div>
                                         @endif
                                          @if($result)
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select name="maritalstatus" id="" class="  form-control form-control" required>
                                                        <option value="{{ $result[0]->maritalstatus }}">{{ $result[0]->maritalstatus }}</option>  
                                                    
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                 
                                                       
                                                   </select>
                                             </div> 
                                             @else
                                               <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select name="maritalstatus" id="" class="  form-control form-control" required>
                                                       
                                                        @if($marital)
                                                          <option value="{{ $marital }}">{{$marital}}</option>
                                                          <option value="Single">Single</option>
                                                          <option value="Married">Married</option>
                                                          <option value="Divorced">Divorced</option>
                                                        @else
                                                          <option value="">Marital Status</option>
                                                        @endif
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                   </select>
                                                </div>
                                           @endif
                                          </div> 
                                       
                                          <div class="form-group row">
                                             @if($result)

                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="state" id="state" class="form-control form-control" required>
                                                    <option value="{{ $result[0]->state }}">{{ $result[0]->state}}</option>
                                                      
                                                       @foreach($rec as $rec)
                                                         <option value="{{ $rec->name }}">{{ $rec->name }}</option>
                                                        @endforeach

                                                  </select>
                                                </div>
                                             @else
                                                 <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="state" id="state" class="form-control form-control" required>
                                                   @if($state)
                                                        <option value="{{ $state }}">{{$state }}</option>
                                                         @foreach($rec as $rec)
                                                         <option value="{{ $rec->name }}">{{ $rec->name }}</option>
                                                        @endforeach
                                                   @else

                                                     <option value="">State</option>
                                                       @foreach($rec as $rec)
                                                         <option value="{{ $rec->name }}">{{ $rec->name }}</option>
                                                        @endforeach
                                                  @endif
                                                  </select>

                                                </div>
                                              @endif 
                                               @if($result)  

                                                 <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" name="town" value="{{ $result[0]->town }}" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Town" required>
                                                  </div>
                                               @else
                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" name="town" value="{{ $town }}" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Town" required>
                                                  </div>
                                                @endif  


                                            </div>

                                            

                                    <div class="form-group row">
                                        
                                        @if($result)  

                                          <div class="col-sm-12 mb-3 mb-sm-0">
                                             <select name="department" id="department" class="form-control form-control" required>
                                               <option value="{{ $result[0]->department }}">{{ GetPGDepartment($result[0]->category1) }}</option>
                                           
                                               @foreach($dep as $dep)
                                                <option value="{{ $dep->departmentid }}">{{ $dep->department }}</option>
                                               @endforeach
                                             </select>
                                          </div>
                                          @else
                                           <div class="col-sm-12 mb-3 mb-sm-0">
                                             <select name="department" id="department" class="form-control form-control" required>
                                             @if($department)
                                                   <option value="{{ $department }}">{{ GetPGDepartment($category1) }}</option>
                                                   @foreach($dep as $dep)
                                                     <option value="{{ $dep->departmentid }}">{{ $dep->department }}</option>
                                                  @endforeach
                                                @else
                                                   <option value=""> Select Department</option>
                                         
                                                   @foreach($dep as $dep)
                                                   <option value="{{ $dep->departmentid }}">{{ $dep->department }}</option>
                                                   @endforeach
                                                @endif
                                             </select>
                                          </div>
                                         @endif  
                                     </div>






                                          <div class="form-group row">
                                        
                                             @if($result)  

                                               <div class="col-sm-12 mb-3 mb-sm-0">
                                                  <select name="category1" id="category1" class="form-control form-control" required>
                                                    <option value="{{ $result[0]->category1 }}">{{ GetPGProgramme($result[0]->category1) }}</option>
                                                    <option value=""> </option>
                                                    
                                                  </select>
                                               </div>
                                               @else
                                                <div class="col-sm-12 mb-3 mb-sm-0">
                                                  <select name="category1" id="category1" class="form-control form-control" required>
                                                  @if($category1)
                                                        <option value="{{ $category1 }}">{{ GetPGProgramme($category1) }}</option>
                                                        <option value=""></option>
                                                     @else
                                                        <option value=""> Programme</option>
                                              
                                                      
                                                     @endif
                                                  </select>
                                               </div>
                                              @endif  
                                          </div>
                                       
                                        
                                        <div class="form-group row">
                                         @if($result)  
                                               <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="religion" id="religion" class="form-control form-control" required>
                                                   <option value="{{ $result[0]->religion }}">{{ $result[0]->religion }}</option>
                                                   <option value="Christianity">Christianity</option>
                                                   <option value="Muslim">Muslim</option>
                                                   <option value="Traditional">Traditional</option>
                                                   <option value="Others">Others</option>
                                                   </select>
                                                </div>
                                         @else
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="religion" id="religion" class="form-control form-control" required>
                                                  @if($religion)

                                                     <option value="{{ $religion }}">{{ $religion }}</option>
                                                     <option value="Christianity">Christianity</option>
                                                     <option value="Muslim">Muslim</option>
                                                     <option value="Traditional">Traditional</option>
                                                     <option value="Others">Others</option>
                                                  @else                                                 
                                                   <option value="">Religion</option>
                                                   <option value="Christianity">Christianity</option>
                                                   <option value="Muslim">Muslim</option>
                                                   <option value="Traditional">Traditional</option>
                                                   <option value="Others">Others</option>
                                                   @endif
                                                   </select>
                                                </div>
                                         @endif     

                                           @if($result)  

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="admissiontype" id="admissiontype" class="form-control form-control" required>
                                                     <option value="{ $result[0]->admissiontype }}">{{ $result[0]->admissiontype }}</option>
                                                     <option value="PGD">Post Graduate Diploma</option>
                                                      <option value="Masters">Masters</option>
                                                      <option value="PHD">PHD</option>
                                               </select>
                                            </div>

                                           @else

                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="admissiontype" id="admissiontype" class="form-control form-control" required>
                                                 @if($admissiontype)
                                                      <option value="{{ $admissiontype }}">{{ $admissiontype }}</option>
                                                      <option value="PGD">Post Graduate Diploma</option>
                                                      <option value="Masters">Masters</option>
                                                      <option value="PHD">PHD</option>
                                                    
                                                 @else
                                                      <option value="">Admmission Type</option>
                                                      <option value="PG">Post Graduate Diploma</option>
                                                      <option value="PG">Masters</option>
                                                      <option value="PG">PHD</option>
                                                @endif
                                               </select>
                                            </div>
                                            
                                           @endif
                                           
                                           
                                           
                                           
                                         </div>
                                              <div class="form-group row">
											     <div class="col-sm-6 mb-3 mb-sm-0">                                                 
                                                    @if($data)
                                                      <select name="session" id="session" class="form-control form-control" readonly>
                                                       <option value="{{ $data[0]->activesession }}">{{ $data[0]->activesession }}</option>
                                                    @else
                                                    <select name="session" id="session" class="form-control form-control" required>
                                                       <option value="">Session</option>
                                                        @foreach($ses as $ses)
                                                            <option value="{{ $ses->name }}">{{ $ses->name }}</option>
                                                        @endforeach
                                                    @endif 

                                              </select>
                                            </div>

                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                   <label>Passport</label>
                                                    @if($result)

                                                      <input type="file" value="{{ $result[0]->photo }}" name="photo" class="form-control form-control"
                                                       id="exampleRepeatPassword" placeholder="passport" required>
                                                    @else
                                                       <input type="file" name="photo" value="{{ $photo }}" class="form-control form-control"
                                                       id="exampleRepeatPassword" placeholder="passport" required>
                                                    @endif


                                               </div>
                                             </div>
                                        <hr>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">Sponsor</h1>
                                    </div>
                                    <div class="form-group">
                                           @if($spor)

                                             <input type="text" value="{{ $spor[0]->sname }}" name="sname" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Full Name" required>
                                           @else
                                            <input type="text" name="sname" value="{{ $sname }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Full Name" required>
                                            @endif
                                        </div>
                                       <div class="form-group">
                                           @if($spor)

                                             <input type="text" value="{{ $spor[0]->saddress }}" name="saddress" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Home Address" required>
                                           @else
                                            <input type="text" name="saddress" value="{{ $saddress }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Home Address" required>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                           @if($spor)

                                             <input type="email" value="{{ $spor[0]->semail }}" name="semail" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Email Address" required>
                                           @else
                                            <input type="email" name="semail" value="{{ $semail }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Sponsor Email Address" required>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                             @if($spor)
                                                <input type="text" value="{{ $spor[0]->sphone }}" name="sphone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              @else
                                                <input type="text" name="sphone" value="{{ $sphone }}" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Sponsor Phone" required>
                                              @endif
                                        </div>

                                            <div class="text-center">
                                                <h1 class="h4  mb-4" style="color:#da251d">Parents/Guardian</h1>
                                            </div>

                                        <div class="form-group row">

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              @if($item)
                                                 <input type="text" value="{{ $item[0]->othername }}" name="pfirstname" class="form-control form-control" id="exampleFirstName"
                                                    placeholder="First Name" required>
                                              @else
                                                <input type="text" name="pfirstname" value="{{ $pfirstname }}" class="form-control form-control" id="exampleFirstName"
                                                    placeholder="First Name" required>
                                               @endif       
                                            </div>


                                            <div class="col-sm-6">
                                                @if($item)
                                                    <input type="text" value="{{ $item[0]->surname }}" name="psurname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                @else
                                                     <input type="text" name="psurname" value="{{ $psurname }}" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           @if($item)

                                             <input type="email" value="{{ $item[0]->email }}" name="pemail" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                           @else
                                            <input type="email" name="pemail" value="{{ $pemail }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                           @if($item)
                                             <input type="text" value="{{ $item[0]->address }}" name="paddress" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
                                           @else
                                            <input type="text" name="paddress" value="{{ $paddress }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
                                           @endif
                                        </div>
                                        <div class="form-group row">

                                          @if($item)
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="relation" id="" class="form-control form-control" required>
                                                    <option value="{{ $item[0]->relation }}">{{ $item[0]->relation }}</option>
                                                        @foreach($rel as $rel)
                                                            <option value="{{ $rel->name }}">{{ $rel->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                          @else
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                  @if($item)
                                                      <select name="relation" id="relation" class="form-control form-control" readonly>
                                                       <option value="{{ $item[0]->relation }}">{{ $item[0]->relation }}</option>
                                                    @else
                                                    <select name="relation" id="relation" class="form-control form-control" required>
                                                       <option value="">Relationship</option>
                                                        @foreach($rel as $rel)
                                                            <option value="{{ $rel->name }}">{{ $rel->name }}</option>
                                                        @endforeach
                                                      </select>
                                                    @endif 
                                            </div>
                                            @endif

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              @if($item)
                                                <input type="text" value="{{ $item[0]->phone }}" name="pphone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              @else
                                                <input type="text" name="pphone" value="{{ $pphone }}" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              @endif
                                            </div>

                                        </div>


                                        @if($result)
                                             <a href="{{ route('ugpreQ') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                                  Proceed To Education
                                            </a>
                                        @else
                                            <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit Info</button>

                                        @endif
                                        
                                        <hr>




                                </div>

                               

                            </div>
                        </div>
                    </div>
            </form>
        </div>

<?php
  function GetFaculty($fac)
  {
     $fa = DB::table('faculty')->where('facultyid', $fac)->first();
     return $fa->Faculty;
  }
?>
<script type='text/javascript'>
$(document).ready(function(){
  $('#faculty').change(function(){

     
     var id = $(this).val();
     //alert(id);
     // Empty the dropdown
     $('#department').find('option').not(':first').remove();


     $.ajax({
       url: 'GetDepartment/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }

         if(len > 0){
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].departmentid;
             var name = response['data'][i].department;

             var option = "<option value='"+id+"'>"+name+"</option>"

             $("#department").append(option); 
             $("#programme").append(option); 
           }
         }

       }
    });
  });

});
$(document).ready(function(){
  $('#department').change(function(){

     
     var id = $(this).val();

     // Empty the dropdown
     $('#category1').find('option').not(':first').remove();
     //alert(id);

     $.ajax({
       url: 'GetProgramme/'+id,
       type: 'get',
       dataType: 'json',
       success: function(response){

         var len = 0;
         if(response['data'] != null)
         {
           len = response['data'].length;
         }
        
         if(len > 0)
         {
           // Read data and create <option >
           for(var i=0; i<len; i++){

             var id = response['data'][i].programmeid;
             var name = response['data'][i].programme;
             var deg = response['data'][i].degree;
             // alert(name);
             var option = "<option value='"+id+"'>"+name+ ' - '+ deg + "</option>"

             $("#category1").append(option); 
           }
         }

       }
    });
  });

});
</script>


@endsection
<?php
    function GetPGProgramme($pid)
    {
         $p = DB:: SELECT('CALL GetGPProgrammeByProgrammeID(?)',array($pid));
  
        
         if($p)
         {
           return $p[0]->programme;
         }
         else
         {
           return 0;
         }
    }

    function GetPGDepartment($pid)
    {
         $p = DB::table('pgprogramme')->where('programmeid',$pid)->first();
         if($p)
         {
           return $p->programme;
         }
         else
         {
           return 0;
         }
    }


?>