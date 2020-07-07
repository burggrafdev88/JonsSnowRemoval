<?php

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['service-submit'])){
        echo " Error: There is nothing in the POST. Back to request service <a href='request-service.php'>page</a>.";
        exit();
    }

    require("connection.php");

    //Variables passed through POST.
    $email          = $_POST['email'];
    $f_name         = $_POST['f_name'];
    $phoneNumber    = $_POST['phone'];
    $street         = $_POST['address'];
    $city           = $_POST['city'];
    $state          = $_POST['state'];
    $zip            = $_POST['zip'];
    $completionDate = $_POST['completion_date'];
    $status         = "1";  //Reflects "Bids Requested" for requests
    
    /*Google API - https://developers.google.com/maps/documentation/geocoding/intro*/
    $address = $street . ' ' . $city . ' ' . $state . ' ' . $zip;  //concatenate address

    $prepAddress = str_replace(' ', '+', $address);
    
    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddress.'&key=AIzaSyCpasZnCrZDvcAjyWcoeBcVqqo5Yfzd05A');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;   
    echo $latitude;
    echo $longitude;
    echo $status;
    $sql = "INSERT INTO request (email, first_name, phone, street, city, state, zip, lat, lng, requested_completion_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
        
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'There was a SQL error. Please try again. Back to request service <a href="request-service.php">page</a>';
        exit(); 
            
    } else {                 
        
        mysqli_stmt_bind_param($stmt, "sssssssssss", $email, $f_name, $phoneNumber, $street, $city, $state, $zip, $latitude, $longitude, $completionDate, $status);
        
        mysqli_stmt_execute($stmt);
        
        header("Location: index.php?message=requestSubmitted");
        //echo " Insert executed. Back to <a href='index.php'>home page</a>.";
    } 


    /*Begin inserting image into table and file directory now that the request has been inserted.*/

    //Prepping file name
    $countfiles = count($_FILES['file']['name']);  //count the number of files uploaded
    echo $countfiles;
    $requestID = mysqli_insert_id($conn);  // retrieve request ID from insert statement above
    
    // Looping through attached files
    for($i=0; $i<$countfiles; $i++){
        $name           = strtolower($_FILES['file']['name'][$i]);  //name of file with extension, in lowercase
        $target_dir     = "request-images/";  //directory where image(s) will be stored
        $target_file    = $target_dir . basename($_FILES["file"]["name"][$i]); //concatenate target directory and file name
        
        //Select file type
        $imageFileType = strtolower(pathinfo($target_dir.$name, PATHINFO_EXTENSION));  //determine extension of file

        //Valid file extensions
        $extensions_arr = array("jpg", "jpeg", "png", "gif");  //declare and initialize array of allowable file paths
        
        //Check extension. Store in database and upload into directory if extension is in array.
        if(in_array($imageFileType, $extensions_arr)){
            //Insert record
            $sql = "INSERT INTO request_image (request_id, img_dir) VALUES (?,?)";
            $stmt = mysqli_stmt_init($conn);

            //Prepare sql statement
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo 'There was a SQL error while storing your image name. Please try again. Back to request service <a href="request-service.php">page</a>';
                exit(); 
                
            } else{
                //Store record
                mysqli_stmt_bind_param($stmt, "is", $requestID, $name);
                mysqli_stmt_execute($stmt);

                //Upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_dir.$name);
            }
        }
    } 