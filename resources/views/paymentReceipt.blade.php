
<?php
  
   $mat = Auth::user()->matricno;
   $mat ="756";
   $data = DB::SELECT('CALL GetPaymentHistoryByTransactionID(?)', array($tid));

   $std = DB::SELECT('CALL GetStudentPersonalDataByMatricNo(?)', array($mat));
   $amount = $data[0]->amt_recvd * 0.01;
   $qr =Auth::user()->name.'-'.$mat.'- Paid .' .number_format(($data[0]->amt_recvd*0.01),2).'With Referenece Number-'.$data[0]->TransactionReference. ' For '. $data[0]->SessionID.' Sesssion-'.$data[0]->LevelID.' level-'.GetProgramme($std[0]->programme). ' Department';
?>
<!doctype html>
   <!-- <img class="nav-user-photo" src="{{ asset('Passports/Students/'.Auth::user()-> photo)}}" style="max-width:180px;height:200px;" />   -->
   <style type="text/css">
<!--
.style2 {font-size: 14px; font-weight: bold; }
-->
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
</style>

                      

<div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4">
       <div align="center">
          <img src="logRegTemp/img/brand/logo_admission.jpg" style="max-width:70px;height:70px;"/> 
      </div>
    </div>
    <div class="col-md-4"></div>
</div>
<h4 align="center" style="color:#da251d">Payment Details </h4>
   @if($data)
            <div style="overflow-x:auto; ">
                <table width="663" border="0"  align="center" style="font-size:10">
               <thead>
                 <tr>
                   <td width="156" rowspan="9" class="noBorder" >
                     <div align="center">
                       @if(Auth::user()->photo)
                         <img src="{{ asset('Passports/Students/'.Auth::user()->photo)}}" style="max-width:130px;height:150px;" /> 
                        @else
                           <img src="logRegTemp/img/brand/default.png" style="max-width:130px;height:150px;"/> 
                          
                        @endif	                 </div>                  </td>
                    <td width="86" class="noBorder" >Student Name</td>
                    <td width="295" class="noBorder1">{{ Auth::user()->name}}</td>
                    <td width="108" rowspan="6" class="noBorder1"><img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($qr)) }} " /></td>
                 </tr>
                  <tr>
                    <td class="noBorder">Student MatricNo</td>
                    <td class="noBorder1">{{ Auth::user()->matricno}}</td>
                 </tr>
                  <tr>
                   <td height="21" class="noBorder">Amount Paid</td>
                    <td class="noBorder1">&#8358;{{ number_format(($data[0]->amt_recvd*0.01),2) }}</td>
                 </tr> 
                 <tr>
                    <td class="noBorder">Programme </td>
                    <td class="noBorder1">{{ GetProgramme($std[0]->programme) }}</td>
                 </tr>

                 <tr>
                   <td height="37" class="noBorder">Sessiom </td>
                    <td class="noBorder1">{{ $data[0]->SessionID }}</td>
                 </tr>              
                 <tr>
                   <td class="noBorder">Level</td>
                    <td class="noBorder1">{{ $data[0]->LevelID }}</td>
                 </tr>
                 </thead>
          </table>
  </div>
                                                  
                                                        <div style="overflow-x:auto;">
                                                            <table width="90%" align="center"  cellspacing="0" class="table table-bordered" style="font-size:10" table-align="center">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="4%" height="23">SN</th>
                                                                        <th width="12%">Session</th>
                                                                        <th width="12%">Level</th>
                                                                        <th width="33%">Amount</th>
                                                                        <th width="39%">Amount In Words</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                          <td>{{ ++$i }}</td>
                                                                          <td>{{ $data->SessionID }}</td>
                                                                          <td>{{ $data->LevelID }}</td>
                                                                          <td>&#8358;{{ number_format(($data->amt_recvd*0.01),2) }}</td>
                                                                          <td>
                                                                            {{ AmountInWords($amount) }}
                                                                          </td>
                                                                        </tr> 
																		                              @endforeach
                                                                        <tr>
                                                                            <td colspan="2"><span class="style2" style="color:#da251d"></span></td>
                                                                            <td><span class="style2" style="color:#da251d"></span></td>
                                                                            <td colspan="2">&nbsp;</td>
                                                                        </tr>
                                                                   
                                                                </tbody>
                                                          </table>
   </div>
                                                   <div style="overflow-x:auto;">
                                                          <table width="100%">
                                                              <tr>
                                                                <td width="66%"  class="noBorder"><p style="color:#000000">________________________ </p>
                                                                <p style="color:#000000">Bursar Sign/Date </p></td>
                                                                <td width="34%" class="noBorder">
                                                                <p style="color:#000000">________________________ </p>
                                                                <p style="color:#000000">Student Name Sign/Date </p></td>
                                                              </tr>
      </table>
                                                            <p style="color:#da251d">&nbsp;</p>
                                                            <p style="color:#000000">&nbsp;</p>
    
   </div>


                                        
         </div>
 @endif

<script type="text/javascript">
 // window.print();
</script>
</html>

<?php
 function GetProgramme($pid)
 {
      $pro = DB::table('programme')->where('programmeid', $pid)->get()->first();
      //dd($pro);
      return $pro->programme;
 }

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

   dd($num);
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
