<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<?php

    //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['service-submit'])){
        echo " Error: There is nothing in the POST. Back to request service <a href='request-service.html'>page</a>.";
        exit();
    }

    //Create a connection.
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "loginsystem";  

     $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
     if ($conn->connect_error) {
         die("Connection failed bro!!!: " . $conn->connect_error);
     } else {
         echo " Connection successful.";
     }  

    //Variables passed through POST.
    $email          = $_POST['email'];
    $f_name         = $_POST['f_name'];
    $phoneNumber    = $_POST['phone'];
    $street         = $_POST['address'];
    $city           = $_POST['city'];
    $state          = $_POST['state'];
    $zip            = $_POST['zip'];
    $squareFeet     = $_POST['feet'];  
    $proposedPrice  = $_POST['proposed-price'];


    /*
    <script>
        //call geocode();
        geocode();
        
        function geocode(){
            var addressLocation = '<?php echo $street ?> ' + '<?php echo $city ?> ' + '<?php echo $state ?> ' + '<?php echo $zip ?> ';
            
            axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                params: {
                    address: addressLocation,
                    key: 'AIzaSyCpasZnCrZDvcAjyWcoeBcVqqo5Yfzd05A'
                }
            })
            .then(function(response){
                //Log response to console
                console.log(response);
                
                //set lat and lng equal to results data for lat and lng
                var lat = response.data.results[0].geometry.location.lat;
                var lng = response.data.results[0].geometry.location.lng;
                
                
              ?php echo $lat = ?> lat;
              ?php echo $lng = ?> lng;  
            })
            .catch(function(error){
                console.log(error);
            }); 
        }
        

    </script>  */


    
    


    $sql = "INSERT INTO requests (emailR, f_nameR, phoneR, streetR, cityR, stateR, zipR, squareFeetR, proposedPriceR, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
        
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'There was a SQL error. Please try again. Back to sign up <a href="signup.html">page</a>';
        exit(); 
            
    } else {                 
        
        mysqli_stmt_bind_param($stmt, "sssssssssss", $email, $f_name, $phoneNumber, $street, $city, $state, $zip, $squareFeet, $proposedPrice, $lat, $lng);
        
        mysqli_stmt_execute($stmt);
        
        echo " Insert executed. Back to <a href='index.php'>home page</a>.";
    }

?>


    
            
            
