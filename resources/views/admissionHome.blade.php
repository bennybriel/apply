@extends('layouts.appdashboard')
@section('content')
<?php
   use Carbon\Carbon;
   //cache()->store('redis')->tags('awesome-tag')->flush();
   $stag = DB::SELECT('CALL FetchRegistrationStage()');
   $matricno = Auth::user()->matricno;
   $tu = DB::SELECT('CALL GetUGTuition(?)',array($st));;
   $utme =Auth::user()->utme;
   $mat = Auth::user()->matric;
   $bio =  GetBiometricStatus($utme);
   $d = date("l");
   //$startdate = date_create('2022-01-17');
   $startdate = date_create(date('Y-m-d'));
   $startdate = date_add($startdate, date_interval_create_from_date_string("1 days"));
   $dates = "Tuesday";
   $med = GetMedicalPaymentStatus($utme);
   if(Auth::user()->apptype=="UGD" && $mat)
   {
        //$hall =3;
        //$sav = DB::INSERT('CALL SaveBiodataBatchingUpdate(?,?,?)',array($utme,$hall,$startdate));
      
       if($med == true)
       {
          
             $lrec = DB::SELECT('CALL GetLastBiodataUpdateBatching()');
             if($lrec)
             {
                    $ldate =$lrec[0]->batchdate; 
                    $ca= DB::SELECT('CALL BiodataUpdateCounter(?)',array($ldate));
                    if($ca && $ca[0]->counter == 600)
                    {
                      //$dates = "Thursday";
                      $ldate = date_create($ldate);
                      $startdate = date_add($ldate, date_interval_create_from_date_string("1 days"));
                      
                    }
                    else
                    {
                        $startdate = $startdate;
                        //$dates = "Thursday";
                    }
                    
                  
                   $hs = DB::SELECT('CALL GetRegisteredBiodata()');
                   $a =$hs[0]->mulika; $b =$hs[0]->oldict; $c= $hs[0]->zenith;
                   $hn = min($a,$b,$c);
                   if($a==$hn) $hall =1; if($b==$hn) $hall =2; if($c==$hn) $hall =3; 
                   
                   $ck = DB::SELECT('CALL CheckDuplicateBiodataBatching(?)',array($utme));
                   if(!$ck)
                   {
                        if($d =='Tuesday')
                        {
                            $dates="Thursday";
                        }
                        else
                        {
                             $dates="Tuesday";
                        }
                       /* if($d =='Thursday')
                        {
                            $dates="Tuesday";
                        }
                        else
                        {
                              $dates="Thursday";
                        }
                        */
                     $sav = DB::INSERT('CALL SaveBiodataBatchingUpdate(?,?,?,?)',array($utme,$hall,$startdate,$dates));
                   }
                   
            }
                  
       }
       
   }
   
     $chnge = Auth::user()->isChange;
     $tk = DB::table('tickets as tk')
             ->select('tk.ticketid','complain','response','subject','tk.created_at','tk.isclosed')
             ->join('replies as re','re.ticketid','=','tk.ticketid')
             ->where('tk.email', Auth::user()->email)
             ->orderby('tk.created_at','asc')
             ->get();
?>

                <!-- Begin Page Content -->
                <meta http-equiv="refresh" content="20">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>                           
                                                           <h5 style="color:red">
                                                              If you have PENDING TRANSACTION status in Payment History and you do not want to pay for the transaction again, click Cancel Transaction
                                                              so that you can make another transaction afresh.
                                                          </h5>  
                                                         <!--  <h3 style="color:red">
                                                             If you have applied for a change of programme, Please go to Payment History from the MENU, and get your Payment Receipt
                                                             for the change of programme you applied for. This is very important.
                                                        </h3>-->
                    <!-- Content Row -->
                    
                     @if(count($tk) > 0)
                                                <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Support Response </h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>TicketID</th>
                                                                        <th>Subject</th>
                                                                        <th>Complains</th>
                                                                        <th>Replies</th>
                                                                        <th>Date</th>
                                                                        <th>Status</th>
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>TicketID</th>
                                                                        <th>Subject</th>
                                                                        <th>Solution</th>
                                                                        <th>Replies</th>
                                                                        <th>Date</th>
                                                                        <th>Status</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($tk as $tk)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $tk->ticketid }} </td>
                                                                            <td>{{ $tk->subject }}  </td>  
                                                                            <td> {{ $tk->complain }} </td>
                                                                            <td> {{ $tk->response }} </td>
                                                                            <td> {{ $tk->created_at }} </td>
                                                                              <td>
                                                                                 @if($tk->isclosed =='1')
                                                                                    <span style="color:green">Resolved</span>
                                                                                 @else
                                                                                    <span style="color:#FFCC00">Pending</span>
                                                                                 @endif
                                                                           </td>
                                                                         </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                             @endif     
                    <div class="row">
                     @if(Auth::user()->isletter=='0')       
                         @if($stag)
                           <!--  Acceptance Fee -->
                   
                           @foreach($stag as $items)
                                @if($items->stageid == '1')
                                  <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card {{ $items->cardcolor }} shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   {{ $items->name }}</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                    <span style="color:red">Pending</span>
                                                @else
                                                  @if($items->stageid=='1')
                                                      <?php  UpdateIsLetterPay($matricno)  ?>
                                                       <a href="{{ route('admissionLetterUGD') }}" class="btn btn-success">
                                                           <span class="text">Download </span>
                                                        </a>
                                                  @endif
                                                    <span style="color:green">Completed</span>
                                                @endif
                                                </div>
                                            </div>
                                           
                                            <div class="col-auto">
                                              @if(RegistrationStatus($matricno,$items->stageid)==false)
                                                    <a href="{{ route('UGDPayNow',['id'=>$items->productid,'prod'=>$items->name,'sid'=>$items->stageid]) }}" class="btn btn-success">
                                                           
                                                            @if($items->ispay=='1')
                                                            <span class="text">Pay &#8358;{{ number_format($items->amount,2)}}</span>
                                                            @else
                                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                                           @endif
                                                        </a>
                                              @endif        
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach 
                            
                          @endif
                      @endif 
                      
                     @if($stag)  
                     @foreach($stag as $item)
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card {{ $item->cardcolor }} shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               {{ $item->name }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            @if(RegistrationStatus($matricno,$item->stageid)==false)
                                                <span style="color:red">Pending</span>
                                            @else
                                                                 
                                              @if($item->stageid=='1')
                                                  <?php // UpdateIsLetterPay($matricno)  ?>
                                                         <a href="{{ route('admissionLetterUGD') }}" class="btn btn-success">
                                                           <span class="text">Download </span>
                                                        </a>
                                              @elseif($item->stageid==9 && $bio==true)
                                                 <span style="color:green">{{ Auth::user()->matric }}</span>
                                                 <a href="https://student.lautech.edu.ng/freshers.php" class="btn btn-success">
                                                           <span class="text">Create Portal Account </span>
                                                  </a>
                                              @else               
                                                  <span style="color:green">Completed</span>
                                              @endif
                                                
                                            @endif
                                            </div>
                                        </div>
                                       
                                        <div class="col-auto">
                                       @if(Auth::user()->isletter=='1') 
                                          @if(RegistrationStatus($matricno,$item->stageid)==false)
                                                       
                                                        @if($item->ispay=='1' && $item->amount > 0)
                                                          
                                                                  @if($item->stageid == 4 && GetMedical($item->stageid)==true)
                                                                        <a href="{{ route('UGDPayNow',['id'=>$item->productid,'prod'=>$item->name,'sid'=>$item->stageid]) }}" class="btn btn-success">
                                                                        <span class="text">Pay &#8358;{{ number_format($item->amount,2)}}</span>
                                                                        </a>
                                                                   @elseif($item->stageid != 4 && GetMedical($item->stageid)==false)
                                                                        <a href="{{ route('UGDPayNow',['id'=>$item->productid,'prod'=>$item->name,'sid'=>$item->stageid]) }}" class="btn btn-success">
                                                                           <span class="text">Pay &#8358;{{ number_format($item->amount,2)}}</span>
                                                                        </a>
                                                                    @else
                                                                        <i class="fas fa-user fa-2x text-gray-300"></i>
                                                                    @endif
                                                           
                                                           
                                                           
                                                           
                                                        @else
                                                                 
                                                                  @if($item->stageid==7 && $med==true && $mat)
                                                                         <a href="{{ route('BiodataBatchingClearance') }}" class="btn btn-success"> <?php //{{ route('BiodataBatchingClearance') }}?>
                                                                             <span class="text">Download Clearance</span>
                                                                         </a>
                                                                  
                                                                   
                                                                   @else
                                                                      <i class="fas fa-user fa-2x text-gray-300"></i>
                                                                   @endif
                                                                   
                                                                     
                                                       @endif
                                                    
                                          @endif        
                                        @endif   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                    @endif
                    @if(BeforeNextStage(Auth::user()->utme) == true)
                     @if($tu)
                        @foreach($tu as $item)
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card {{ $item->cardcolor }} shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               {{ $item->name }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            @if(RegistrationStatus($matricno,$item->stageid)==false)
                                                <span style="color:red">Pending</span>
                                            @else
                                              @if($item->stageid=='1')
                                                  <?php  //UpdateIsLetterPay($matricno)  ?>
                                                      <a href="{{ route('admissionLetterUGD') }}" class="btn btn-success">
                                                           <span class="text">Download </span>
                                                        </a>
                                              @else
                                                <span style="color:green">Completed</span>
                                              @endif
                                                               
                                            @endif
                                            </div>
                                        </div>
                                       
                                        <div class="col-auto">
                                       @if(Auth::user()->isletter=='1') 
                                        
                                                 @if(RegistrationStatus($matricno,$item->stageid)==false)
                                                        @if($item->ispay=='1' && $item->amount > 0)
                                                           <a href="{{ route('UGDPayNow', ['id'=>$item->productid,'prod'=>$item->name,'sid'=>$item->stageid]) }}" 
                                                                                           class="btn btn-success">
                                                               <span class="text">Pay &#8358;{{ number_format($item->amount,2)}}</span>
                                                           </a>
                                                        @else
                                                          <i class="fas fa-user fa-2x text-gray-300"></i>
                                                       @endif
                                                @endif
                                         
                                      @endif   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                    @endif
                 @endif
                 
                  <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                 Download Medical Data</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                               
                                                
                                                      <a href="document/medical.pdf" class="btn btn-danger">
                                                                <span class="text">Download </span>
                                                      </a>
                                                   
                                                    
                                            
                                                </div>
                                            </div>
                                          
                                            <div class="col-auto">
                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
             </div>

           
                </div>
      <!---Support Note---->
        <div class="modal fade" id="myModalSupport" role="dialog">
             <div class="modal-dialog">
             <!-- Modal content-->
               <div class="modal-content">
             
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="card-header">
                         <!-- <h4 class="m-0" style="color:brown;text-align:center;">NOTICE!!!</h4>
                          <p style="text-align:justify">Students that have paid their tuition fees are qualified to do their Biodata and Biometric. Therefore,
                         the concerned students should go to their assigned Centres for the exercise.
                         The concerned students should know that, the thought of doing it at their own time may not be easy. Thank you. </p> -->
                    
                       <h4 class="m-0" style="color:brown;text-align:center;">Portal Support System</h4>
                         <p style="text-align:justify">
                                                   Welcome to the Support Ticket Page. The following are the steps to follow:<br/>
                                                        <b style="color:red">Note: Click on Support Menu at the left-hand-side of the portal to begin.
                                                        All requests will be proceed from this page. Any complain not from this page may be not processed</b><br/>
                                                        1. Select portal e.g apply or transcript or undergrate portal <br/>
                                                        2. Select application e.g PDS, JUP, Post graduate or Post UTME registration<br/>
                                                        3. Select category of complains e.g payment, or biodata or course registration<br/>
                                                        4. Enter the subject for the complain<br/>
                                                        5. Enter details of what happened and what you are requesting for.<br/>
                                                        6. if there is any image for clarification please upload. Note. It is optional NOT complusory<br/>
                                                        7. Click on Submit button<br/>
                                                        8. You will receive ticket confirmation in your email address. And you are to wait patiently
                                                        for the complain to be processed within 48-hours<br/>
                                                        NOTE: DO NOT OPEN MULTIPLE TICKETS ON A SINGLE ISSUE
 
                                                  </p> 
                  </div>
                 
                <div class="modal-body">
                     
                <h5>  </h5>
                </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
               </div>
              </div>
            </div>
        </div>  
        
        
         <!---Payment Note---->
        <div class="modal fade" id="myModalRegistration" role="dialog">
             <div class="modal-dialog">
             <!-- Modal content-->
               <div class="modal-content">
             
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="card-header">
                       <h4 class="m-0" style="color:brown;text-align:center;">STEPS FOR 100L 2021/2022 SESSION REGISTRATION</h4>
                         <p style="text-align:justify">
                                                     <h4 style="color:red">
                                                              Please carefully read and follow the steps below for stress-free registration progresses.
                                                              If you encounter any problem, please log it on Support page on the portal.
                                                        </h4>
                                                       <p style="text-align:justify;">   
                                                       <b>
                                                        1.	Firstly, Payment of Notification of Admission Letter will be enabled for you to make payment.<br/>
                                                        2.	After the successful payment of Notification of Admission Letter, Acceptance fee payment will be enabled for you pay.<br/>
                                                        3.	After the successful payment of Acceptance fee, you will print Notification of admission letter and Acceptance receipt 
                                                        from the PAYMENT HISTORY MENU on the portal. Then you will proceed to  Document verification center with your other essential 
                                                        documents including O’level results and others.<br/>
                                                        4.	After you have been verified and screened, the document verification status on the portal will change to ‘COMPLETED’.<br/>
                                                        5.	Then, the Tuition fee payment will be enabled for payment.<br/>  
                                                        6.	After the successful payment of Tuition fee and it displays ‘COMPLETED, Medical fee will be enabled for payment.<br/>
                                                        7.	After the successful payment of Medical fee and it displays ‘COMPLETED’ download Medical Data form, then Biodata Clearance will be enabled for 
                                                            download which contain the venue and day you will go your Biodata update.<br/>
                                                        8.	After the Biodata update, your Biodata status will change to ‘COMPLETED’  and Matriculation number will be displayed.<br/>
                                                        9.	And finally, you will see a link to CREATE PORTAL ACCOUNT, click on the link.<br/>
                                                      </b></p>
                                                        
                                                    <!--
                                                        <h5 style="color:red">
                                                              If you have PENDING TRANSACTION status in Payment History and you do not want to pay for the transaction again, click Cancel Transaction
                                                              so that you can make another transaction afresh.
                                                        </h5>
                                                        
                                                        Payment Transaction Instruction. Please follow these steps after payment:<br/>
                                                        <b style="color:red"></b><br/>
                                                        1. After payment, click on Payment History from the MENU  <br/>
                                                        2. Click on the CHECK STATUS on the transaction you want to confirm<br/>
                                                        3. Then, click on GetReceipt to download payment receipt after Approved Successful Transaction <br/>
                                                        NOTE: This applicable to all form of payment.
                                                      -->
                                                  </p>
                  </div>
                 
                <div class="modal-body">
                     
                <h5>  </h5>
                </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
               </div>
              </div>
            </div>
        </div>  
       
<script src="js/jquery-3.3.1.js"></script>
 <script>
        	$(document).ready(function(){
             //	$("#myModalPayment").modal('show');
        	});
        </script>
<script>
	$(document).ready(function(){
       $("#myModalRegistration").modal('show');
	});
</script>

@endsection

<?php 
function GetMedicalPaymentStatus($utme)
{
    
    $mat = Auth::user()->utme;
    $stag = DB::SELECT('CALL GetMedicalPaymentStatus(?)',array($utme));
    //dd($stag);
    if($stag)
    {
      if($stag[0]->status=="1")
      {
         return true;
      }
      else
      {
          return false;
      }
   }
   else
   {
      return 0;
   }
}
 function GetMedical()
 {
     $mat = Auth::user()->utme;
     $stag = DB::SELECT('CALL GetMedicalPayment(?)',array($mat));
     //dd($stag);
    if($stag)
    {
       // dd($stag[0]->status);
       if($stag[0]->status=="1")
       {
          return true;
       }
       else
       {
           return false;
       }
    }
    else
    {
       return 0;
    }
 }

 function BeforeNextStage($mat)
 {
    $st = DB::SELECT('CALL GetNextStage(?)',array($mat));
    if($st)
    {
      return true;
    }
    else
    {
        return false;
    }
 }
 function UpdateIsLetterPay($mat)
 {
    DB::UPDATE('CALL UpdateIsLetter(?)',array($mat));
 }
  function RegistrationStatus($mat,$sid)
  {
     $stag = DB::SELECT('CALL GetRegistrationStatus(?,?)',array($mat,$sid));
     if($stag)
     {
        if($stag[0]->status=="1")
        {
           return true;
        }
        else
        {
            return false;
        }
     }
     else
     {
        return 0;
     }
  }
  
  function GetBiometricStatus($utme)
  {
    $bi = DB::table('ugregistrationprogress')
             ->where('utme',$utme)
             ->where('stageid',8)
             ->where('status', 1)
             ->first();
    if($bi)
    {
        return true;
    }
    else
    {
        return false;
    }
}

?>