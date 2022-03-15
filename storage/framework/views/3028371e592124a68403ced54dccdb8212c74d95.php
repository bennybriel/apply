
<?php $__env->startSection('content'); ?>
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

?>
<style>
  * {
  box-sizing: border-box;
}

/* Create three columns of equal width */
.columns {
  float: left;
  width: 24.9%;
  padding: 8px;
}

/* Style the list */
.price {
  list-style-type: none;
  border: 1px solid #eee;
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

/* Add shadows on hover */
.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

/* Pricing header */
.price .header {
  background-color: #c0a062;
  color: white;
  font-size: 18px;
}

/* List items */
.price li {
  border-bottom: 1px solid #eee;
  padding: 20px;
  text-align: center;
}

/* Grey list item */
.price .grey {
  background-color: #eee;
  font-size: 20px;
}

/* The "Sign Up" button */
.button {
  background-color: #04AA6D;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}

/* Change the width of the three columns to 100%
(to stack horizontally on small screens) */
@media  only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>
<?php
   
   //dd($data);

 
    $dt ="";
    $res ="";
   
    try
    {
      $client = new \GuzzleHttp\Client();
      $url    = config('paymentUrl.product_id_url_all');     
      //dd($url);
      $response =$client->request('GET', $url, ['verify'=>false,'headers' => [ 'token' => 'funda123']]);
      //dd($response->getStatusCode() );
      // or can use
      // $guzzleResponse = $client->request('GET', '/foobar')
        if ($response->getStatusCode() == 200) {
            // $response = json_decode($guzzleResponse->getBody(),true);
             $res = json_decode($response->getBody());
             //perform your action with $response 
        } 
    }
    catch(\GuzzleHttp\Exception\RequestException $e){
       // you can catch here 400 response errors and 500 response errors
       // You can either use logs here use Illuminate\Support\Facades\Log;
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
  
   //dd($res);
    if($res)
    {
       foreach($res as $res)
       {
           // dd($res->amount);
           //Check Duplications
            $rem="readme".$res->id.'.pdf';
            $ck = DB::SELECT('CALL CheckDuplicatedApplicationList(?)', array($res->id));
            if($ck)
             {
                 $up = DB::UPDATE('CALL UpdateApplicationList(?,?,?,?,?)', 
                 array($res->session,$res->amount,$res->name,$rem,$res->id));
             }
            else
              {
               // dd($res);
                $setrec = DB::INSERT('CALL SaveApplicationList(?,?,?,?,?)', 
                array($res->id,$rem,$res->amount,$res->name,$res->session));
              }
       }
    }
    $data    = DB::SELECT('CALL FetchApplicationListing()');
    $result  = DB::SELECT('CALL FetchAdmissionInfo()');
?>

<div class="container">
    <br/> 
<div class="row">
     <div class="col-4">
     </div>
     <div class="col-6">
        <img src="logRegTemp/img/brand/logo_predegree1.png" style="max-width:100%;height:auto;"/>
     </div>
  </div>
 <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    
                    <div class="col-lg-12">
                       <div class="p-5">
                          <h4><strong style="color:#c0a062"><?php if($result): ?> <?php echo e($result[0]->heading); ?>

                            <?php else: ?>
                              Admissions
                             <?php endif; ?></strong></h4>
                            <p style="text-align:justify; "><strong>
                                <?php if($result): ?>
                                  <?php echo e($result[0]->content); ?>

                              </p>
                               <p> <?php echo e($result[0]->title); ?> </p>
                               <p> Have you signed up before?, Please <a href="<?php echo e(route('logon')); ?>">Login Now</a> </p> 
                              <?php else: ?>
                              Admissions
                             <?php endif; ?>
                            <p><a href="20212022BROCHURE.pdf">Click here 2021/2022 UTME BROCHURE</a></p>

                           
                           <?php if($data): ?>
                           <div>
                           <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="columns">
                                    <ul class="price">
                                        <li class="header"><?php echo e($data->name); ?></li>
                                        <li class="grey">&#8358;<?php echo e(number_format($data->amount,2)); ?> </li>
                                        <li style="color:red">Closes on <?php echo e(Carbon::parse($data->closedate)->format('d-m-Y')); ?></li>
                                        
                                       <!-- <li style="color:#ffcc00"><p id="demo"></p></li> -->
                                        <li><a href="<?php echo e($data->readmore); ?>" target="_blank">Read more</a></li>
                                        <?php if($data->status == false): ?>
                                           <li class="grey"><a href="" class="btn btn-danger">Closed</a></li>
                                
                                        <?php else: ?>
                                        <li class="grey"><a href="<?php echo e(route('logon')); ?>" class="btn btn-success">Appy Now</a></li>
                                        <?php endif; ?>
                                      </ul>
                                </div>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                           </div>
                             
                               
                           <?php endif; ?>

                            

                            
           
                             <br/><br/>
                          
                        </div>
                           
                         
                            
                      </div> 
                   
                      <div class="p-5">
                         <div class="row">
                         <div class="col-xl-3 col-md-12 mb-4"></div>
                              <h4><strong style="color:#c0a062">Create Account</strong></h4> <br/>  <br/>
                                <p style="text-align:justify; "><strong>
                                You can create account here so you that you will receive updates on our admissions. <a href="<?php echo e(route('reg')); ?>">Click here </a>
                                </strong>   </p>
                            </div>
                       </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
             <div class="modal-dialog">
             <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
                <div class="modal-body">
                      <h4 class="modal-title">2021/2022 ADMISSION PROGRAMME</h4>
                </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" style="background:#da251d;color:white" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>  
      
 <?php
   $dt="";
   function GetAppDate($id)
   {
      $dt = @$GLOBALS['dt'];
       //$dt =0;
       $dat = DB::SELECT('CALL GetAppOpeningDateByID(?)', array($id));
        foreach($dat as $dat)
        {
          $GLOBALS['dt'] =  $dat->closedate;
        }
       
        return $GLOBALS['dt'];
   }
 ?>

<script>
// Set the date we're counting down to
var countDownDate = new Date("Nov 30, 2021 23:59:59").getTime();
var countDownDate1 = new Date("Nov 30, 2021 23:59:59").getTime();
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appfront', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WebApps\ApplyApp\resources\views/index.blade.php ENDPATH**/ ?>