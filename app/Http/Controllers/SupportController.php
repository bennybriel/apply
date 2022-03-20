<?php

namespace App\Http\Controllers;
use App\Portals;
use App\Category;
use App\Applications;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SupportController extends Controller
{
    //
   public function DownloadTicketFile($tkfile)
    {
        $tk=DB::table('tickets')->where('filepath',$tkfile)->first();
        if($tk)
        {
            $filePath =public_path('/Support/'.$tk->filepath);
            $headers = ['Content-Type: application/pdf'];
            $fileName = time().'.pdf';
            return response()->download($filePath, $fileName, $headers);
        }
        else
        {
            return back()->with('error', 'Operation Failed, File Not Found');
        }
       

    
       // $file = Storage::disk('public')->get($file_name);
       // return (new Response($file, 200))->header('Content-Type', 'image/jpeg');
    }
    public function RepliedEmails($email,$ticketid,$res)
    {
        $res = strtoupper($res);
        $parameters =
        '{
        "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
        "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
        "to": [ { "email_address": { "address": "'.$email.'", "name": "User" }}],
        "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
        "subject": "LAUTECH Ticket Reply",
        "textbody": "Thank you for opening a Ticket.:",
        "htmlbody": "<html><body>Thank you for opening a Ticket. Your ticketID  ' .$res. '</body></html>",
        }';
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.zeptomail.com/v1.1/email");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization:Zoho-enczapikey wSsVR60k+R74Wv11nDOuI+hpyl1UBlv0HEl90FTy4nb1GaiT9sc+xhCaDQX1T/QfFWM4RTEWpLkukB9U2jdc290sw18FDyiF9mqRe1U4J3x17qnvhDzOXW5YkhKBL4gOxgponWhpEMEk+g==';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            // var_dump($server_output);
            //die();

    }
    public function RepliedEmail($email,$ticketid,$res)
    {
        $res = strtoupper($res);
        $parameters =
        '{
        "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
        "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
        "to": [ { "email_address": { "address": "'.$email.'", "name": "User" }}],
        "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
        "subject": "LAUTECH Ticket Reply",
        "textbody": "Thank you for opening a Ticket.:",
        "htmlbody": "<html><body>Thank you for opening a Ticket. Your ticketID  ' .$ticketid. ' have been successfully processed and resolved. '.$res.' You can login to your portal to confirm now</body></html>",
        }';
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.zeptomail.com/v1.1/email");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization:Zoho-enczapikey wSsVR60k+R74Wv11nDOuI+hpyl1UBlv0HEl90FTy4nb1GaiT9sc+xhCaDQX1T/QfFWM4RTEWpLkukB9U2jdc290sw18FDyiF9mqRe1U4J3x17qnvhDzOXW5YkhKBL4gOxgponWhpEMEk+g==';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            //var_dump($server_output);
            //die();

    }
    public function ReplyTickets(Request $request)
    {
        if(Auth::check())
        {
           $email = $request->emails;
           $tid = $request->ticketids;
           $response = $request->replys;
           $username =Auth::user()->email;

          //dd($response);
           $sav = DB::INSERT('CALL SaveTicketReply(?,?,?,?)',array($email,$tid,$response,$username));
           if($sav)
           {
             DB::UPDATE('CALL UpdateReplyStatus(?)',array($tid));
             $this->RepliedEmails($email,$tid,$response);
             return back()->with('success', 'Reply Successful');
           }
           else
           {
            return back()->with('error', 'Operation Failed, Please Try Again');
           }

        }
        else
        {
            return view('logon');
        }
    }
    public function ReplyTicket(Request $request)
    {
        if(Auth::check())
        {
           $email = $request->email;
           $tid = $request->ticketid;
           $response = $request->reply;
           $username =Auth::user()->email;

          // dd($email);
           $sav = DB::INSERT('CALL SaveTicketReply(?,?,?,?)',array($email,$tid,$response,$username));
           if($sav)
           {
             DB::UPDATE('CALL UpdateReplyStatus(?)',array($tid));
             $this->RepliedEmail($email,$tid,$response);
             return back()->with('success', 'Reply Successful');
           }
           else
           {
            return back()->with('error', 'Operation Failed, Please Try Again');
           }

        }
        else
        {
            return view('logon');
        }
    }
    public function TicketList()
    {
        if(Auth::check())
        {
            $data  = DB::SELECT('CALL FetchTickets()');
            return view('ticketList',['data'=>$data]);
        }
        else
        {
            return view('logon');
        }
    }
    public function AdminEmail($email,$ticketid,$complains)
    {
                    $parameters =
                    '{
                    "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                    "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                    "to": [ { "email_address": { "address": "'.$email.'", "name": "Administrator" }}],
                    "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                    "subject": "LAUTECH Portal Ticket Support",
                    "textbody": "Thank you for opening a Ticket.:",
                    "htmlbody": "<html><body>Thank you for opening a Ticket. Your ticket will be processed within 48-hours and you will receive a notification in your email.Your Ticket ID is  '.$ticketid.' and complain is '.$complains.'</body></html>",
                    }';
                
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.zeptomail.com/v1.1/email");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization:Zoho-enczapikey wSsVR60k+R74Wv11nDOuI+hpyl1UBlv0HEl90FTy4nb1GaiT9sc+xhCaDQX1T/QfFWM4RTEWpLkukB9U2jdc290sw18FDyiF9mqRe1U4J3x17qnvhDzOXW5YkhKBL4gOxgponWhpEMEk+g==';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
           // var_dump($server_output);
            //die();
            curl_close ($ch);
    }
    public function Supports(Request $request)
    {
        if(Auth::check())
        {
            $email = Auth::user()->email;
            $name = Auth::user()->name;
            $portal=$request->portal;
            $category=$request->category;
            $application=$request->application;
            $subject=$request->subject;
            $complains=$request->complains;
            $datafile = $request->datafile;
            $id = substr(mt_rand(1, 9999).mt_rand(1, 999999).mt_rand(1, 999999), 1,7);
            $ticketid  =date("dmY").$id;
           // $filepath=0;
            if($complains=="")
            {
                return back()->with('error', 'Operation Failed, Complains Required');
            }
            $input['imagename'] = $ticketid.'.'.$datafile->getClientOriginalExtension();
            $destinationPath = public_path('/Support/');
            $datafile->move($destinationPath, $input['imagename']);
            $imgP=$input['imagename'];
            $photo=$imgP;

             $sav = DB::INSERT('CALL SaveTicket(?,?,?,?,?,?,?,?)',
             array($email,$ticketid,$category,$application,$portal,$subject,$complains,$photo));
             $admin_email ="golamiji@lautech.edu.ng";
             $receiver = 
             [
                 'admin'=>$admin_email,
                 'user'=>$email
             ];
            
             if($sav)
             {



                //Send Email
                            $parameters =
                            '{
                            "bounce_address": "bounced@bounce.mailx.lautech.edu.ng",
                            "from": { "address": "appman@mailx.lautech.edu.ng","name": "Webmaster" },
                            "to": [ { "email_address": { "address": "'.$email.'", "name": "'.$name.'" }}],
                            "reply_to":[{"address": "support@lautech.edu.ng","name": "LAUTECH Webmaster"}],
                            "subject": "LAUTECH Portal Ticket Support",
                            "textbody": "Thank you for opening a Ticket.:",
                            "htmlbody": "<html><body>Thank you for opening a Ticket. Your ticket will be processed within 48-hours and you will receive a notification in your email.Your Ticket ID is  '.$ticketid.' and complain is '.$complains.'</body></html>",
                            }';
                        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://api.zeptomail.com/v1.1/email");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);  //Post Fields
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization:Zoho-enczapikey wSsVR60k+R74Wv11nDOuI+hpyl1UBlv0HEl90FTy4nb1GaiT9sc+xhCaDQX1T/QfFWM4RTEWpLkukB9U2jdc290sw18FDyiF9mqRe1U4J3x17qnvhDzOXW5YkhKBL4gOxgponWhpEMEk+g==';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $server_output = curl_exec ($ch);
                    //var_dump($server_output);
                   // die();
                    curl_close ($ch);
                    $this->AdminEmail($admin_email,$ticketid,$complains);
                    return back()->with('success', 'Your Ticket Was Successfully Submitted.Please Check Your Email For Confirmation. TicketID is '.$ticketid);
             }
             else
             {
                return back()->with('error', 'Operation Failed, Please Try Again');
             }







            //  $client = new \GuzzleHttp\Client();
              $client = new \GuzzleHttp\Client();
            /*  $data =
              [
                  'portal'=>$request->portal,
                  'category'=>$request->category,
                  'application'=>$request->application,
                  'subject'=>$request->subject,
                  'complains'=>$request->complains,
              ];
              $url ='http://localhost:8000/api/v1/SaveTicket';
              $request = $client->post($url,['content-type' => 'application/json'], );
              $request->setBody($data); #set body!
              $response = $request->send();
  
              $client = new \GuzzleHttp\Client(["base_uri" => "http://localhost:8000/"]);
              $options = [
                  'form_params' =>
                   [
                    "portal"=>$request->portal,
                    "category"=>$request->category,
                    "application"=>$request->application,
                    "subject"=>$request->subject,
                    "complains"=>$request->complains,
                     ]
                 ]; 
               $response = $client->post("/SaveTicket", $options);  
               echo $response->getStatusCode();
               // echo $response->getBody();
         /*
            $client = new \GuzzleHttp\Client();
            //$url   = "http://192.168.150.16:7585/api/v1/Transaction/GetTransactionNumber";
            $url ="http://localhost:8000/SaveTicket";
            $data   = [
                        "portal"=>$request->portal,
                        "category"=>$request->category,
                        "application"=>$request->application,
                        "subject"=>$request->subject,
                        "complains"=>$request->complains,
                    ];

            $requestAPI = $client->post( $url, [
                    'headers' => ['Content-Type' => 'application/json'],
                    'body' => json_encode($data)
                ]);
                 */
                
        $client = new \GuzzleHttp\Client();
        $url ="http://localhost:8000/SaveTicket";
        $myBody['name'] = "Demo";
        $request = $client->post($url, ['headers' =>
                                           ['Content-Type' => 'application/x-www-form-urlencoded']
                                           ], 
                                           ['body'=>$myBody]
       );
        $response = $request->send();
        dd($response);

        }
        else
        {
            return view('logon');
        }
    }
    public function Support()
    {
        if(Auth::check())
        {
            $data ="";
        /*
            try
            {
              ini_set('max_execution_time', 300);
              $client = new \GuzzleHttp\Client();
              $url    = 'http://localhost:8000/api/v1/GetPortalist';     
              $response =$client->request('GET', $url,['stream' => true]);
              
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
               
            }
            */
            $p = DB::SELECT('CALL FetchPortal()');  // Portals::all();
            $c = DB::SELECT('CALL FetchCategory()'); //Category::all();
            return view('supportPage',['data'=>$data,'p'=>$p,'c'=>$c]);
        }
        else
        {
            return view('logon');
        }
    }

    public function GetTickets($pid=0)
    {
        if(Auth::check())
         {
         // Fetch Employees by programme
             $empData['data'] = DB::SELECT('CALL GetTicketApplication(?)', array($pid));
             return response()->json($empData);
          }
    }
}
