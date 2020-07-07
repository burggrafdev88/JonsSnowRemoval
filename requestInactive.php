<?php

/*This script will update the status of the requestID to 'Inactive'.*/

require("connection.php");

//Variables passed through POST.
$requestID = $_POST['requestID'];
$status = 6;  //'Inactive' for requests

/*Sql update statement*/
$sql = "UPDATE request SET status=? WHERE idRequests=?"; 
$stmt = mysqli_stmt_init($conn);

//Prepare statement to update status.  If successful, execute sql statement
if(!mysqli_stmt_prepare($stmt, $sql)){
    echo 'There was an issue removing the completed request. Please try again. Back to completed requests <a href="my_completed_requests_customer.php">page</a>';
    exit(); 
    
} else{
    mysqli_stmt_bind_param($stmt, "ii", $status, $requestID);
    mysqli_stmt_execute($stmt);
    
    if(mysqli_stmt_affected_rows($stmt) > 0){
        echo "Your record was deleted.";
    } else {
        echo "There was an issue deleting your record.";
    }
    
    mysqli_stmt_close($stmt); //close statement to free up resources
    
}   