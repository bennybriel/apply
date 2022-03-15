<?php
      @$id = $_GET['response'];
    // echo $id;
      $port ="3606";
      $con = mysqli_connect("localhost","applyz_apply","apply@admin","applyz_app");
	// Check connection
	   if ($con -> connect_errno) {
	    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	    exit();
	  }
	
	
          
               $txnref      = $_POST['txnref'];
               $status      = $_POST['status'];
               
             
          
             //Check Returning URL
              //$url = "https://gateway.lautech.edu.ng/index.php/api/getPaymentStatus/".$_POST['txnref']; 
             // $response = get_web_page($url);
             // $json = json_decode($response, true);
            
            $res =$status . ' '.$_POST['txnref'];
            $sq = "INSERT INTO request_loggers (request) VALUES ('".$res."')"; $con->query($sq);
            if($status == "Transaction Successful")
            {
                 
                $sta = 1;
                $resp       = $res->status;
                $yr= date("Y");
              
                $counter=0;
                $app = "SELECT apptype,matricno,session
                      FROM u_g_student_accounts
                      WHERE transactionID ='".$_POST['txnref']."'";
                  $resapp = $con->query($app);
                  if($resapp->num_rows > 0)
                  {
                      while($rows = $resapp->fetch_assoc()) 
                      {
                          $apptype = $rows['apptype'];
                      }
                  }
              
           
             $sql = "UPDATE users u
             INNER JOIN u_g_student_accounts st 
             ON u.matricno = st.matricno
             SET u.ispaid = 1, st.ispaid = 1, 
             st.response ='". $status."'
             WHERE transactionID ='". $txnref."'";
             $res = $con->query($sql);

               if($apptype=="UGD")
                { 
                       $l = substr($_POST['txnref'],0,2);
                       if($l=="CP") 
                       {
                             echo "<script>
                             setTimeout(function()
                             {
                                 window.location ='ChangeProgramme';
                           },2000);
                           </script>";
                       }
                       else
                       {
                          $script = "<script>
                                      window.location = 'ValidateUTME';
                                  </script>";
                          echo $script;
                       }
                }
                elseif($res  > 0 && $apptype=="DE")
                {
                  $script = "<script>
                       window.location = 'DEData';
                    </script>";
                  echo $script;
                }
                elseif($res  > 0 && ($apptype=="PDS" || $apptype=="JUP"))
                {
                  $l = substr($_POST['txnref'],0,2);
                  if($l=="AC" || $l=="TU") 
                  {
                        echo "<script>
                        setTimeout(function()
                        {
                            window.location ='PayHome';
                      },2000);
                      </script>";
                  }
                  else
                  {
                    echo "<script>
                                    setTimeout(function()
                                    {
                                        window.location ='StudentInfo';
                                  },2000);
                                  </script>";
                 }
                }
                elseif($res > 0 && $apptype=="PT")
                {

                  $l = substr($_POST['txnref'],0,3);
                  if($l=="PT2")
                  {
                      $script = "<script>
                                window.location = 'StudentInfo';
                              </script>";
                       echo $script;
                  }
                  elseif($l=="PTA" || $l=="PTM" || $l=="PTT") 
                  {
                        echo "<script>
                        setTimeout(function()
                        {
                            window.location ='PTAdmission';
                      },2000);
                      </script>";
                  }
                  else
                  {
                    $script = "<script>
                                window.location = 'PaymentTracker';
                            </script>";
                    echo $script;
                  }
                 
                }
                elseif($res > 0 && $apptype=="PG")
                {
                    $l = substr($_POST['txnref'],0,3);
                    if($l=="PG2")
                    {
                       $script = "<script>
                                   window.location = 'PGDataForm';
                               </script>";
                      echo $script;
                    }
                    elseif($l=="PAC" || $l=="PGT" || $l=="PGE") 
                    {
                          echo "<script>
                          setTimeout(function()
                          {
                              window.location ='PGAdmission';
                        },2000);
                        </script>";
                    }
                    else
                    {
                      $script = "<script>
                                  window.location = 'PaymentTracker';
                              </script>";
                      echo $script;
                    }
                }
                else
                {
                    if($res  > 0)
                    {
                          echo "<script>
                          setTimeout(function()
                          {
                              window.location ='PaymentTracker';
                        },2000);
                        </script>";
                    }
                    else
                    {
                                  #Redirect to Querry Transaction Page
                                  echo "<script>
                                  setTimeout(function()
                                  {
                                      window.location ='PaymentTracker';
                                },2000);
                                </script>";

                    }

              }
           }  
           else
           {
               // $res =$status . ' '.$_POST['txnref'];
                //$sq = "INSERT INTO request_loggers (request) VALUES ('".$res."')"; $con->query($sq);
                $script = "<script>
                       window.location = 'PaymentTracker';
                    </script>";
                  echo $script;
           }
              
      //  } 
      
      function get_web_page($url) 
      {
          $options = array(
              CURLOPT_RETURNTRANSFER => true,   // return web page
              CURLOPT_HEADER         => false,  // don't return headers
              CURLOPT_FOLLOWLOCATION => true,   // follow redirects
              CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
              CURLOPT_ENCODING       => "",     // handle compressed
              CURLOPT_USERAGENT      => "test", // name of client
              CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
              CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
              CURLOPT_TIMEOUT        => 120,    // time-out on response
          ); 
      
          $ch = curl_init($url);
          curl_setopt_array($ch, $options);
      
          $content  = curl_exec($ch);
      
          curl_close($ch);
      
          return $content;
      }
         
?>   
      
    

