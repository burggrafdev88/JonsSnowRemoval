<?php

    //If we don't access this page by hitting the submit bid button, display an error message and terminate the script.
    if(!isset($_POST['bid-submit'])){
        echo " Error: There is nothing in the POST. Back to submit bid <a href='submit-bid.php'>page</a>.";
        exit();
    }

    require("connection.php");

    //Variables passed through POST
    $providerID             = $_POST['providerID']; 
    $est_completion_date    = $_POST['formattedEstCompletionDate'];
    $est_completion_time    = $_POST['estimated_completion_time'];  
    $bid                    = $_POST['bid'];
    $requestId              = $_POST['requestId'];
    $status                 = "1";  //reflects "Submitted" in the bid status table
    
    //echo $est_completion_date;
    //$est_completion_date = '2020/03/18';
    
    $sql = "SELECT bid_id FROM bid WHERE (request_id=?) AND (provider_ID=?) AND (status NOT IN (5,6))"; 

    $stmt = mysqli_stmt_init($conn);
    
    //Prepare statement
    if(!mysqli_stmt_prepare($stmt, $sql)){
       echo 'There was an error with your first prepared statement. Please try again with your prepared statement. Back to view requests <a href="view-requests.php">page</a>';
       exit(); 
    } 
        
    /*If prepare statement is successful, check to ensure the company does not already have an existing bid in the system for this service request.  If a bid already exists, notify the provider and terminate the script.*/
        
    mysqli_stmt_bind_param($stmt, "ss", $requestId, $providerID);  //bind parameters
    mysqli_stmt_execute($stmt);  //execute
    mysqli_stmt_store_result($stmt);  //store result
    $resultCheck = mysqli_stmt_num_rows($stmt);  //Returns number of rows in the result set
        
    if($resultCheck > 0){
        echo "Your company already has an existing bid for this request.  If you would like to submit a new bid, please delete your existing bid in the 'My Bids' <a href='view_my_bids.php'> page</a>.";
        exit();
            
    } 
        
    /*If result check is not greater than 0, submit bid*/
            
    //Create new sql statement to submit bid
    $sql = "INSERT INTO bid (request_id, provider_ID, estimated_completion_date, estimated_completion_time, cost, status) VALUES (?, ?, ?, ?, ?, ?)";
    
    //Prepare statement.  If successful, execute sql statement
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'There was a SQL error. Please try again. Back to submit bid <a href="submit-bid.php">page</a>';
        exit(); 
        
    } else{
        
        mysqli_stmt_bind_param($stmt, "ssssss", $requestId, $providerID, $est_completion_date, $est_completion_time, $bid, $status);
        mysqli_stmt_execute($stmt);
        
        header("Location: view-requests.php?message=bidSubmitted");
        //echo " Insert executed. Back to <a href='index.php'>home page</a>.";
    }        

 


        
    
   