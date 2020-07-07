<?php

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['signup-submit-customer'])){
        echo " Error: There is nothing in the POST. Back to sign up <a href='signup-customer.php'>page</a>.";
        exit();
    }

    require("connection.php");

    //Variables passed through POST.
    $f_name      = $_POST['f_name'];
    $l_name      = $_POST['l_name'];
    $email       = $_POST['email'];
    $phonenumber = $_POST['phone'];
    $password1   = $_POST['psw'];
    $password2   = $_POST['psw-repeat'];  
    
    //Check if email is a valid emal address, check if passwords match, and check if email already exists in database.
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo 'Please enter a valid email. Back to sign up <a href="signup-customer.php">page</a>';
        exit();
        
    } else if($password1!=$password2){
        echo 'Your passwords did not match. Please try again. Back to sign up <a href="signup-customer.php">page</a>';
        exit();
        
    } else {
        //I will need to update this with the correct table info, etc.
        $sql = "SELECT email FROM user WHERE email=?";   
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
           echo 'There was an error. Please try again. Back to sign up <a href="signup-customer.php">page</a>';
           exit(); 
            
        } else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
        
            if($resultCheck > 0){
                echo 'Email address already exists. Please try again. Back to sign up <a href="signup-customer.php">page</a>';
                exit();
            }  else {
                $sql = "INSERT INTO user (email, phone, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)";  
                $stmt = mysqli_stmt_init($conn);
                
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo 'There was a SQL error. Please try again. Back to sign up <a href="signup-customer.php">page</a>';
                    exit(); 
            
                } else {
                    $hashedPwd = password_hash($password1, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "sssss", $email, $phonenumber, $hashedPwd, $f_name, $l_name);
                    
                    mysqli_stmt_execute($stmt);
                    
                    echo 'Insert executed.  <a href="login-customer.php">Login</a>';
                }
            }
            
            
        }   
    } 
    
    


    
    
    
    

