<?php
    session_start();

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['update-provider-profile'])){
        echo " Error: There is nothing in the POST. Back to edit profile <a href='edit-profile-customer.php'>page</a>.";
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

    $address = $c_street . ' ' . $c_city . ' ' . $c_state . ' ' . $c_zip;

    $prepAddress = str_replace(' ', '+', $address);

    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddress.'&key=AIzaSyCpasZnCrZDvcAjyWcoeBcVqqo5Yfzd05A');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;

    $sql = "UPDATE provider SET company=?, phone=?, first_name=?, last_name=?, street=?, city=?, state=?, zip=?, lat=?, lng=? WHERE email=?";  
    $stmt = mysqli_stmt_init($conn);
        
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'There was a SQL error. Please try again. Back to sign up <a href="signup-customer.php">page</a>';
        exit(); 
    } else{
        mysqli_stmt_bind_param($stmt, "sssssssssss", $c_name, $c_phone, $f_name, $l_name, $c_street, $c_city, $c_state, $c_zip, $latitude, $longitude, $c_email);
        mysqli_stmt_execute($stmt);
        
         $_SESSION['welcome_name'] = $c_name;
         $_SESSION['street_address'] = $c_street;
         $_SESSION['city'] = $c_city;
         $_SESSION['state'] = $c_state;
         $_SESSION['zip'] = $c_zip;
         $_SESSION['f_name'] = $f_name;
         $_SESSION['l_name'] = $l_name;
         $_SESSION['phone'] = $c_phone;
         $_SESSION['lat'] = $latitude;
         $_SESSION['lng'] = $longitude;
        
        header("Location: index.php?message=updateComplete");
        //echo 'Update executed.  Back to home <a href="index.php">page</a>';
    }
