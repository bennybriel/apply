<?php

     // Define database connection parameters
     $hn 		= 'localhost';
     $un 		= 'lautechp_apply';
     $pwd		= 'applyadmin';
     $db 		= 'lautechp_applyapp';
     $cs 		= 'utf8';
     // Set up the PDO parameters
     $dsn 	= "mysql:host=" . $hn . ";port=3606;dbname=" . $db . ";charset=" . $cs;
     $opt 	= array(
                          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                          PDO::ATTR_EMULATE_PREPARES   => false,
                          PDO::ATTR_PERSISTENT => 'buff',
                          PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                         );

             //$pdo = new PDO("mysql:host=".$hn.";dbname=".$db, $un, $pwd, 
            // array(PDO::ATTR_PERSISTENT => 'buff', PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));

     // Create a PDO instance (connect to the database)
         //$pdo 	= new PDO($dsn, $un, $pwd, $opt); 
         //$pdo1 	= new PDO($dsn, $un, $pwd, $opt); 
   
   // echo "tets";
	  $pdo = new PDO("mysql:host=".$hn.";dbname=".$db, $un, $pwd, array(PDO::ATTR_PERSISTENT => 'buff', PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));


?>