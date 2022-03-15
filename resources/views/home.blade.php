@extends('layouts.appdashboard')
@section('content')

   <!-- Content Row -->
<?php
  use Carbon\Carbon;
    $today = date("Y-m-d");
    $ck = DB::SELECT('CALL	FetchApplicationOpenInfo()');
    //dd($ck);
    foreach($ck as $item)
    {
        if($today > $item->closedate)
        {
            DB::UPDATE('CALL UpdateClosingStatus(?)',array($item->id));
        }
    }

  $amt=0;
  $ses = Auth::user()->activesession;
  $matricno = Auth::user()->matricno;
  $usr =   Auth::user()->usertype;
  $ispd = Auth::user()->ispaid;
  $isadm = Auth::user()->isadmitted;
  //Fetch Data
  
  $id     = 0; $ids = 0; $amount= 0;$amount1=0; $prod="";
  $dat    = DB::SELECT('CALL GetCandidateDetailsByMatricNo(?)', array($matricno));
  $data   = DB::SELECT('CALL FetchFailedPayments(?)', array($matricno));
  $result = DB::SELECT('CALL FetchPreAdmissionInfo(?)', array($matricno));
  $p_1 =1;$p_2 =6; $p_3=8;$p_4=14; $p_5=12;$p_6=9; $p_7 = 10; $p_8=92; $p_9=12;
  $p3=0;$p4=0;$p5=0;$p6=0;$p7=0;$p8=0;$p9=0;
  $p1    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_1));
  $p2    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_2));
  $p3    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_3));
  $p4    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_4));
  $p5    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_5));
  $p6    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_6));
  $p7    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_7));
  $p8    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_8));
  $p9    = DB::SELECT('CALL FetchApplicationListingByID(?)',array($p_9)); #Transfer
  //dd($p9);
  $apptype = Auth::user()->apptype;
  $ole = DB:: SELECT('CALL GetUTMESubjects(?)',array(Auth::user()->utme));
 // dd($p7);
  //Call Products
  $rol = DB::SELECT('CALL GetCurrentUserRole(?)', array($matricno));
   // dd($rol);
  //$datas    = DB::SELECT('CALL FetchApplicationListing()');
  
   $rec ="";$res="";
  if($usr=='Admin')
  {
      #Total Applied Transcript
        try
        {
            $client = new \GuzzleHttp\Client();
            $url    = "https://transcript1.lautech.edu.ng/api/v1/GetTotalCompleteApp";   
            $response =$client->request('GET', $url);
            if ($response->getStatusCode() == 200) {
                // $response = json_decode($guzzleResponse->getBody(),true);
                $res = json_decode($response->getBody());
            
            } 
        }
        catch(\GuzzleHttp\Exception\RequestException $e){
            $error['error'] = $e->getMessage();
            $error['request'] = $e->getRequest();
            if($e->hasResponse()){
                if ($e->getResponse()->getStatusCode() == '400'){
                    $error['response'] = $e->getResponse(); 
                }
            }
            Log::error('Error occurred in get request.', ['error' => $error]);
        }
        catch(Exception $e){
            //other errors 
        }

 
      #Total Paid Transcript
        try
        {
            $client = new \GuzzleHttp\Client();
            $url    = "https://transcript1.lautech.edu.ng/api/v1/GetPaidTranscripts";   
            $response =$client->request('GET', $url);
            if ($response->getStatusCode() == 200) {
                // $response = json_decode($guzzleResponse->getBody(),true);
                $rec = json_decode($response->getBody());
                //dd($rec);
            
            } 
        }
        catch(\GuzzleHttp\Exception\RequestException $e){
            $error['error'] = $e->getMessage();
            $error['request'] = $e->getRequest();
            if($e->hasResponse()){
                if ($e->getResponse()->getStatusCode() == '400'){
                    $error['response'] = $e->getResponse(); 
                }
            }
            Log::error('Error occurred in get request.', ['error' => $error]);
        }
        catch(Exception $e){
            //other errors 
        }
  }
    $dep  = DB::table('pgdepartment')->orderby('department','asc')->get();  //DB::SELECT('CALL FetchPGDepartments()');
    $dats = DB::table('changeprogrammerequirement')->get();
    
     $chnge = Auth::user()->isChange;
     $tk = DB::table('tickets as tk')
             ->select('tk.ticketid','complain','response','subject','tk.created_at','tk.isclosed')
             ->join('replies as re','re.ticketid','=','tk.ticketid')
             ->where('tk.email', Auth::user()->email)
             ->orderby('tk.created_at','asc')
             ->get();
?>

   <!-- Content Row -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admission Dashboard</h1>
    
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Hello <i
            class="fas fa-info fa-sm text-white-50"></i> {{ Auth::user()->name }} <?php echo date("l, dS-M-Y") ?></a>
</div>

<!-- Content Row -->
                                                     @if(Session::has('errors'))
                                                       <div class="alert alert-danger">
                                                      
                                                        {{ Session::get('errors') }}  
                                                            <a href="{{ route('reg') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                                                   Click To Continue
                                                            </a>
                                                        @php
                                                            Session::forget('errors');
                                                        @endphp
                                                      
                                                        </div>
                                                   @endif
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
                                                        <?php
                                                           // $memberID = session('memberID');
                                                        ?>
                               @endif
                                                      <!--
                                                          <h5 style="color:red">
                                                              If you have PENDING TRANSACTION status in Payment History and you do not want to pay for the transaction again, click Cancel Transaction
                                                              so that you can make another transaction afresh.
                                                          </h5> 
                                                          
                                                           <h3 style="color:red">
                                                             If you have applied for a change of programme, Please go to Payment History from the MENU, and get your Payment Receipt
                                                             for the change of programme you applied for. This is very important.
                                                        </h3>-->
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
                                                                        <th>Complains</th>
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
                                                    
                                                          
                                        
   @if($usr=="Candidate")                           
        @if($ispd==false && Auth::user()->formumber=='')       
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><strong>@if($p1) {{ $p1[0]->name }} @endif</strong>                                            </div>
                                    <div class="row no-gutters align-items-center">
                                     <div class="col">     
                                            @if($p1 && $p1[0]->status == true)
                                            
                                                <div class="col-auto">
                                                        <h7>&#8358;{{ number_format($p1[0]->amount,2) }} </h7>
                                                    <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                        <a href="{{ route('PayNow',['id'=>$p_1,'prod'=>$p1[0]->name]) }}" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Pay Now</span>
                                                    </a>
                                                    <label><a href="" style="color:green ;font-size:12px;"  data-toggle="modal" data-target="#myModal" data-community="" >Read More</a></label>
                                                </div>                                
                                           
                                            @else
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Admission Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            @endif
                                        </div> 
                                    
                                    </div>
                                </div>
                               <!-- <a href="#" class="btn btn-sm btn-warning">Closes in  <i
                    class="fas fa-info fa-sm text-white-50"></i><p id="demo"></p></a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><strong>@if($p2) {{ $p2[0]->name }} @endif</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                         @if($p2  && $p2[0]->status == true)
                                          <div class="col-auto">
                                            <h7>&#8358;{{ number_format($p2[0]->amount,2) }} </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="{{ route('PayNow',['id'=>$p_2,'prod'=>$p2[0]->name])  }}"
                                                                            class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Pay Now</span>
                                            </a>
                                            <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                            </div>
                                            @else
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Admission Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            @endif

                                        </div>
                                    
                                    </div>
                                </div>
                                <!--
                                <div class="col-auto">
                                <a href="#" class="btn btn-sm btn-warning">Closes in  <i
                    class="fas fa-info fa-sm text-white-50"></i><p id="demo1"></p></a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="color:red"><strong>@if($p3) {{ $p3[0]->name }} @endif</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                    <div class="col">
                                         @if($p3  && $p3[0]->status == true)
                                          <div class="col-auto">
                                            <h7>&#8358;{{ number_format($p3[0]->amount,2) }} </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="{{ route('PayNow',['id'=>$p_3,'prod'=>$p3[0]->name])  }}"
                                                                            class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Pay Now</span>
                                            </a>
                                            <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                            </div>
                                            @else
                                                <div class="col-auto">
                                                
                                                <h7 style="color:red"> Admission Closed </h7>
                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                    <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                    <span class="text">Closed</span>
                                                </a>
                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                </div>  
                                            @endif

                                        </div>
                                    
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="color:red"><strong>DE Application</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                        @if($p4 && $p4[0]->status == true)    
                                            <div class="col-auto">
                                    
                                            <h7>&#8358;{{ number_format($p4[0]->amount,2) }} </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                            <button type="button" class="btn" data-toggle="modal" data-target="#deModal"  style="background:#c0a062;color:white">Pay Now </button>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @else
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="{{ route('ugbiodata') }}" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text"> Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @endif
                                        </div>
                                    
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" style="color:red">
                                    <strong>POST GRADUATE Application</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                            
                                    @if($p6 && $p6[0]->status == true)    
                                           <div class="col-auto">
                                    
                                            <h7> </h7>
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#pgModal">Pay Now </button>
                                         
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @else
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                   
                                                <a href="{{ route('ugbiodata') }}" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @endif
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1" style="color:red">
                                    <strong>POST UTME Application</strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                            
                                    @if($p7 && $p7[0]->status == true)    
                                            <div class="col-auto">
                                    
                                            <h7> </h7>
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal"  style="background:#c0a062;color:white">Pay Now </button>
                                         
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @else
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                   
                                                <a href="{{ route('ugbiodata') }}" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @endif
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="color:red"><strong>
                                        2021/2022 Post UTME for PDS/JUPEB
                                         </strong></div>
                                    <div class="row no-gutters align-items-center">
                                        
                                        
                                    <div class="col">
                                            
                                        @if($p1 && $p1[0]->status == true)    
                                            <div class="col-auto">
                                    
                                            <h7> </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                            <button type="button" class="btn" data-toggle="modal" data-target="#pdsjupebModal"  style="background:#c0a062;color:white">Confirm UTME No </button>
                                         
                                            </div>  
                                    @else
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="{{ route('ugbiodata') }}" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text"> Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                    @endif
                                        </div>
                                    
                                    
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <!-- TRANSFER APPLICATION-->
               <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="color:red"><strong>@if($p9) {{ $p9[0]->name }} @endif</strong></div>
                                <div class="row no-gutters align-items-center">
                                    
                                <div class="col">
                                     @if($p9  && $p9[0]->status == true)
                                      <div class="col-auto">
                                        <h7>&#8358;{{ number_format($p9[0]->amount,2) }} </h7>
                                        <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                            <a href="{{ route('PayNow',['id'=>$p_9,'prod'=>$p9[0]->name])  }}"
                                                                        class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                                    <i class="fas fa-arrow-right"></i>
                                            </span>
                                            <span class="text">Pay Now</span>
                                        </a>
                                        <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                        </div>
                                        @else
                                            <div class="col-auto">
                                            
                                            <h7 style="color:red"> Admission Closed </h7>
                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                <a href="" class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                        <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">Closed</span>
                                            </a>
                                            <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                            </div>  
                                        @endif

                                    </div>
                                
                                
                                </div>
                            </div>
                            <div class="col-auto">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
                                             
        
        
        @if($usr=="Candidate" && (Auth::user()->apptype=="UGD" || Auth::user()->apptype=="PD"))   
           <!----Change of Programme 
           
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">2021/2022 CHANGE OF PROGRAMME </h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Course</th>
                                                                        <th>Cutoff</th>
                                                                        <th>O'level Requirment</th>
                                                                        <th>UTME Requirment</th>
                                                                   
                                                                       

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                    <th>SN</th>
                                                                        <th>Course</th>
                                                                        <th>Cutoff</th>
                                                                        <th>O'level Requirment</th>
                                                                        <th>UTME Requirment</th>

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($dats as $dats)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $dats->name }} </td>
                                                                            <td>{{ $dats->cutoff }}  </td>  
                                                                            <td> {{ $dats->requirement }} </td>
                                                                            <td> {{ $dats->utmerequirement }} </td>
                                                                         </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                           
                                                        </div>
                                                    </div>
                                                </div> --->
                                               <!----Change of Programme  --->
                                                 @if($chnge==1)
                                                     <!---  <a href="{{ route('changeProgramme')  }}"  class="btn btn-info btn-icon-split">
                                                         <span class="icon text-white-50">
                                                           <i class="fas fa-arrow-right"></i>
                                                          </span>
                                                      
                                                       <span class="text">Change Programme</span>
                                                     </a>
                                                     --->
                                                @else
                                                   <div class="col-xl-3 col-md-6 mb-4">
                                                       <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><strong>@if($p8) {{ $p8[0]->name }} @endif</strong></div>
                                                                    <div class="row no-gutters align-items-center">
                                                                        <div class="col">
                                                                         @if($p8  && $p8[0]->status == true)
                                                                          <div class="col-auto">
                                                                            <h7>&#8358;{{ number_format($p8[0]->amount,2) }} </h7>
                                                                            <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                                                <a href="{{ route('PayNow',['id'=>$p_8,'prod'=>$p8[0]->name])  }}"
                                                                                                            class="btn btn-primary btn-icon-split">
                                                                                <span class="icon text-white-50">
                                                                                        <i class="fas fa-arrow-right"></i>
                                                                                </span>
                                                                                <span class="text">Pay Now</span>
                                                                            </a>
                                                                            <label><a href="" style="color:blue;font-size:12px;">Read More</a></label>                      
                                                                            </div>
                                                                            @else
                                                                                <div class="col-auto">
                                                                                
                                                                                <h7 style="color:red"> Admission Closed </h7>
                                                                                <!--  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div> -->
                                                                                    <a href="" class="btn btn-danger btn-icon-split">
                                                                                    <span class="icon text-white-50">
                                                                                            <i class="fas fa-arrow-right"></i>
                                                                                    </span>
                                                                                    <span class="text">Closed</span>
                                                                                </a>
                                                                                <label><a href="" style="color:#36b9cc;font-size:12px;">Read More</a></label>
                                                                                </div>  
                                                                            @endif
                                
                                                                        </div>
                                                                    
                                                                    </div>
                                                                </div>
                                                                <!--
                                                                <div class="col-auto">
                                                                <a href="#" class="btn btn-sm btn-warning">Closes in  <i
                                                    class="fas fa-info fa-sm text-white-50"></i><p id="demo1"></p></a>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                @endif
         @endif        
                
        @if(Auth::user()->ispaid == true && Auth::user()->iscomplete==true)
             @if($apptype=="UGD")
                  <div class="alert-danger">
                      <p><strong>Note:</strong>
                      If you do not have complete O'level results from JAMB portal, you will not be able to check your Post UTME Result. Click on MENU and click on Check Post UTME Result.
                      </p>
                 </div>
                 
                
                @endif
                      @if($dat && $apptype=='PG')
                     <?php
                        //$matricno ="011120215380594916614";
                        $re = DB::table('pgreference')->distinct('remail')->where('matricno',$matricno)->count();
                      //dd($re);
                      ?>
                      <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Referee Status</div>
                                            <div class="h5 mb-0 font-weight-bold text-danger-800">{{ $re }} out of 3 </div>
                                             @if($re==3)
                                                <span style="color:green">Completed</span>
                                             @else
                                                 <span style="color:red">Pending</span>
                                             @endif
                                        </div>
                                        <div class="col-auto">
                                                 <a href="" data-toggle="modal"  data-target-id="{{ $matricno }}"  data-target="#myModalview"  class="btn btn-primary" > View</a>
                                               
                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
               @endif
                @if($dat)
                        <div style="overflow-x:auto; ">
                                <table width="698" border="0" align="center">
                            <thead>
                                <tr>
                                
                                    <td width="132" class="noBorder" >Student Name</td>
                                    <td width="369" class="noBorder1">{{ Auth::user()->name}}</td>
                                </tr>
                                <tr>
                                    <td class="noBorder">Form Number</td>
                                    @if($apptype=="UGD" || $apptype=="DE" || $apptype=="TRF")
                                      <td class="noBorder1">{{ Auth::user()->utme}}</td>
                                    @else
                                      <td class="noBorder1">{{ Auth::user()->formnumber}}</td>
                                    @endif
                                </tr>
                                <tr>
                                @if($apptype=="PG")
                                <tr>
                                   <td class="noBorder">Programme </td>
                                  
                                    <td class="noBorder1">{{ GetPGProgramme($dat[0]->category1) }}</td>
                                </tr>
                                @else
                                <td class="noBorder">Programme </td>
                                    <td class="noBorder1">{{ $dat[0]->category1 }}</td>
                                </tr>
                                <tr>
                                  @if($apptype=="UGD" && Auth::user()->isChange=='1')
                                       <?php
                                          $ch = DB::table('change_programmes')->where('utme',Auth::user()->utme)->first();
                                        ?>
                                         <tr style="color:red">
                                            <td class="noBorder"><b>New Programme</b> </td>
                                            <td class="noBorder1">@if($ch) <b>{{ $ch->programme }}</b> @endif</td>
                                        </tr>
                                     @endif
                                @endif
                                <tr>
                                <td class="noBorder">Session </td>
                                    <td class="noBorder1">{{ $dat[0]->session }}</td>
                                </tr>

                                <tr>
                                <td class="noBorder">Email</td>
                                    <td class="noBorder1">{{ $dat[0]->email }}</td>
                                </tr>
                                <tr>
                                <td class="noBorder">Phone</td>
                                    <td class="noBorder1">{{ $dat[0]->phone }}</td>
                                </tr>
                                <tr>
                                <td class="noBorder">Date of Birth</td>
                                    <td class="noBorder1"> {{ Carbon::parse($dat[0]->dob)->format('d-m-Y') }}</td>
                                </tr> 
                                <tr>
                                <td class="noBorder">State of Orgin</td>
                                    <td class="noBorder1">{{ $dat[0]->state }}</td>
                                </tr>
                                </thead>
                        </table>
                    </div>
                    
                         @if($ole)
                                               <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold" style="color:#da251d">Examination Grade Details</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Grade</th>
                                                                        <th>Exam No.</th>
                                                                      

                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                         <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Exam No.</th>
                                                                        <th>Grade</th>
                                                                      

                                                                    </tr>
                                                                </tfoot>
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($ole as $ole)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $ole->subject }}</td>
                                                                            <td>{{ $ole->grade }}</td>
                                                                            <td>{{ $ole->examnumber }}</td>

                                                                       
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                               @if($apptype=="UGD")
                                                   <div class="alert-danger">
                                                        No O'level Result Found
                                                   </div>
                                                @endif
                                             @endif
                @endif
        @elseif(Auth::user()->ispaid == true && Auth::user()->iscomplete==false)
          
          <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1" style="color:red">Click To Start Registration Or Continue With Registration                                           </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10%</div>
                               
                            </div>
                            <div class="col">
                            @if($apptype =="UGD" || $apptype =="DE" || $apptype =="TRF")
                                    <a href="{{ route('validateUTME') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                        Validate UTME     
                                    </a>
                                @elseif($apptype =="PDS" || $apptype =="JUP" || $apptype =="PT")
                                    <a href="{{ route('ugbiodata') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                    Registration
                                </a>
                                @elseif($apptype =="PG")
                                    <a href="{{ route('pgdataPage') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                       Registration
                                    </a>
                                @elseif($apptype =="PD")
                                    <a href="{{ route('pdsjupebDataPage') }}" class="btn btn-primary" style="background:#c0a062;border-color:#da251d;color=000000">
                                        Registration
                                        </a>
                                @endif
                                <br/>
                                <!--
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 10%" aria-valuenow="10" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        
                    </div>
                </div>
            </div>
          </div>
          </div>
         @endif
    @endif
    
   
</div> 

@if(Auth::user()->isadmitted == true )
     @if(Auth::user()->isacceptance==true)
         <div class="alert alert-success">
             <p>Congratulations!!!</p>
            <p>Your Acceptance Fee Payment Was Successful. Please Check Payment History</p>
        </div>
    @endif
     @if(Auth::user()->ismedical==true)
         <div class="alert alert-success">
             <p>Congratulations!!!</p>
            <p>Your Medical Fee Payment Was Successful. Please Check Payment History</p>
        </div>
     @endif
     @if(Auth::user()->istuition==true)
         <div class="alert alert-success">
             <p>Congratulations!!!</p>
            <p>Your Tuition Fee Payment Was Successful. Please Check Payment History</p>
        </div>
     @endif
      @if(Auth::user()->isict==true)
         <div class="alert alert-success">
             <p>Congratulations!!!</p>
            <p>Your ICT Fee Payment Was Successful. Please Check Payment History</p>
        </div>
     @endif
        @if(Auth::user()->istuition==false && $apptype =="JUP")
           <a href="{{ route('paymentHome') }}" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Proceed To Payment Page</span>
                                                    </a>
       @endif
        @if(Auth::user()->isict==false && $apptype =="PDS")
           <a href="{{ route('paymentHome') }}" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </span>
                                                        <span class="text">Proceed To Payment Page</span>
                                                    </a>
       @endif
    @endif

   <div class="col-lg-12">
      <div class="p-3">
      @if($ispd==0)
         @if($data)
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                <div class="alert alert-danger">
                        Payment Transaction Failed
                 </div>
                     <h6 class="m-0 font-weight-bold" style="color:#da251d">Failed Payment Record</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Session</th>
                                    <th>Amount</th>                        
                                    <th>PaymentType</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 </tr>
                            </thead>
                             
                                                                <tbody>
                                                                <?php
                                                                    $i=0;
                                                                    ?>
                                                                    @foreach($data as $data)
                                                                        <tr>
                                                                            <td>{{ ++$i }}</td>
                                                                            <td>{{ $data->session }}</td>
                                                                            <td>&#8358;{{ number_format($data->amount,2) }}</td>
                                                                          
                                                                            <td>{{ $data->description  }}</td>
                                                                            <td>{{ Carbon::parse($data->created_at)->format('d-m-Y,h:m:s A') }}</td>
                                                                            <td> 
                                                                              
                                                                              @if($data->response)
                                                                              
                                                                                <span style="color:red">{{ $data->response }}</span>
                                                                              @else
                                                                              <span style="color:red">Pending</span>
                                                                              @endif
                                                                            </td> 
                                                                            <td> 
                                                                              <a href="{{ route('QueryTransaction', $data->transactionID) }}" style="background:#c0a062;color:white" class="btn">Check Payment Status</a>
                                                                             </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            
                                                            
                                                             <h6 style="color:#da251d">Please Click Pay Now, Below To Try Again  </h6>
                                                        </div>
                                                    </div>
                                                </div>


         @endif
      @endif
</div>
</div>
@if($usr=="Staff" && $rol && $rol[0]->section=="Admission")
    <?php
        $tutme =DB::SELECT('CALL FetchTotalUTME()');
        $tde =DB::SELECT('CALL FetchTotalDE()');
        $reg = DB::SELECT('CALL GetRegisteredApplicants()');
        $apl = DB::SELECT('CALL GetPaidApplicants()');
    ?>
   <div class="container-fluid">
    <div class="row">
    
    <!-- Earnings (Monthly) Card Example -->
            @if($tutme)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Uploaded UTME</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($tutme[0]->utme,0)}}
                                
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($reg )
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Registered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($reg[0]->ugd,0)}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($tde)
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total DE Uploaded</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($tde[0]->de,0)}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($reg)
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total DE Registered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($reg[0]->de,0)}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
  
     </div> 
  </div> 
@endif
 <?php
        $tutme =DB::SELECT('CALL FetchTotalUTME()');
        $tde =DB::SELECT('CALL FetchTotalDE()');
        $reg = DB::SELECT('CALL GetRegisteredApplicants()');
        $apl = DB::SELECT('CALL GetPaidApplicants()');
    ?>
@if($usr=="Staff" && $rol && $rol[0]->section=="PartTime")
   
   <div class="container-fluid">
    <div class="row">
    
    <!-- Earnings (Monthly) Card Example -->
            @if($apl)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                               PartTime Total Paid Applicant</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                 {{ number_format($apl[0]->pt,0)}}
                                
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($reg )
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                   PartTime Total Registered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($reg[0]->pt,0)}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
           
          
  
     </div> 
  </div> 
@endif



   @if($usr=="Admin") 
   <?php
      $tutme =DB::SELECT('CALL FetchTotalUTME()');
      $tde =DB::SELECT('CALL FetchTotalDE()');
      $reg = DB::SELECT('CALL GetRegisteredApplicants()');
      $apl = DB::SELECT('CALL GetPaidApplicants()');
   ?>
   <div class="container-fluid">
   <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        @if($tutme)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Uploaded UTME</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($tutme[0]->utme,0)}}
                            
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($reg )
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($reg[0]->ugd,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($tde)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total DE Uploaded</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($tde[0]->de,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($reg)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total DE Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($reg[0]->de,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


<!-- Earnings (Monthly) Card Example -->
        @if($apl)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PDS Total Paid Applicant</div>
                            <div class="h5 mb-0 font-weight-bold text-info">
                            {{ number_format($apl[0]->pds,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($apl)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                PDS Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-info">
                            {{ number_format($reg[0]->pds,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Pending Requests Card Example -->
        @if($apl)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            JUPEB Total Paid Applicant</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($apl[0]->jup,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($reg)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            JUPEB Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($reg[0]->jup,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
          <!-- Pending Requests Card Example -->
        @if($apl)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            PG Total Paid Applicant</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($apl[0]->pg,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($reg)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            PG Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($reg[0]->pg,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
               <!-- Post Transcript -->
        @if($rec)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Paid Transcripts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($rec->data[0]->counter,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($res)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                             Registered Transcript</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($res->data[0]->counter,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

       @if($apl)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Part-Time Total Paid</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($apl[0]->pt,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($reg)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                              Part-Time Total Reg.</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($reg[0]->pt,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif





    </div>

            <!--  <img src="logRegTemp/img/brand/admin.jpg" style="max-width:100%;height:auto;"/>  -->
 @endif
<!----------POST GRADUATE------------------------->
@if($usr=="Staff" && $rol && $rol[0]->section=="PostGraduate")
   
   <div class="container-fluid">
    <div class="row">
    
    <!-- Earnings (Monthly) Card Example -->
    @if($apl)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            PG Total Paid Applicant</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($apl[0]->pg,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($reg)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            PG Total Registered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($reg[0]->pg,0)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
           
          
  
     </div> 
  </div> 
@endif








</div> 


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Please Validate Your UTME No.</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="{{ route('CheckUTME') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id"  value="{{  $p_7 }}" class="form-control">
                    <input type="hidden" name="prod" value="{{ $p7[0]->name }}" class="form-control">
                    <input type="text" name="utme" class="form-control" placeholder="Enter UTME">
                    <br/>
                    <input type="submit" class="btn btn-primary" id="payNow" value="Validate">    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>    
<!--DE/UTME--->
<div class="modal fade" id="deModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Please Validate Your UTME No.</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="{{ route('CheckDE') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id"  value="{{  $p_4 }}" class="form-control">
                    <input type="hidden" name="prod" value="{{ $p4[0]->name }}" class="form-control">
                    <input type="text" name="utme" class="form-control" placeholder="Enter UTME">
                    <br/>
                    <input type="submit" class="btn btn-primary" id="payNow" value="Validate">    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 
<!--PDS/JUPEB ADMISSION--->
<div class="modal fade" id="pdsjupebModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5>Please Validate Your Formnumber and UTME No.</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="{{ route('ValidatePDSJUPEB') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  
                    <select name="apptype"  class="form-control" required>
                        <option value="">Select Programme</option>
                        <option value="PDS">PDS</option>
                        <option value="JUPEB">JUPEB</option>
                        <option value="TRF">TRANSFER</option>
                    </select> 
                    <br/>
                    <input type="text" name="formnumber" class="form-control" value="0" placeholder="Enter Formnumber" required>
                    <br/>
                    <input type="text" name="utme" class="form-control" placeholder="Enter UTME" required>
                    <br/>
                   
                    <input type="submit" class="btn btn-primary" id="payNow" value="Validate">    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade" id="pgModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Please Your Programme</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span></span></h4>
            </div>   
            <div class="modal-body">
                <form method="post" action="{{ route('PGApplication') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id"  value="{{  $p_6 }}" class="form-control">
                    <input type="hidden" name="prod" value="{{ $p6[0]->name }}" class="form-control">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <select name="department" id="department" class="form-control form-control" required>
                            <option value=""> Select Department</option>
                               @foreach($dep as $dep)
                                   <option value="{{ $dep->departmentid }}">{{ $dep->department }}</option>
                               @endforeach
                                             
                         </select>
                     </div>
                     <br/>
                     <div class="col-sm-12 mb-3 mb-sm-0">
                           <select name="category1" id="category1" class="form-control form-control" required>
                             <option value=""> Programme</option>
                           </select>
                      </div>
                      <br/>
                    <input type="submit" class="btn btn-primary" id="payNow" value="Pay Now">    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
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
                                                        <b style="color:red">NOTE: DO NOT OPEN MULTIPLE TICKETS ON A SINGLE ISSUE</b>
 
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
        <div class="modal fade" id="myModalPayment" role="dialog">
             <div class="modal-dialog">
             <!-- Modal content-->
               <div class="modal-content">
             
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                 </div>
                 <div class="card-header">
                       <h4 class="m-0" style="color:brown;text-align:center;">CHANGE OF PROGRAMME NOTICE</h4>
                         <p style="text-align:justify">
                                                      <!--  <h3 style="color:red">
                                                             If you have applied for a change of programme, Please go to Payment History from the MENU, and get your Payment Receipt
                                                             for the change of programme you applied for. This is very important.
                                                        </h3>
                                                    
                                                         <h5 style="color:red">
                                                              If you have PENDING TRANSACTION status in Payment History and you do not want to pay for the transaction again, click Cancel Transaction
                                                              so that you can make another transaction afresh.
                                                        </h5>
                                                        
                                                        Payment Transaction Instruction. Please follow these steps after payment:<br/>
                                                        <b style="color:red"></b><br/>
                                                        1. After payment, click on Payment History from the MENU  <br/>
                                                        2. Click on the CHECK STATUS on the transaction you want to confirm<br/>
                                                        3. Then, click on GetReceipt to download payment receipt after Approved Successful Transaction <br/>
                                                        NOTE: This applicable to all form of payment.  -->
 
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
        
        <!-- View Referee Record -->
<div class="modal fade" id="myModalview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-target=".bd-example-modal-lg">
   <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="edit-modal-label">Referee Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
              
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

          
        
            <table id="myTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                                    <th>SN</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Rank</th>
                                    <th>Email</th>  
                                    <th>Date</th>                       
                                    <th>Status</th>
                                 
                                   
                    </tr>
                </thead>
                <tbody>

                </tbody>
             </table>


        </div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>

<script src="js/jquery-3.3.1.js"></script>
        <script>
             $(document).ready(function(){
            $("#myModalview").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
             $.get( "GetRefereeRecord/" + id, function( data )
             {
                // console.log(id);
                   $('#myTable > tbody > tr').remove();
                    var rows = "";
                    //console.log(data['data'][0].name);
                    if(data['data'] != null)
                    {
                      len = data['data'].length;
                    }
                     var k=0;
                    for (i = 0; i<len; i++) 
                    {
                        k++;
                     
                       // console.log(data['data'][i].name);
                         $('#myTable > tbody:last-child').append(
                                          '<tr><td>' + k + '</td><td>'  
                                           + data['data'][i].rtitle + '</td><td>' 
                                           + data['data'][i].rname + '</td><td>' 
                                           + data['data'][i].rank + '</td><td>' 
                                           + data['data'][i].remail + '</td><td>' 
                                           + data['data'][i].created_at + '</td><td>' 
                                           + 'Completed' + '</td><td>' + '</td></tr>');
                         
                    }
            });

        });
    });
        
        	$(document).ready(function(){
             	$("#myModalSupport").modal('show');
        	});
        </script>
 <script>
// Set the date we're counting down to
var countDownDate = new Date("Nov 30, 2021 23:59:59").getTime();
var countDownDate1 = new Date("Oct 31, 2021 23:59:59").getTime();
// Update the count down every 1 second
var x = setInterval(function() 
{

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;
  var distance1 = countDownDate1 - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  // Time calculations for days, hours, minutes and seconds
  var days1 = Math.floor(distance1 / (1000 * 60 * 60 * 24));
  var hours1 = Math.floor((distance1 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes1 = Math.floor((distance1 % (1000 * 60 * 60)) / (1000 * 60));
  var seconds1 = Math.floor((distance1 % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "days " + hours + "hours "
  + minutes + "mins " + seconds + "secs ";

  // Display the result in the element with id="demo"
  document.getElementById("demo1").innerHTML = days1 + "days " + hours1 + "hours "
  + minutes1 + "mins " + seconds1 + "secs ";

  // If the count down is finished, write some text
  if (distance < 0)
   {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }

  if (distance1 < 0)
   {
    clearInterval(x);
    document.getElementById("demo1").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<script src="js/jquery-3.3.1.js"></script>
<script>
	$(document).ready(function(){
     //	$("#myModalSupport").modal('show');
	});
</script>
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

  function GetPGProgramme($pro)
  {
       $p = DB:: SELECT('CALL GetPGProgramme(?)',array($pro));

      
       if($p)
       {
         return $p[0]->programme;
       }
       else
       {
         return 0;
       }
  }
  ?>
