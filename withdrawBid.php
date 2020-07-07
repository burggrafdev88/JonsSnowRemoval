<?php

/*This script will delete the requestID from the request table.*/

require("connection.php");

//Variables passed through POST.
$bidID = $_POST['bidID'];
$status = 5;  //reflects 'Cancelled by Provider'

/*Prepared statement to update the status of the bid in the bid table*/
if($stmt = $conn -> prepare("UPDATE bid SET status=? WHERE bid_id=?")){
    
    //Bind parameters
    $stmt->bind_param("ii", $status, $bidID);

    //Execute query
    if($stmt->execute()){
            
        //If successful, determine # of rows affected. If -1, there was an error executing the statement. If 0, no rows affected. Positive interger reflects the # of rows affected. 
        echo "Number of rows affected in the bid table: ";
        echo $stmt -> affected_rows;

    } else{
            echo "There was an error executing the update statement for the bid.";
            exit();
        
    }  //end of if statement for execute
    
    //Close statement.
    $stmt -> close();
       
}  //end of prepared statement to update status in bid table

