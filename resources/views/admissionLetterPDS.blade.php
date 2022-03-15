
<?php
   use Carbon\Carbon;
   //use DateTime;
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
    table {
    border-collapse: collapse;
    }

    td, th {
    border: 1px solid #999;
    padding: 0.5rem;
    text-align: left;
    }

    {
  box-sizing: border-box;
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 10px;
  height: 30px; /* Should be removed. Only for demonstration */
}

.left {
  width: 25%;
}

.right {
  width: 75%;
}
.lefts {
  width: 50%;
}

.rights {
  width: 50%;
}


/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.noBorder {
    border:none !important;
    font-weight: bold;
}
.noBorder1 {
    border:none !important;
}
.headingRight
{
  float: right;

  padding-right:20px;
}
.headingCenter
{
  text-align: center;
  /* border: 3px solid #73AD21; */
  font-weight: bolder;
  padding: 10px;
}


</style>

<div class="row">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
       <div align="center">
          <img src="../logRegTemp/img/brand/logo_admission.png" style="max-width:100%;height:auto;"/>
          <h3 align="center" style="color:#da251d">  
            LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO</h3>
            <h4 align="center" style="color:#000">  
                     PRE-DEGREE SCIENCE PROGRAMME
            </h4>
          </div>
    </div>
    <div class="col-md-4"></div>
</div>


  

                 <div class="headingRight">
                      
                                  <p style="text-align:justify; ">Board of Pre-Degree Science Programme,<br/>
                                     P. M. B. 4000,<br/>
                                  	Ogbomoso, Oyo State.<br/>
                                    11th October, 2021 <br/>
                                
                                  </p>
                                  
                       
                     
                </div>
<div class="w3-container">

<br/>
<br/>
Dear {{ strtoupper(Auth::user()->surname) }} {{ strtoupper(Auth::user()->firstname) }} ({{ strtoupper(Auth::user()->formnumber) }}),
<br/>

<div class="headingCenter"> OFFER OF PROVISIONAL ADMISSION </div>

<p style="text-align:justify; ">With reference to your application for admission to the Joint Universities Preliminary Examinations Board (JUPEB),
 I am pleased to inform you that you have been offered a provisional admission to the 2021/2022 Pre-Degree Science (PDS) Programme. </p>

<strong>Please note that: </strong>

<p style="text-align:justify; ">1. (a)  	This offer of provisional admission is valid for three weeks.</p>

<p style="text-align:justify; ">(b) If at any time starting from the registration, it is discovered that any of
    the credentials you claimed to possess is false, forged or incorrect, this offer of admission
     will become invalid and you would forfeit all fees paid in respect of same.</p>

<p style="text-align:justify; ">(c) 	The names by which you are admitted and by which you will be registered will be
   the names which will appear on the Statement of Result that may be issued to you on the
    successful completion of the Programme except a change of name for female students on marital grounds</p>

<p style="text-align:justify; ">(d) 		The Pre-Degree Science Programme is not an undergraduate Programme. Therefore, 
                                            this admission letter does not make you an undergraduate of Ladoke Akintola University of Technology, 
                                            Ogbomoso and you have not been placed into any undergraduate programme yet.</p>

<p style="text-align:justify; ">(e)	You are to note specifically that:</p>

<p style="text-align:justify; ">•	This offer of admission is valid for only one contact session.</p>
<p style="text-align:justify; ">•	Fees paid are non-refundable.</p>
<p style="text-align:justify; ">•	The minimum entry qualification for the Programme is credit at O’ level in 
                                    English Language, Mathematics and any three relevant subjects from the following; 
                                    Physics, Chemistry, Biology, Agricultural Science, Accounting, Economics and Geography.</p>

  <p style="text-align:justify; ">(g) You are to obey all the rules and regulations as specified in the PDS Hand-book, on matters such as acts of examination 
                                      malpractice, violence, looting, vandalism, secret cults or any form of brigandage e.t.c. You are to show at all times respect
                                      to the Office and person of the Vice Chancellor and other University Officers. 
                                      Failure to comply with this provision shall lead to your automatic expulsion from the Programme..

  <p style="text-align:justify; ">2.	The Programme fees, which should be paid online are as stated below:</p>

  <p style="text-align:justify; ">(i)	 Acceptance fee       						 N20,000:00     </p>
  <p style="text-align:justify; ">(ii)   Medical fee	         	                 N5,500:00</p>
  <p style="text-align:justify; ">(iii)	 Tuition, Payable by Indigene candidates (Oyo State) N100,000:00</p>
  <p style="text-align:justify; ">(iv)	 Tuition, Payable by Non-Indigene candidates         N115,000:00</p>
  <p style="text-align:justify; ">(v)	 ICT free                                            N11,500:00</p>
  <p style="text-align:justify; ">However, payment of acceptance fee online commences immediately for all successful applicants.</p>

  <p style="text-align:justify; "><strong>Procedure for Payment of Tuition Fee:</strong></p>

  <p style="text-align:justify; ">(a)You should proceed to LAUTECH website: www.lautech.edu.ng to make payment of tuition fee online using Interswitch enabled Debit Cards.</p>

  <p style="text-align:justify; ">
     You should proceed to LAUTECH application portal page: apply.lautech.edu.ng and log in as PDS applicant to make payment of all online fees using Interswitch enabled Debit Cards.
  </p>
  

  <p style="text-align:justify; ">(b)Medical fee of N5,500:00 to be paid online using Interswitch enabled Debit  Cards.</p>

  <p style="text-align:justify; ">(c) Examination fee as may be determined by JUPEB is to be paid at the point of Registration for Examination at the PDS Complex.</p>

<p style="text-align:justify; ">3. When reporting for final registration after the completion of all payments, bring along
   with you the following documents: </p>

   

   <p style="text-align:justify; "><strong>Admission Letter, Receipts of Payment of : Acceptance fee, Tuition fee, Medical fee; two (2) recent
 Passport Size Photographs, completed State Identification Form downloaded from internet duly signed by 
 the Chairman or Secretary of your Local Government Area, a copy of your Screening Result downloaded from
  internet, Letters of Attestation, one each from the Principal of your former Secondary School and your
   religious cleric.</strong></p>

<p style="text-align:justify; ">4. Your placement to available and related degree programme of the University after successful completion
   of this programme will depend on:</p>
	
      <p style="text-align:justify; ">
      (i)   Your performance in the final examination of the PDS. </p> 
      <p style="text-align:justify; ">  (ii)  Selecting LAUTECH as first Choice of university when obtaining 2022 JAMB/UTME
       form.</p>
      <p style="text-align:justify; ">
      (iii) Obtaining the University minimum score in the UTME as may be determined by
       JAMB.</p>
      <p style="text-align:justify; ">(iv) Successful completion of mandatory ICT training programme. </p>


      <p style="text-align:justify; ">5. 	Lectures commence on Monday, January 10, 2022. No registration will be allowed after Friday, February 25, 2022.</p>

      <p style="text-align:justify; ">6. 	LAUTECH is a non-residential University; therefore, you are expected to make adequate arrangements for your accommodation.</p>

      <p style="text-align:justify; ">7. 	Congratulations.</p>


<p>Yours faithfully,
</p>

     <img src="../logRegTemp/img/brand/registrarsign.jpg" style="max-width:100%;height:auto;"/>
<br/>

<p style="text-align:justify; "><strong>K. A. Ogunleye, Ph.D</strong></p>
<p style="text-align:justify; "><em>Registrar.</em></p>




		
		


































               
               


                                                      
</div>



</div>


                                     
</div>


</html>

