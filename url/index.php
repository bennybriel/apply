<?php
      @$id = $_GET['response'];
    // echo $id;
      $port ="3606";
      $con = mysqli_connect("localhost","lautechp_apply","applyadmin","lautechp_applyapp",$port);
	// Check connection
	   if ($con -> connect_errno) {
	    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	    exit();
	  }
	
	
          
               $txnref      = $_POST['txnref'];
               $status      = $_POST['status'];
               echo $status;
             
          
          //Check Returning URL
            $client = new \GuzzleHttp\Client();
            $url = "https://gatewaylautech.bennybriel.com/index.php/api/getPaymentStatus/".$_POST['txnref'];    
            $response =$client->request('GET', $url, ['headers' => [ 'token' => 'funda123']]);
            $res = json_decode($response->getBody());
            $sq = "INSERT INTO request_loggers (request) VALUES ('".json_encode($res)."')"; $con->query($sq);



            //dd($res);
       // if($res)
       // {
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
              
             // echo $apptype; die();
             $sql = "UPDATE users u
             INNER JOIN u_g_student_accounts st 
             ON u.matricno = st.matricno
             SET u.ispaid = 1, st.ispaid = 1, 
             st.response ='". $status."'
             WHERE transactionID ='". $txnref."'";
             $res = $con->query($sql);

               if($res > 0 && $apptype=="UGD")
                {
                    $script = "<script>
                                window.location = 'ValidateUTME';
                            </script>";
                    echo $script;
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
                elseif($res > 0 && $apptype=="PG")
                {
                  $script = "<script>
                       window.location = 'PGDataForm';
                    </script>";
                  echo $script;
                }
                else
                {
                    if($res  > 0)
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
                                  #Redirect to Querry Transaction Page
                                  echo "<script>
                                  setTimeout(function()
                                  {
                                      window.location ='home';
                                },2000);
                                </script>";

                    }

              }
           }  
           else
           {
                $script = "<script>
                       window.location = 'home';
                    </script>";
                  echo $script;
           }
              
      //  }     
         
?>   
      
    

