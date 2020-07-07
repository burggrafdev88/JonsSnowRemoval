<?php

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['update-customer-pw'])){
        echo " Error: There is nothing in the POST. Back to edit profile <a href='edit-profile-pw.php'>page</a>.";
        exit();
    }

    require("connection.php");

    //Variables passed through POST.
    $email       = $_POST['email'];
    $password1   = $_POST['psw'];
    $password2   = $_POST['psw-repeat'];  
    
    if($password1!=$password2) {
        echo 'Your passwords did not match. Please try again. Back to update password <a href="edit-customer-pw.php">page</a>';
        exit(); 
    } 

    $sql = "UPDATE user SET password=? WHERE email=?";  
    $stmt = mysqli_stmt_init($conn);
        
    if(mysqli_stmt_prepare($stmt, $sql)){
        
        $hashedPwd = password_hash($password1, PASSWORD_DEFAULT);
        
        mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $email);
        
        mysqli_stmt_execute($stmt);
        
        header("Location: edit-profile-customer.php?message=passwordUpdated");
        
        //echo 'Update executed. Back to home <a href="index.php">page</a>';
          
    } else{
        echo 'There was a SQL error. Please try again. Back to update password <a href="edit-customer-pw.php">page</a>';
        exit(); 
    }
    
    
            

        

                    



            
            
        
    