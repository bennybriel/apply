
<?php
  use Carbon\Carbon;
  $mat      = Auth::user()->matricno;
  $apptype  = Auth::user()->apptype;
  //$base64="";
  //$std = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)', array($mat));
 // dd($data);
 if($data)
 {
              $cpro=null;
              $amount = $data[0]->amount;
              $des = $data[0]->description;
              $num = $data[0]->amount;
              $tra = $data[0]->transactionid;
              $dat = Carbon::parse($data[0]->created_at)->format('d-m-Y');
              if($apptype=="PG")
              {
                  // $dept = $this->GetProgramme($data[0]->category1);
                   
                     $pro = DB::table('pgprogramme')->select('id','programme','degree')
                                                ->where('programmeid', $data[0]->category1)->get()->first();
                 //dd($pro);
                   $dept = $pro->degree . ' in '.$pro->programme;
              }
              elseif($apptype=="UGD")
              { 
                     $cpro=null;
                  
                     $pro = DB::table('admission_lists')->select('id','programme')
                                                ->where('utme', Auth::user()->utme)->get()->first();
                    
                    if($pro)
                    {
                        $dept = $pro->programme; 
                    }
                    else
                    {
                           $cpro = DB::table('change_programmes')->select('id','programme')
                                                ->where('utme', Auth::user()->utme)->get()->first();
                         if($cpro)
                         {
                              $cpro = $cpro->programme; 
                              $pro = DB::table('u_g_pre_admission_regs')->select('id','category1')->where('matricno', Auth::user()->matricno)->get()->first();
                              $dept= $pro->category1; 
                         }
                         else
                         {
                              $pro = DB::table('u_g_pre_admission_regs')->select('id','category1')->where('matricno', Auth::user()->matricno)->get()->first();
                              $dept= $pro->category1; 
                         }
                        
                    }
                     
                   //  dd($dept);
              }
              else
              {
                   $dept = $data[0]->category1;
              }
             
              $qr1 = Auth::user()->name.' '.$mat.' N' .number_format($amount,2).' '.$tra. ' '.$data[0]->description;
              $qr2 = Auth::user()->utme;
             // $q = QrCode::size(150)->backgroundColor(255,255,1)->generate($qr);
            
             try
               {
                 ini_set('max_execution_time', 300);
                 $client = new \GuzzleHttp\Client();
               }
               catch(\GuzzleHttp\Exception\RequestException $e)
               {
               
                  $error['error'] = $e->getMessage();
                  $error['request'] = $e->getRequest();
                  if($e->hasResponse()){
                      if ($e->getResponse()->getStatusCode() == '400'){
                          $error['response'] = $e->getResponse(); 
                      }
                  }
                  Log::error('Error occurred in get request.', ['error' => $error]);
               }
               catch(Exception $e)
               {
                  //other errors 
               }
             
             
             
             
             
 }   
             
             
             
             
             
             
             
             
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
             <title>{{ Auth::user()->name }} Payment Receipt</title>
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
                            bottom:   13cm;
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
            <h5 align="center" style="color:#da251d"><b>{{ $des}}  Receipt {{ Auth::user()->activesession }} </b> </h5>
              @if($data)
                       <div style="overflow-x:auto; ">
                       <table width="405" align="center">
                           <thead>
                             
                              <tr>
                                <td width="211" class="noBorder1">
                                  <div align="center">
                                     
                                  </div></td>
                                <td width="182" class="noBorder1">                    </td>
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
                            @if($apptype=="UGD")
                              <tr>
                                <td class="noBorder">UTME Registration No.</td>
                                <td class="noBorder1">{{ Auth::user()->utme}}</td>
                              </tr>
                            @else
                               <tr>
                                <td class="noBorder">FormNumber</td>
                                <td class="noBorder1">{{ Auth::user()->formnumber}}</td>
                              </tr>
                            @endif
                            
                              <tr>
                                <td class="noBorder">Department </td>
                                <td class="noBorder1">{{ $dept }}</td>
                              </tr>
            
                             @if($cpro)
                                 <tr style="color:red">
                                    <td class="noBorder">New Department </td>
                                   <td class="noBorder1">{{ $cpro }}</td>
                                </tr>
                             @endif
                             <tr>
                                 <td  class="noBorder">State of Origin </td>
                                 <td class="noBorder1">{{ GetState($mat) }}</td>
                              </tr> 
                              
                             <tr>
                              <td  class="noBorder">Paid Sum of </td>
                               <td class="noBorder1">N{{ number_format(($amount),2) }}</td>
                            </tr> 
                            
                            <tr>
                              <td  class="noBorder">TransactionID </td>
                               <td class="noBorder1">{{ $tra }}</td>
                            </tr> 
                            <tr>
                              <td  class="noBorder">Amount In Words</td>
                               <td class="noBorder1">{{ numberTowords($amount) }}</td>
                            </tr> 
                           
            
                            <tr>
                              <td  class="noBorder">Date of Payment </td>
                               <td class="noBorder1">{{ $dat  }}</td>
                            </tr>              
                            
                            <tr>
                              <td  class="noBorder">Being Paid For </td>
                               <td class="noBorder1">{{ strtoupper($des)  }}</td>
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
$amt = $amount;
function AmountInWords(float $amount)
{
  $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
  // Check if there is any number after decimal
  $amt_hundred = null;
  $count_length = strlen($num);
  $x = 0;
  $string = array();
  $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
    3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
    7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
    10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
    13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
    16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
    19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
    40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
    70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
   $here_digits = array('', 'Hundred','Thousand','', '');
   while( $x < $count_length ) {
     $get_divider = ($x == 2) ? 10 : 100;
     $amount = floor($num % $get_divider);
     $num = floor($num / $get_divider);
     $x += $get_divider == 10 ? 1 : 2;
     if ($amount) {
      $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
      $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
      $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
      '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
      '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
       }
  else $string[] = null;
  }
  $implode_to_Rupees = implode('', array_reverse($string));
  $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
  " . $change_words[$amount_after_decimal % 10]) . ' koko' : '';
  return ($implode_to_Rupees ? $implode_to_Rupees . 'Naira ' : '') . $get_paise;
}

function numberTowords($num)
{

 // dd($num);
       $ones = array(
       0 =>"ZERO",
       1 => "ONE",
       2 => "TWO",
       3 => "THREE",
       4 => "FOUR",
       5 => "FIVE",
       6 => "SIX",
       7 => "SEVEN",
       8 => "EIGHT",
       9 => "NINE",
       10 => "TEN",
       11 => "ELEVEN",
       12 => "TWELVE",
       13 => "THIRTEEN",
       14 => "FOURTEEN",
       15 => "FIFTEEN",
       16 => "SIXTEEN",
       17 => "SEVENTEEN",
       18 => "EIGHTEEN",
       19 => "NINETEEN",
       "014" => "FOURTEEN"
       );
       $tens = array( 
       0 => "ZERO",
       1 => "TEN",
       2 => "TWENTY",
       3 => "THIRTY", 
       4 => "FORTY", 
       5 => "FIFTY", 
       6 => "SIXTY", 
       7 => "SEVENTY", 
       8 => "EIGHTY", 
       9 => "NINETY" 
       ); 
       $hundreds = array( 
       "HUNDRED", 
       "THOUSAND", 
       "MILLION", 
       "BILLION", 
       "TRILLION", 
       "QUARDRILLION" 
       ); /*limit t quadrillion */
       $num = number_format($num,2,".",","); 
       $num_arr = explode(".",$num); 
       $wholenum = $num_arr[0]; 
       $decnum = $num_arr[1]; 
       $whole_arr = array_reverse(explode(",",$wholenum)); 
       krsort($whole_arr,1); 
       $rettxt = ""; 
       foreach($whole_arr as $key => $i){
         
       while(substr($i,0,1)=="0")
           $i=substr($i,1,5);
       if($i < 20){ 
       /* echo "getting:".$i; */
       $rettxt .= $ones[$i]; 
       }elseif($i < 100){ 
       if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
       if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
       }else{ 
       if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
       if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
       if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
       } 
       if($key > 0){ 
       $rettxt .= " ".$hundreds[$key]." "; 
       }
       } 
       if($decnum > 0){
       $rettxt .= " and ";
       if($decnum < 20){
       $rettxt .= $ones[$decnum];
       }elseif($decnum < 100){
       $rettxt .= $tens[substr($decnum,0,1)];
       $rettxt .= " ".$ones[substr($decnum,1,1)];
       }
       }
       return $rettxt;
       }
       extract($_POST);
       if(isset($convert))
       {
           echo "<p align='center' style='color:blue'>".numberTowords("$num")."</p>";
       }
?>
