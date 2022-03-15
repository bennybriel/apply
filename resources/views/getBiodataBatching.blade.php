
<?php
  use Carbon\Carbon;
  $mat      = Auth::user()->matricno;
  $apptype  = Auth::user()->apptype;
  $client = new \GuzzleHttp\Client();
 // dd($data);
  //$base64="";
  //$std = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)', array($mat));
 // dd($data);
 
  $dat = Carbon::parse($data[0]->created_at)->format('d-m-Y');

 // $qr1 = Auth::user()->name.' '.$mat.' N' .number_format($amount,2).' '.$tra. ' '.$data[0]->description;
  $qr2 = Auth::user()->utme;
 // $q = QrCode::size(150)->backgroundColor(255,255,1)->generate($qr);

 
 
?>
<!doctype html>
  <!-- <img class="nav-user-photo" src="{{ asset('Passports/Students/'.Auth::user()-> photo)}}" style="max-width:180px;height:200px;" />   -->
  <style type="text/css">

.style2 {font-size: 14px; font-weight: bold; }

  </style>
  

           
<html lang="en">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>{{ Auth::user()->name }} Biodata Batching Clearance</title>
</head>

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
 height: 20px; /* Should be removed. Only for demonstration */
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

#watermark {
                position: fixed;

                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                bottom:   15cm;
                left:     5.5cm;

                /** Change image dimensions**/
                width:    8cm;
                height:   8cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
</style>

                     

<div class="row">
   <div class="col-md-8"></div>
   <div class="col-md-4">
      <div align="center">
            <P align="center" style="color:#b11226; font-size:15px; font-family:'ARIAL'">
               <img src="../logRegTemp/img/brand/logo_admission.png" width="90px" height="110px"/><br/> 
           <b>LADOKE AKINTOLA UNIVERSITY OF TECHNOLOGY<br/>  
                 P.M.B 4000, OGBOMOSO, OYO STATE, NIGERIA<br/>   
               
            </P>
     </div>
   </div>
   <div class="col-md-4"></div>
</div>
<h5 align="center" style="color:#da251d"><b>Biodata Batching Clearance </b> </h5>
  @if($data)
           <div style="overflow-x:auto; ">
           <table width="405" align="center">
               <thead>
                 
                  <tr>
                    <td width="211" class="noBorder1">
                      <div align="center">
                         
                      </div></td>
                    <td width="182" class="noBorder1">                
                </td>
                 </tr>
             </table>
             <div id="watermark">
               <img src="../logRegTemp/img/brand/bglogo.jpg" height="100%" width="100%" />
            </div>
               <table width="663" border="0"  align="center" style="font-size:10">
              <thead>
                <tr>
                  <td width="91" rowspan="9" class="noBorder" >                  </td>
                   <td width="172" class="noBorder" >Full Name</td>
                   <td width="371" class="noBorder1">{{ Auth::user()->name}}</td>
                   <td width="11" rowspan="6" class="noBorder1"></td>
                </tr>
              
                  <tr>
                    <td class="noBorder">UTME Registration No.</td>
                    <td class="noBorder1">{{ Auth::user()->utme}}</td>
                  </tr>
              
                  <tr>
                    <td class="noBorder">Hall</td>
                    <td class="noBorder1">{{ $data[0]->name }}</td>
                  </tr>
                
               
                 <tr>
                     <td  class="noBorder">Department </td>
                     <td class="noBorder1">{{  $data[0]->programme  }}</td>
                  </tr> 
                 <tr>
                  <td  class="noBorder">Date </td>
                   <td class="noBorder1">{{ $dat  }}</td>
                </tr>              
                
              
                </thead>
         </table>
 </div>
                                                 
       
     
        <table width="831" align="center">
               <thead>
                 
                  <tr>
                    <td width="373" class="noBorder1">
                       <?php 
                           if(Auth::user()->apptype=='UGD')
                            {
                               $url    = 'http://api.qrserver.com/v1/create-qr-code/?data="'.$qr2.'&size=100x100'; //config('paymentUrl.product_id_url_all');     
                            }
                            else
                            {
                              $url    = 'http://api.qrserver.com/v1/create-qr-code/?data="'.$qr1.'&size=100x100'; //config('paymentUrl.product_id_url_all');     
                            } 
                              $response =$client->request('GET', $url,['stream' => true]);
                              $data = $response->getBody()->getContents();
                              $base64 = 'data:image/png;base64,' . base64_encode($data);
                                                  
                             echo '<img src="'.$base64.'">';  
                        ?>       				
                     
                     
                     
                     
                     
            				</td>
                    <td width="446" class="noBorder1">
                   


                 
                 </tr>
             </table>                                           


                                       
        </div>
@endif

<script type="text/javascript">
// window.print();
</script>
</html>

<?php
function GetState($mat)
{
     $sta = DB::table('u_g_pre_admission_regs')->where('matricno',$mat)->get()->first();
     if($sta)
     {
        return $sta->state;
     }
     else
     {
        return 0;
     }
     //dd($pro);
    
}
function GetProgramme($pid)
{
     $pro = DB::table('programme')->where('programmeid', $pid)->get()->first();
     //dd($pro);
     return $pro->programme;
}
function GetPGProgramme($pid)
{
     $pro = DB::table('pgprogramme')->select('id','programme','degree')
                                    ->where('programmeid', $pid)->get()->first();
     //dd($pro);
     $p = $pro->degree . ' in '.$pro->programme;
     return $p;
}


?>
