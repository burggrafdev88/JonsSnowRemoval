<?php
    session_start();

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['update-customer-profile'])){
        echo " Error: There is nothing in the POST. Back to edit profile <a href='edit-profile-customer.php'>page</a>.";
        exit();
    }

    require("connection.php");

    //Variables passed through POST.
    $email       = $_POST['email'];
    $f_name      = $_POST['f_name'];
    $l_name      = $_POST['l_name'];
    $phonenumber = $_POST['phone'];

    $sql = "UPDATE user SET first_name=?, last_name=?, phone=? WHERE email=?";  
    $stmt = mysqli_stmt_init($conn);
        
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'There was a SQL error. Please try again. Back to sign up <a href="signup-customer.php">page</a>';
        exit(); 
    } else{
        mysqli_stmt_bind_param($stmt, "ssss", $f_name, $l_name, $phonenumber, $email);
        mysqli_stmt_execute($stmt);
        $_SESSION['welcome_name'] = $f_name;
        $_SESSION['f_name'] = $f_name;
        $_SESSION['l_name'] = $l_name;
        $_SESSION['phone'] = $phonenumber;
        
        header("Location: index.php?message=updateComplete");
        //echo 'Update executed.  Back to home <a href="index.php">page</a>';
    }


                    
        
                    



            
            
        
    
    


    
    
    
    



    
    
    
    

