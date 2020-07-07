<?php
    
  //Create a connection.
     $servername = "localhost";
     $username = "root";
     $password = "";  //test environment pw is ''.
     $dbname = "snowday";  
     //$dbname = "loginsystem";  

     $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed bro!!!: " . $conn->connect_error);
     } 
    