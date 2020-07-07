<?php

/*This script will delete the requestID from the request table.*/

require("connection.php");

//Variables passed through POST.
$requestID = $_POST['requestID'];
$status = 4;  //reflects 'Cancelled by Customer'

/*Prepared statement to update the status of the request in the request table*/
if($stmt = $conn -> prepare("UPDATE request SET status=? WHERE idRequests=?")){
    
    //Bind parameters
    $stmt->bind_param("ii", $status, $requestID);

    //Execute query
    if($stmt->execute()){
            
        //If successful, determine # of rows affected. If -1, there was an error executing the statement. If 0, no rows affected. Positive interger reflects the # of rows affected. 
        echo "Number of rows affected in the request table: ";
        echo $stmt -> affected_rows;

    } else{
            echo "There was an error executing the update statement for the request.";
            exit();
        
    }  //end of if statement for execute
    
    //Close statement.
    $stmt -> close();
       
}  //end of prepared statement to update status in request table

/*Prepares statement to update the status of the bid in the bid table*/
if($stmt = $conn -> prepare("UPDATE bid SET status=? WHERE request_id=?")){
    
    //Bind parameters
    $stmt->bind_param("ii", $status, $requestID);

    //Execute query
    if($stmt->execute()){
            
        //If successful, determine # of rows affected. If -1, there was an error executing the statement. If 0, no rows affected. Positive interger reflects the # of rows affected. 
        echo "Number of rows affected in the bid table: ";
        echo $stmt -> affected_rows;
            
    } else{
        echo "There was an error executing the update statement for the bid.";
        exit();
            
    } //end of if statement for execute
    
} //end of prepared statement to update status in bid table
    
//Close statement.
$stmt -> close();
 

    
    


