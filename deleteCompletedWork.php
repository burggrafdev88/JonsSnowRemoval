<?php

/*This script will update the status of the bid to 'Inactive'*/

require("connection.php");

//Variables passed through POST.
$bidID = $_POST['bidID'];
$status = 7;  //"Inactive" for bids

/*Sql update statement*/
$sql = "UPDATE bid SET status=? WHERE bid_id=?"; 
$stmt = mysqli_stmt_init($conn);

//Prepare statement to select status.  If successful, execute sql statement
if(!mysqli_stmt_prepare($stmt, $sql)){
    echo 'There was an issue with the prepared statement. Please try again. Back to completed work <a href="view_my_completed_work.php">page</a>';
    exit(); 
    
} else{
    mysqli_stmt_bind_param($stmt, "ii", $status, $bidID);
    mysqli_stmt_execute($stmt);
    
     if(mysqli_stmt_affected_rows($stmt) > 0){
        echo "Your record was deleted.";
    } else {
        echo "There was an issue deleting your record.";
    }

    mysqli_stmt_close($stmt); //close statement to free up resources
}   