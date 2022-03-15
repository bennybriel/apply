
<?php
use Carbon\Carbon;
//use DateTime;
$utme = Auth::user()->utme;
$pro = DB::SELECT('CALL GetAdmissionInfo(?)',array($utme));

?>
<!doctype html>
<html lang="en">

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
body {
/* background-image: url("logRegTemp/img/brand/bglogo.jpg");
background-repeat: no-repeat;
background-position: center; */
}
#watermark {
             position: fixed;

             /** 
                 Set a position in the page for your image
                 This should center it vertically
             **/
             bottom:   8cm;
             left:     5.5cm;

             /** Change image dimensions**/
             width:    8cm;
             height:   8cm;

             /** Your watermark should be behind every content**/
             z-index:  -1000;
         }


         .pss {
       white-space: pre;
}
</style>

<div class="row">
 <div class="col-md-8">
 </div>
 <div class="col-md-4">
    <div align="center">
        <P align="center" style="color:#b11226; font-size:20px; font-family:'ARIAL'">
            <img src="../logRegTemp/img/brand/logo_admission.png" width="90px" height="110px"/><br/> 
        <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY, OGBOMOSO<br/>   
             </b><br/>
         </P>

     
   </div>
 </div>
 <div class="col-md-4"></div>
</div>

                               
                        


<div class="headingCenter" style="color:#b11226; font-size:20px;">
    DRESS CODE FOR STUDENTS</div>
<b>1.0 PREAMBLE</b>
<p style="text-align:justify; ">
    The Ladoke Akintola University of Technology, Ogbomoso, continues to be determined to
     provide an all-round academic, intellectual and character moulding environment for its 
     students in order to produce graduates that have been proved indeed both in character and 
     academic excellence.. 
</p>

<p style="text-align:justify; ">
    The University is therefore concerned with the quality of social and cultural image portrayed 
    both inside and outside the campus.
</p>
<div id="watermark">
    <img src="../logRegTemp/img/brand/bglogo.jpg" height="100%" width="100%" />
 </div> 
<p style="text-align:justify;">
    Cleanliness, neatness, modesty, decency and appropriateness in dressing are important values which reflect 
    individual dignity and sobriety through which students, as well as staff and Faculty
    represent the professional status of their respective disciplines.
</p>
<p style="text-align:justify; ">
       The saying that ''the apparel oft proclaims the man'' is a truism for everybody - men and women,
       boys and girls, old and  young.  The  University  is,  therefore,  all  for  its  students  being  very
       fashionable  in  dressing  and  physical appearance - but in conformity to what is considered decent 
       and appropriate for every occasion.    
</p>
<b>2.0 PRINCIPLE OF DRESS CODE</b>
<p style="text-align:justify; ">
  Current trends in students' style of dressing on University campuses (LAUTECH inclusive) tend to portray some 
  form of deviance from/aberrant norms of social/cultural behaviour. Indeed, most of these trends are either a 
  passing fad, negative cultural trait or fanaticism which actually should not be allowed in an academic 
  environment such as ours.

</p>
<b>DRESS CODE</b>
<p style="text-align:justify; ">
    Students  should  maintain  cleanliness  on  campus  and  wearing  of  inappropriate outfits of 
    any  sort  are  to  be discouraged and avoided. 
</p>
  
<p style="text-align:justify; ">
    For the avoidance of doubt, male and female students are not allowed to wear the following:
    <ol>
        <li> All tight-fitting clothes including skirts, trousers and blouses.</li>
        <li> All clothes which reveal sensitive parts of the body such as the bust, chest, belly, upper arms and the buttocks. Example of such dresses are transparent clothing, ''Spaghetti tops'', ''Wicked Straps'', ''Mono Straps'', ''Tubes'', and ''Show me your belly''. Skirts and dresses with slits above the knees fall into this category.</li>
        <li> Outfits, such as, knickers and mini-skirts and dresses which are not, at least, knee-length.</li>
        <li> Outfits, such as, T-shirts, and jeans, black T-shirt, special arm-bands, special caps by males, special scarfs and tattooed jeans by females which carry obscene and subliminal messages.</li>
        <li>Trousers, such as, hip-riders and low waist-jeans. </li>
        <li> Inappropriate outfits, such as, party-wear, beach-wear and bathroom slippers should not be worn to lectures.</li>
        <li> Traditional dresses that contravene the general dress code.</li>
    </ol>
</p>
<p style="text-align:justify; ">
  
        In addition to the above:
        <ol>
            (a) Students should dress in a way that will not hide their identity.
              However, students who dress according to their religious dictates should be allowed for their 
              fundamental Human rights. Such students should subject themselves for identification in
               examination halls, laboratories and libraries when the need arises.
            (b) Students may be allowed to put on religious/denominational dress, but it should conform to the acceptable principles of dress code already discussed.
            (c) Faculties and Departments which require special safety or protective dress modes, such as, apron, overalls, gloves, nose and head-covers should have them officially prescribed for their students.
            (d) Sports and Games wears for athletes, sportsmen and sportswomen should be officially prescribed for this category of students to be worn in sports and games areas.
            (e) The wearing of earrings and the plaiting of hair by male students is banned, henceforth.
       </ol>
</p>

<b>3.0 MATRICULATION AND GRADUATION CEREMONIES</b>
<p style="text-align:justify; ">  
    During matriculation and graduation ceremonies, students are expected to dress formally, 
    and wear academic gowns.
</p>

<b>4.0 IMPLEMENTATION</b>
<p style="text-align:justify; ">  
    (i)  Lecturers  and  Administrative  staff  are  empowered  to  correct/exclude  students  from  the  lectures,  library, examination halls, etc. and official business when they are not properly dressed. <br/>
    (ii) Violators, depending on the specific circumstances, would be counselled and if necessary will face the Students' Disciplinary Committee and have their records endorsed accordingly.
</p>
<b>5.0 CAUTION</b>
<p style="text-align:justify; ">  
   Any student who is found to contravene any of these dress code prescriptions will face 
   immediate disciplinary action.
</p>
<div class="headingCenter" style="font-size:20px;">
    UNDERTAKING</div>
    
<p style="text-align:justify; "><b> I, <?php echo e(Auth::user()->name); ?>  Matric No. <?php echo e(Auth::user()->utme); ?></b></p>
<p style="text-align:justify; ">Undertake to abide by the Dress Code prescriptions for students of Ladoke Akintola University of Technology, Ogbomoso and that necessary disciplinary action should be taken against me if I contravene any of them.</p>

<b>Faculty: Management Sciences </b>
<br/>
<b>Department: <?php echo e(GetDepartment()); ?> </b>
<br/><br/>
Signature: 	
<br/><br/><br/>
Date: 	


</div>
<?php
function GetDepartment()
{
    $d = DB::table('admission_lists')->where('utme', Auth::user()->utme)->first();
    if($d)
    {
        return $d->programme;
    }
    else {
        return 0;
    }
}
function GetFaculty()
{
  $d = DB::table('admission_lists')->where('utme', Auth::user()->utme)->first();
  $sc = DB::SELECT('CALL GetCandidateFaculty(?)',array($d->departmentcode));
  if($sc)
  {
    
     return $sc[0]->faculty;
  }
  else
  {
    return 0;
  }

}

?>



     
     


































            
            


                                                   
</div>



</div>


                                  
</div>


</html>

<?php /**PATH D:\xampp\htdocs\admissions\resources\views/studentDressCode.blade.php ENDPATH**/ ?>