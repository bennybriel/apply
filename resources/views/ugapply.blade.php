
@extends('layouts.appadmission')
@section('content')
<style>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
                             <div class="form-group row">
                                       <strong><a href="https://admissions.lautech.edu.ng/2020-2021_ADMISSION_BROCHURE.pdf"> Click here for 2020/2021 ADMISSION BROCHURE</a></strong>
                                      <p style="text-align:justify"> Notice is hereby given to all candidates who chose LAUTECH as their Institution of first choice or those willing
                                       to change to LAUTECH as their Institution of first choice in the 2020/2021 Joint Admissions and Matriculation Board
                                       Unified Tertiary Matriculation Examination (UTME) that a Post-UTME Computer Based Test (CBT) screening exercise and
                                       oral interview for Direct Entry candidates for admission to the University’s various programmes will be conducted on
                                       a date to be announced soon. </p>

                                       <p style=" text-align:justify">
                                       However, application form will be available online for completion and submission from Friday, August 21 to Sunday,
                                       November 29, 2020. Applicants are to note that before admission can be offered by the University, they must have
                                       uploaded their O’Level results on CAPS and once admission is offered, the candidates must either accept or reject the o
                                       ffer on CAPS before JAMB’s closure of CAPS for the year in order to be on JAMB National Matriculation list for the year.
                                       <strong>For UTME candidates to be eligible for the exercise, they must have scored 170 marks and above in the 2020/2021 UTME.</strong>
                                       </p>
                             
                                           
    
                                            <strong>METHOD OF APPLICATION</strong>
                                             <p style=" text-align:justify">Applicants are to proceed to the admission website of the University www.admissions.lautech.edu.ng to make payment of a fee of
                                            Two Thousand Naira (N2,000.00) only for the purpose of online registration for the screening exercise using Inter-Switch Enabled
                                            Debit Card (ATM) as well as familiarize themselves with the available programmes in the University and the requirements for
                                            O’Level, A’Level and UTME subjects for each of the programmes so indicated. </p>

                                             <p style=" text-align:justify">Applicants are expected to carefully complete and submit the online application forms having uploaded a digital copy of their
                                            passport photographs in white background which must be in JPEG and must not be more than 20kb.</p>

                                             <p style=" text-align:justify">Any applicant with blurred picture on the acknowledgement page will not be admitted into the screening center as the photograph
                                            will be used as a means of identification. The COLOUR PRINT OUT acknowledgement page should be presented by all candidates at the
                                            screening venue before admittance to participate in the exercise. Candidates should note that satisfaction of this requirement is
                                            mandatory. For ease of communication, applicants are to provide valid and active e-mail addresses and phone numbers. </p>

                                             <p style=" text-align:justify">Applicants who are awaiting results of NABTEB, NECO, WASC are also eligible to apply. However, the results when released must be
                                            uploaded on the PUTME portal of the University as well as on JAMB CAPS two (2) weeks after release of such results. Results uploaded
                                            after the prescribed timeline may not be accepted. Also, inconsistency in names on O’Level and UTME results shall not be acceptable
                                            to the University and may lead to disqualification. Candidates’ names on their O’Level results and other registration documents must
                                            be the same.</p>

                                             <p style=" text-align:justify">Any applicant who fails to present himself/herself for the CBT as scheduled automatically forfeits being considered for admission.
                                            The use of cell phones and any unauthorized device is not allowed during the screening exercise.</p>

                                            <strong>DIRECT ENTRY CANDIDATES</strong>
                                           <p style=" text-align:justify"> Direct Entry Candidates including those on LAUTECH JUPEB programme or other Institutions’ JUPEB programmes, who wish to be considered
                                            for admission for the 2020/2021 academic session in the university must have obtained Direct Entry form from JAMB to be eligible
                                            for the oral screening interview which date shall be announced soon. However, candidates are expected to forward their academic
                                            transcript to the Registrar, Ladoke Akintola University of Technology, Ogbomoso not later than Friday, October 16, 2020. </p>

                                            <p style=" text-align:justify">Candidates are to visit the admission portal of the University www.admissions.lautech.edu.ng to complete and submit their applications
                                            while ensuring strict compliance with admission requirements of the University before applying for any of its programmes.</p>


                                            <strong>ELIGIBILITY</p>
                                            <p style=" text-align:justify">LAUTECH will admit only candidates who passed at credit level in at least five (5) relevant subjects at not more than two (2)
                                            sittings in SSCE/NECO/NABTEB for UTME while the University accepts a minimum of Upper Credit and JUPEB/ A’ Level for Direct Entry
                                            candidates with five (5) credit passes in SSCE/NECO/NABTEB in the relevant subjects.</p>

                                            <p style=" text-align:justify">Candidates should carefully study the University Brochure as provided on the University website to
                                            guide them in completion of their application forms.</p>


                                            <strong style="color:red">WARNING</strong>
                                            <div class="alert alert-danger">
                                                Candidate who provides false information to secure admission to any programme of the University and upon discovery of such at any point in time will be prosecuted by law enforcement agencies and the admission of such candidate shall be withdrawn. Candidates are also advised to BEWARE OF FRAUDSTERS as the University will not be liable for any transaction with any unauthorized person.
                                             </div>
                                            <strong>All enquiries should be sent to registrar@lautech.edu.ng or admissions@lautech.edu.ng.</strong>


                                                            
                                          
                             </div>
  </div>

</div>


<div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <form class=""  id="" enctype="multipart/form-data" method="POST" action="{{ route('MyAdmissions') }}">
                                        {{ csrf_field() }}

                    <div class="row">
                             <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4  mb-4" style="color:#da251d">General Informattion</h1>
                                            <hr>
                                    </div>
                                      
                                        <div class="form-group row">
                                       <strong><a href="https://admissions.lautech.edu.ng/2020-2021_ADMISSION_BROCHURE.pdf"> Click here for 2020/2021 ADMISSION BROCHURE</a></strong>
                                      <p style="text-align:justify"> Notice is hereby given to all candidates who chose LAUTECH as their Institution of first choice or those willing
                                       to change to LAUTECH as their Institution of first choice in the 2020/2021 Joint Admissions and Matriculation Board
                                       Unified Tertiary Matriculation Examination (UTME) that a Post-UTME Computer Based Test (CBT) screening exercise and
                                       oral interview for Direct Entry candidates for admission to the University’s various programmes will be conducted on
                                       a date to be announced soon. </p>

                                       <p style=" text-align:justify">
                                       However, application form will be available online for completion and submission from Friday, August 21 to Sunday,
                                       November 29, 2020. Applicants are to note that before admission can be offered by the University, they must have
                                       uploaded their O’Level results on CAPS and once admission is offered, the candidates must either accept or reject the o
                                       ffer on CAPS before JAMB’s closure of CAPS for the year in order to be on JAMB National Matriculation list for the year.
                                       <strong>For UTME candidates to be eligible for the exercise, they must have scored 170 marks and above in the 2020/2021 UTME.</strong>
                                       </p>
                             
                                           
    
                                            <strong>METHOD OF APPLICATION</strong>
                                             <p style=" text-align:justify">Applicants are to proceed to the admission website of the University www.admissions.lautech.edu.ng to make payment of a fee of
                                            Two Thousand Naira (N2,000.00) only for the purpose of online registration for the screening exercise using Inter-Switch Enabled
                                            Debit Card (ATM) as well as familiarize themselves with the available programmes in the University and the requirements for
                                            O’Level, A’Level and UTME subjects for each of the programmes so indicated. </p>
                                            <a href="">Read More</a>
                                       </div>
                                       

                                        <hr>
                                </div>
                            </div>

                            <div class="col-lg-6">


                                <div class="p-5">
                                <div class="text-center">
                                        <h1 class="h4 mb-4" style="color:#da251d">Candidate Biodata</h1>
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
                                                    placeholder="SurName">
                                                @else
                                                <input type="text" name="surname" class="form-control form-control" id="exampleLastName"
                                                    placeholder="SurName" required>
                                                @endif

                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($data)
                                                    <input type="text" name="firstname" locked="false" value="{{ $data[0]->firstname }}" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="First Name">
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
                                                        placeholder="Other Name">
                                                @else
                                                    <input type="text" name="othername" class="form-control form-control" id="exampleFirstName"
                                                        placeholder="Other Name">
                                                @endif
                                            </div>
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                @if($data)
                                                    <input type="text" value="{{ $data[0]->utme }}" name="utme" class="form-control form-control"
                                                    id="exampleInputPassword" placeholder="UTME Reg/MatricNo">
                                                @else
                                                    <input type="text" name="utme" class="form-control form-control"
                                                    id="exampleInputPassword" placeholder="UTME Registration Number" required>
                                                @endif

                                            </div>

                                         </div>
                                            

                                        <div class="form-group">
                                            @if($data)
                                                <input type="email" name="email" value="{{ $data[0]->email }}" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address">
                                            @else
                                                <input type="email" name="email" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Email Address" required>
                                            @endif
                                        </div>



                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date" name="dob" class="form-control form-control"
                                                        id="exampleRepeatPassword" placeholder="Date of DOB" required>

                                            </div>
                                          
                                            <div class="col-sm-6 mb-3 mb-sm-0">

                                                <input type="text" name="phone" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Phone" required>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <input type="text" name="address" class="form-control form-control" id="exampleInputEmail"
                                                placeholder="Home Address" required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <select name="gender" id="" class="form-control form-control" required>
                                                    <option value="">Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select name="maritalstatus" id="" class="form-control form-control" required>
                                                    <option value="">Marital Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Divorced">Divorced</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                          <div class="form-group row">


                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="state" id="state" class="form-control form-control" required>
                                                    <option value="">State</option>
                                                       @foreach($rec as $rec)
                                                         <option value="{{ $rec->name }}">{{ $rec->name }}</option>
                                                        @endforeach
                                                  </select>
                                                </div>
                                               <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" name="town" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Town" required>
                                                </div>

                                            </div>

                                            
                                          <div class="form-group row">
                                              <div class="col-sm-6 mb-3 mb-sm-0">
                                                  <select name="faculty" id="faculty" class="form-control form-control" required>
                                                    <option value="">Faculty</option>
                                                  
                                                    @foreach($fac as $fac)
                                                         <option value="{{ $fac->facultyid }}">{{ $fac->faculty }}</option>
                                                    @endforeach
                                                  </select>
                                               </div>
                                             <div class="col-sm-6">
                                                  <select name="department" id="department" class="form-control form-control" required>
                                                    <option value="">Department</option>
                                                  
                                                  </select>
                                              </div>

                                        </div>

                                        <div class="form-group row">                                                                                                                        
                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="programme" id="programme" class="form-control form-control" required>
                                                    <option value="">Programme</option>
                                                       
                                                       
                                                       
                                              </select>
                                            </div>

                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                              <select name="session" id="session" class="form-control form-control" required>
                                                    <option value="">Session</option>
                                                        @foreach($ses as $ses)
                                                            <option value="{{ $ses->id }}">{{ $ses->name }}</option>
                                                       @endforeach
                                              </select>
                                            </div>
                                         </div>
                                            
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="password" class="form-control form-control"
                                                        id="exampleRepeatPassword" placeholder="Password" required>

                                            </div>
                                          
                                            <div class="col-sm-6 mb-3 mb-sm-0">

                                                <input type="text" name="confirmpassword" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="Confirm Password" required>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                          <select name="religion" id="religion" class="form-control form-control" required>
                                             <option value="">Religion</option>
                                             <option value="Christianity">Christianity</option>
                                             <option value="Muslim">Muslim</option>
                                             <option value="Traditional">Traditional</option>
                                             <option value="Others">Others</option>
                                             </select>
                                          </div>
                                            
                                           <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label>Passport</label>
                                                <input type="file" name="photo" class="form-control form-control"
                                                    id="exampleRepeatPassword" placeholder="passport" required>
                                            </div>
                                         </div>


                                          <button class="btn px-4" type="submit" style="background:#c0a062;color:white"> Submit Info</button>

                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
<script src="js/jquery-3.3.1.js"></script>
<script>

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

$( document ).ready(function() {
    modal.style.display = "block";
});
// When the user clicks the button, open the modal 
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }

}
</script>

@endsection
