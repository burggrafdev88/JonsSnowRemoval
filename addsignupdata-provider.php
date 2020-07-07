<?php

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['signup-submit-provider'])){
        echo " Error: There is nothing in the POST. Back to sign up <a href='signup-provider.php'>page</a>.";
        exit();
    }

    require("connection.php");

    //Variables passed through POST.
    $c_name      = $_POST['c_name'];
    $c_street    = $_POST['c_street'];
    $c_city      = $_POST['c_city'];
    $c_state     = $_POST['c_state'];
    $c_zip       = $_POST['c_zip'];
    $c_email     = $_POST['c_email'];
    $c_phone     = $_POST['c_phone'];
    $f_name      = $_POST['f_name'];
    $l_name      = $_POST['l_name'];
    $password1   = $_POST['psw'];
    $password2   = $_POST['psw-repeat'];  

    $address = $c_street . ' ' . $c_city . ' ' . $c_state . ' ' . $c_zip;

    $prepAddress = str_replace(' ', '+', $address);

    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddress.'&key=AIzaSyCpasZnCrZDvcAjyWcoeBcVqqo5Yfzd05A');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;
    
    //Check if email is a valid email address, check if passwords match.
    if(!filter_var($c_email, FILTER_VALIDATE_EMAIL)){
        echo 'Please enter a valid email. Back to sign up <a href="signup-provider.php">page</a>';
        exit();
        
    } else if($password1!=$password2){
        echo 'Your passwords did not match. Please try again. Back to sign up <a href="signup-provider.php">page</a>';
        exit();
        
    } else {
        //I will need to update this with the correct table info, etc.
        $sql = "SELECT company FROM provider WHERE email=?";   
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
           echo 'There was an error. Please try again. Back to sign up <a href="signup-provider.php">page</a>';
           exit(); 
            
        } else{
            mysqli_stmt_bind_param($stmt, "s", $c_email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
        
            if($resultCheck > 0){
                echo 'Email address already exists. Please try again. Back to sign up <a href="signup-provider.php">page</a>';
                exit();
                
            }  else {
                $sql = "INSERT INTO provider (company, email, phone, first_name, last_name, password, street, city, state, zip, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";  
                
                $stmt = mysqli_stmt_init($conn);
                
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo 'There was a SQL error. Please try again. Back to sign up <a href="signup-provider.php">page</a>';
                    exit(); 
            
                } else {
                    $hashedPwd = password_hash($password1, PASSWORD_DEFAULT);
                    
                    //mysqli_stmt_bind_param($stmt, "ssssssssssss", $c_name, $c_email, $c_phone, $f_name, $l_name, $hashedPwd, $c_street, $c_city, $c_state, $c_zip, $latitude, $longitude);
                    
                    mysqli_stmt_bind_param($stmt, "ssssssssssss", $c_name, $c_email, $c_phone, $f_name, $l_name, $hashedPwd, $c_street, $c_city, $c_state, $c_zip, $latitude, $longitude);
                    
                    mysqli_stmt_execute($stmt);
                    
                    echo 'Insert executed! <a href="login-provider.php">Login</a>';
                    
                }
            }
            
            
        }   
    } 
    
    


    
    
    
    

