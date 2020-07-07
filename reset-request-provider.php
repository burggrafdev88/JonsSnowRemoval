<?php

//reset-request-provider.php file for Jon's Snow Removal Page

//If we enter this page through the POST method, execute the following script; otherwise, give an error.
if(isset($_POST["reset-request-submit"])){
    
    //Create selector and token that will be stored in the database and used in the reset URL
    $selector = bin2hex(random_bytes(8));  //hexadecimal format
    $token = random_bytes(32);  //token will be used to authenticate the user
    
    //Create URL
    $url = "http://localhost/jonssnow/create-new-pw-provider.php?selector=" . $selector . "&validator=" . bin2hex($token);
    
    //Set expiration date for token in the database. 
    $expires = date("U") + 600;
    
    //Call database connection
    require("connection.php");
    
    //Pull in user email from the POST
    $providerEmail = $_POST["email"];
    
    /*Step 1:  Remove any existing reset requests for the user.*/
    
    //Create sql prepared statement and establish connection.  Statement will be used to remove old user reset requests.
    $sql = "DELETE FROM pwdresetprovider WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    
    //Prepare and execute statement
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error with the sql statement!";
        exit();
        
    } else{
        mysqli_stmt_bind_param($stmt, "s", $providerEmail);
        mysqli_stmt_execute($stmt);  //existing user requests removed
    } 
    
    /*Step 2:  Insert new reset request from the provider.*/

    //Create new sql prepared statement to insert new provider request into database.
    $sql = "INSERT INTO pwdresetprovider (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    
    //Prepare and execute new statement to insert reset request into database
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error with the sql statement!";
        exit();
        
    } else{
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);  //Hash token
        mysqli_stmt_bind_param($stmt, "ssss", $providerEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);  //Reset request inserted into database
    }
    
    mysqli_stmt_close($stmt);  //close statement
    mysqli_close($conn);  //close connection
    
    /*Step 3:  Begin sending reset request email to the user.*/        
    
    $to = $providerEmail;
    $subject = "Reset your password for Jon's Snow Removal.";
    
    $message = 'We received a password reset request. Please use the link below to reset your password.';
    $message .= $url;
    
    $headers = "From: Jon's Snow Removal <BurggrafDev88@gmail.com>\r\n";
    $headers .= "Reply-To: BurggrafDev88@gmail.com";
    $headers .= "Content-type: text/html\r\n"; 
    
    // Send email
    if(mail($to, $subject, $message, $headers)){   
        //PHP header redirect function would not work - so I redirected using JavaScript.
        echo "<script type='text/javascript'> document.location.href = 'forgot-pw-provider.php?reset=success';</script>";
        
    } else{
       echo "Unable to send email. Back to <a href='login-provider.php'>login page</a>. ";
    }
    
} else{
    echo "There is nothing in the POST.  Back to <a href='login-provider.php'>login page</a>.";
    
} //End of first if / else statement.