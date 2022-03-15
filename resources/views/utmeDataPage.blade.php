@extends('layouts.appdashboard')
@section('content')
<?php
    use Illuminate\Support\Collection;
    $psurname   = session('psurname');
    $pfirstname = session('pfirstname');
    $pemail     = session('pemail');
    $relation   = session('relation');
    $pphone     = session('pphone');
    $paddress   = session('paddress');

    $dob       = session('dob');
    $phone     = session('phone');
    $address   = session('address');
    $gender    = session('gender');
    $marital   = session('marital');
    $town      = session('town');
    $state     = session('state');

    $faculty    = session('faculty');
    $photo      = session('photo');
    $religion   = session('religion');
    $admissiontype = session('admissiontype');
    $category1   = session('category1');
    $category2   = session('category2');
    $matricno    = Auth::user()->matricno;
    //$ap = DB::SELECT('CALL GetStudentAccountInfo(?)',array($matricno));
    $othername="";
    $names     = explode(" ", $mynames[0]->name);
    $surname   = $names[0];
    $firstname = $names[1];
    
    if(empty($names[2]))
    {
        $othername = "";
    }
    else
    {
        $othername = $names[2];
    }
    //dd($othername);
    $prog = $mynames[0]->programme;
    #Special Programmme
    $sp  = DB::SELECT('CALL GetSpecialProgramme(?)',array($prog));
    $usb = DB::SELECT('CALL GetUTMESubjects(?)',array(Auth::user()->utme));
    #list of subject
    $ad = DB::SELECT('CALL 	FetchDISTINCTUTMESubjectBrochure()');
    $sub1 = $mynames[0]->subject1;
    $sub2 = $mynames[0]->subject2;
    $sub3 = $mynames[0]->subject3;
    #create a collect of subjects
    $subj = new Collection();
    $clist = new Collection();
    $subj = collect([$sub1, $sub2, $sub3]);
    $c = count($subj);
   // $slist=array();
   // dd($ad);
    $cl="";
    $cor=0;$co=0;$counter=0;
    foreach($ad as $a)
    {
        //;
        $sub = DB::SELECT('CALL GetUTMESubjectBrochure(?)',array($a->course));
        //dd($sub);
         if($a->course=="ANATOMY" || $a->course=="MEDICINE" 
                                  || $a->course=="MEDICAL LABORATORY SCIENCE"
                                  || $a->course=="NURSING SCIENCE"
                                  || $a->course=="PHYSIOLOGY"
                                  || $a->course=="BIOCHEMISTRY")
         {
            $a=0;
         }
        else
        {
          foreach($sub as $sub)
          {
            
              for($i=0; $i<$c; $i++)
              {
                 if(trim($sub->subject)==trim($subj[$i]))
                  {
                    $counter=$counter + 1;
                    $co++;
                  } 
              }

          
          }
        }
        if($counter==3)
        {
          
          $cl = $clist->push($a->course);
          $counter=0; 
        
        }
        
    }
   
?>
<script src="js/jquery-3.3.1.js"></script>
<div class="card o-hidden border-0 shadow-lg my-5">
 
            <div class="card-body p-0">
            
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('UTMEDatas') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                    <div class="col-lg-6">
  

                        <div class="p-5">
                        <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d"> Post UTME Biodata [{{ $ulist[0]->utme }}]</h1>
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
                                                @if($ulist)
                                                    <input type="text" name="surname" value="{{ $surname }}" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" readonly>
                                                @else
                                                <input type="text" name="surname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                @endif

                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($ulist)
                                                    <input type="text" name="firstname" locked="false" value="{{ $firstname }}" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name" readonly>
                                                @else
                                                    <input type="text" name="firstname" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name" required>
                                                @endif
                                            </div>

                                           
                                        </div>
                                        <div class="form-group row">
                                             <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($ulist)
                                                   @if($othername)
                                                         <input type="text" name="othername" locked="false" value="{{ $othername }}" class="form-control form-control" id="exampleFirstName"
                                                         placeholder="Other Name" readonly>
                                                    @else
                                                      <input type="text" name="othername" locked="false" class="form-control form-control" id="exampleFirstName"
                                                         placeholder="Other Name" >
                                                    @endif
                                                 
                                                   
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
                                              <label>Date of Birth</label>
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
                                         @if($ulist)
                                          <div class="col-sm-6 mb-3 mb-sm-0">
                                         
                                               <select name="gender" id="" class="form-control form-control" required readonly>
                                                    @if($ulist[0]->gender=="M")
                                                      <option value="Male">Male</option>
                                                    @else
                                                       <option value="Female">Female</option>
                                                   @endif
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
                                             @if($ulist)

                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="state" id="state" class="form-control form-control" required readonly>
                                                    <option value="{{ $ulist[0]->state }}">{{ $ulist[0]->state}}</option>
                                                   
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

                                            <div class="form-group">
                                                @if($ulist)
                                                    <input type="text" name="lga" value="{{ $ulist[0]->lga }}" class="form-control form-control" id="exampleInputEmail"
                                                        placeholder="" readonly>
                                                @else
                                                    <input type="text" name="lga" value="" class="form-control form-control" id="exampleInputEmail"
                                                        placeholder="Local Govt Area" required>
                                                @endif
                                             </div>
                                            
                                          <div class="form-group row">
                                            @if($sp)
                                             
                                                 @if($ulist[0]->totalscore >= $sp[0]->score)

                                                 <div class="col-sm-12 mb-3 mb-sm-0">
                                                       <select name="category1" id="category1" class="form-control form-control" required readonly>
                                                          <option value="{{ $ulist[0]->programme }}">{{ $ulist[0]->programme }}</option>
                                                       </select>
                                                    </div>

                                                 @else

                                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                                        <div class="alert alert-danger">
                                                            Sorry, You Do Not Have Cutoff For The Selected Programme, 
                                                            Select Another Programme.
                                                        </div>
                                                         <select name="category1" id="category1" class="form-control form-control" required>
                                                        @if($category1)
                                                                <option value="{{ $category1 }}">{{ $category1 }}</option>
                                                              @foreach ($ad as  $ad)
                                                                   <option value="{{ $ad->course }}">{{ $ad->course }}</option>
                                                              @endforeach
                                                        @else
                                                            <option value="">Select Programme</option>
                                                            @foreach ($ad as  $ad)
                                                               <option value="{{ $ad->course }}">{{$ad->course }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    
                                                  </div>

                                                 @endif
                                             
                                            @else

                                               @if($ulist)  
                                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                                       <select name="category1" id="category1" class="form-control form-control" required readonly>
                                                          <option value="{{ $ulist[0]->programme }}">{{ $ulist[0]->programme }}</option>
                                                       </select>
                                                    </div>
                                                    @else
                                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                                         <select name="category1" id="category1" class="form-control form-control" required>
                                                        @if($category1)
                                                                <option value="{{ $category1 }}">{{ $category1 }}</option>
                                                                @foreach($pro as $pro)
                                                                <option value="{{ $pro->name }}">{{ $pro->name }}</option>
                                                                @endforeach
                                                        @else
                                                            <option value="">Category 1</option>

                                                            @foreach($pro as $pro)
                                                            <option value="{{ $pro->name }}">{{ $pro->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                  </div>

                                                @endif  


                                            @endif
                                            
                                            </div>
                                        <!--
                                          <div class="form-group row">
                                            @if($result)  

                                               <div class="col-sm-12 mb-3 mb-sm-0">      
                                                  <select name="category2" id="category2" class="form-control form-control" required>
                                                    <option value="{{ $result[0]->category2 }}">{{ $result[0]->category2 }}</option>
                                              
                                                    @foreach($pros as $pros)
                                                     <option value="{{ $pros->programme }}">{{ $pros->programme }}</option>
                                                    @endforeach
                                                  </select>
                                               </div>
                                             @else
                                                 <div class="col-sm-12 mb-3 mb-sm-0">
                                                  <select name="category2" id="category2" class="form-control form-control" required>
                                                  @if($category2)
                                                        <option value="{{ $category2 }}">{{ $category2 }}</option>
                                                        @foreach($pros as $pros)
                                                          <option value="{{ $pros->programme }}">{{ $pros->programme }}</option>
                                                        @endforeach
                                                  @else
                                                    <option value="">Category 2</option>
                                              
                                                    @foreach($pros as $pros)
                                                     <option value="{{ $pros->programme }}">{{ $pros->programme }}</option>
                                                    @endforeach
                                                  @endif
                                                  </select>
                                               </div>
                                              @endif  

                                           </div>
                                            -->


                                            <div class="form-group row">
                                                 
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
                                                   <option value="Islam">Islam</option>
                                                   <option value="Traditional">Traditional</option>
                                                   <option value="Others">Others</option>
                                                   @endif
                                                   </select>
                                                </div>
                                         @endif     

                                           @if($ulist)  

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="admissiontype" id="admissiontype" class="form-control form-control" required readonly> 
                                                  <option value="{{ $ulist[0]->apptype }}">{{ $ulist[0]->apptype }}</option>
                                               
                                               </select>
                                            </div>

                                           @else

                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="admissiontype" id="admissiontype" class="form-control form-control" required>
                                                 @if($admissiontype)
                                                      <option value="{{ $admissiontype }}">{{ $admissiontype }}</option>
                                                      <option value="UTME">UTME</option>
                                                      <option value="PreDegree">Predegree</option>
                                                      <option value="Transfer">Transfer</option>
                                                      <option value="Direct Entry">Direct Entry</option>
                                                 @else
                                                  <option value="">Admmission Type</option>
                                                  <option value="UTME">UTME</option>
                                                  <option value="PreDegree">Predegree</option>
                                                  <option value="Transfer">Transfer</option>
                                                   <option value="Direct Entry">Direct Entry</option>
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
                                                         <img class="nav-user-photo" src="{{ asset('public/Passports/'.Auth::user()->photo)}}" alt="Member's Photo" width="80px" height="70px" />
                                                  
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
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Uncle">Uncle</option>
                                                    <option value="Nephew">Nephew</option>
                                                    <option value="Cousin">Cousin</option>
                                                </select>
                                            </div>
                                          @else
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="relation" id="" class="form-control form-control" required>
                                                   @if($relation)
                                                       <option value="{{ $relation }}">{{ $relation }}</option>
                                                   @else
                                                      <option value="">Relationship</option>
                                                   @endif
                                                 
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                </select>
                                            </div>
                                            @endif

                                            <div class="col-sm-6">
                                              @if($item)
                                                <input type="text" value="{{ $item[0]->phone }}" name="pphone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              @else
                                                <input type="text" name="pphone" value="{{ $pphone }}" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>
                                              @endif
                                            </div>

                                        </div>
                                        
                                        <hr/>
                                          <div class="text-center">
                                                <h1 class="h4  mb-4" style="color:#da251d">UTME Info</h1>
                                          </div>
                                            <div class="form-group row">
                                          
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                <strong><label style="color:red">Subject</label></strong>
                                                </div>
                                               

                                                <strong>
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                <strong><label style="color:red">Score</label></strong>
                                                </div>
                                            </strong>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($ulist)
                                                    <input type="text" value="English" class="form-control form-control" readonly>
                                                @endif       
                                                </div>
                                                <div class="col-sm-6">
                                                    @if($ulist)
                                                        <input type="text" value="{{ $ulist[0]->score4 }}" name="emglish" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required readonly>
                                                    @else
                                                        <input type="text" name="english" value="" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required>
                                                    @endif
                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($ulist)
                                                    <input type="text" value="{{ $ulist[0]->subject1 }}" name="subject1" class="form-control form-control" readonly>
                                                @endif       
                                                </div>
                                                <div class="col-sm-6">
                                                    @if($ulist)
                                                        <input type="text" value="{{ $ulist[0]->score1 }}" name="score1" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required readonly>
                                                    @else
                                                        <input type="text" name="score1" value="" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required>
                                                    @endif
                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($ulist)
                                                    <input type="text" value="{{ $ulist[0]->subject2 }}" class="form-control form-control" name="subject2" readonly>
                                                @endif       
                                                </div>
                                                <div class="col-sm-6">
                                                    @if($ulist)
                                                        <input type="text" value="{{ $ulist[0]->score2 }}" name="score2" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required readonly>
                                                    @else
                                                        <input type="text" name="score2" value="" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required>
                                                    @endif
                                                </div>
                                            </div>  
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($ulist)
                                                    <input type="text" value="{{ $ulist[0]->subject3 }}" class="form-control form-control" name="subject3" readonly>
                                                @endif       
                                                </div>
                                                <div class="col-sm-6">
                                                    @if($ulist)
                                                        <input type="text" value="{{ $ulist[0]->score3 }}" name="score3" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required readonly>
                                                    @else
                                                        <input type="text" name="score3" value="" class="form-control form-control" id="exampleLastName"
                                                        placeholder="SurName" required>
                                                    @endif
                                                </div>
                                            </div>  
                                            <label><strong style="color:red">Total Score: @if($ulist) {{ $ulist[0]->totalscore  }} @endif </strong></label>
                                        <hr/>
                                           

                                           



                                        <hr/>
                                        <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit Info</button>

                                      
                                
                                        
                                        
                                        <hr>




                                </div>

                               

                            </div>

                         
                                         
                        </div>

                        @if($usb)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">OLevel Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>ExamName</th>
                                                                        <th>ExamNo.</th>
                                                                        <th>ExamDate</th>
                                                                    

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>UTME</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>ExamName</th>
                                                                        <th>ExamNo.</th>
                                                                        <th>ExamDate</th>
                                                                    
                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($usb as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->utme }}</td>
                                                                            <td>{{ $data->subject }}</td>
                                                                            <td>{{ $data->grade }}</td>
                                                                            <td>{{ $data->examtype }}</td>
                                                                            <td>{{ $data->examnumber }}</td>
                                                                            <td>{{ $data->year }}</td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif
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
    // $('#programme').find('option').not(':first').remove();
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
             // alert(name);
             var option = "<option value='"+name+"'>"+name+"</option>"

             $("#programme").append(option); 
           }
         }

       }
    });
  });

});

</script>
@endsection
