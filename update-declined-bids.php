<?php

require("connection.php");

//Get declined bid ID through post, declare and initialize bidStatus variable.
$declinedBidID = $_POST['declinedBid'];
$bidStatus = "6";  //Bid status of 6 = 'Declined'

if($stmt = $conn -> prepare ("UPDATE bid SET status=? WHERE bid_id=?")){
    
    /*Bind parameters*/
    $stmt->bind_param("ss", $bidStatus, $declinedBidID);
    $stmt->execute();
    $stmt->store_result();
    $stmt -> free_result();
    $stmt -> close();
        
} else {
    echo 'There was a SQL error. Please try again. Back to submit bid <a href="my_requests_customer.php">page</a>';
    exit(); 
}

