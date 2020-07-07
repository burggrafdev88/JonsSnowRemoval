<?php

/*This script will update the bid and request tables to reflect the bids that have been accepted and declined.*/

require("connection.php");

//Variables passed through POST and declare and initialize bid status variable. Only get declinedBids if it exists.
$acceptedBidID = $_POST['acceptedBid'];
if( isset($_POST['declinedBids']) )
{
    $declinedBids = $_POST['declinedBids'];
}
$bidStatus = "2";  //Bid status of 2 = "Accepted".

/*Sql update statement*/
$sql = "UPDATE bid SET status=? WHERE bid_id=?"; 
$stmt = mysqli_stmt_init($conn);

//Prepare statement to update bid table.  If successful, execute sql statement
if(!mysqli_stmt_prepare($stmt, $sql)){
    echo 'There was a SQL error. Please try again. Back to submit bid <a href="my_requests_customer.php">page</a>';
    exit(); 
    
} else{
    mysqli_stmt_bind_param($stmt, "ss", $bidStatus, $acceptedBidID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt); //close statement to free up resources

    echo "The bid has been accepted."; 
}   

/*Code to retrieve request ID from the bid ID table and update the status of the request in the request table*/
if($stmt = $conn -> prepare ("SELECT request_id FROM bid WHERE bid_id=?")){
    
    /*Bind parameters*/
    $stmt->bind_param("s", $acceptedBidID);
    
    $stmt->execute();
    
    $stmt->store_result();
    
    /*If number of rows returned is zero, exit the script*/
    if($stmt->num_rows === 0){
        exit("No rows were returned.");
    } 
    
    /*If rows are returned, bind result to a PHP variable, add result to array.*/
    $stmt->bind_result($request);
    
    while($stmt->fetch()) {
        $ids[] = $request;
    }
    
    /*Free result set and close stmt.*/
    $stmt -> free_result();
    $stmt -> close();
    
    
    /*Code to update the status in the request record to 'Awaiting Service' now that the bid has been accepted.*/
    
    /*Prepare a new statement in order to update the status of the customer request.*/
    $stmt = $conn -> prepare("UPDATE request SET status=? WHERE idRequests=?");
    $requestStatus = "2";  //Status of 2 = "Awaiting Service".
    $stmt ->bind_param("ss", $requestStatus, $ids[0]);  //Ids array created from the sql query above
    $stmt -> execute();
    $stmt -> free_result();
    $stmt -> close();
    
} else {
    echo 'There was a SQL error. Please try again. Back to submit bid <a href="my_requests_customer.php">page</a>';
    exit(); 
}

/*Code below to set the status of the non-accepted bids to 'Declined'*/

/*If $declinedBids exists, loop through bidID array, update status to reflect declined.*/
if( isset($declinedBids) )
{
    foreach ($declinedBids as $bidID) {
    $stmt = $conn -> prepare("UPDATE bid SET status=? WHERE bid_id=?");
    $bidStatus = "6";  //Status of 6 = "Declined".
    $stmt ->bind_param("ss", $bidStatus, $bidID);  //IDs array created from the sql query above
    $stmt -> execute();
}

$stmt -> free_result();
$stmt -> close();
}

?>
