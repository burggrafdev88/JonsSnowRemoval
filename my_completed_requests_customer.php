<!--PHP session must be started on each page.-->
<?php
    session_start();  
    if(!isset($_SESSION['userID'])){
        header("Location: login-customer.php");
    }

?>

<!--PHP to connect to database and pull customer's completed requests information for the table below.-->
<?php
    include_once('connection.php');

    $userEmail = $_SESSION['userEmail'];
    $query= "SELECT request.idRequests, request.street, request.city, request.state, request.zip, request_status.status FROM request JOIN request_status ON request.status = request_status.id WHERE(request.email = '$userEmail') AND (request.status=3)";    //JOIN bid ON request.idRequests = bid.request_id JOIN provider ON bid.provider_ID = provider.idProviders

    $result=mysqli_query($conn, $query);
    $row = mysqli_num_rows($result); 
?>

<!doctype html>
<!--my_completed_requests_customer.php file for Jon's Snow Removal Page-->
<html lang="en">
    
<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Weather widget class and JavaScript-->
        <a class="weatherwidget-io" href="https://forecast7.com/en/38d88n94d82/olathe/?unit=us" data-label_1="OLATHE" data-label_2="WEATHER" data-theme="original" >OLATHE WEATHER</a>
        
        <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js'); 
        </script>  
        
        <!--message below is displayed when user has no completed requests-->
        <p id="message" display="none">You have no completed requests to display at this time.</p>
        
        <!--initialize arrays-->
        <script> 
            var bidsReceivedArray = []; 
            var requestStatusArray = []; 
        </script>  <!--end initializing arrays-->

        <!--table-->
        <table class="table-format" id="table">
            <tr>
                <th>No.</th>
                <th>Street Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Company</th>
                <th>Bid Price</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
              
          <?php
            
            //If result returns true, execute while loop
            if($result){
                
                $i = 1;
                
                //While rows are returned, loop through
                while($rows=mysqli_fetch_assoc($result))
                {
          ?>  
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $rows['street']; ?></td>
                    <td><?php echo $rows['city']; ?></td>
                    <td><?php echo $rows['state']; ?></td>
                    <td><?php echo $rows['zip']; ?></td>
                    
                    <?php
                        $requestID = $rows['idRequests'];
                    
                        $query2= "SELECT provider.company, bid.cost FROM bid JOIN provider ON bid.provider_ID = provider.idProviders WHERE request_id = '$requestID' AND (status NOT IN (5,6))";
                    
                        $result2=mysqli_query($conn, $query2);
                    
                        while($rows2=mysqli_fetch_assoc($result2))
                        {
                    ?>
                            <td><?php echo $rows2['company']; ?></td>
                            <td>$<?php echo $rows2['cost']; ?></td>
                    <?php
                        }  //end while loop for company and cost information
                    ?>
 
                    <td><?php echo $rows['status']; ?></td>

                    <!--Delete Record-->
                    <td>
                        <select id="<?php echo $rows['idRequests']; ?>" onchange="deleteRequest(this.id)">
                            <option></option>
                            <option>Yes</option>
                        </select>
                    </td>
 
                </tr>
            
                <?php 
                    $i++;
                }  //end of while loop
                
            }  //end of if statement

          ?>
              
        </table>
        
        <script> 
            $(document).ready(function(){
                //Set JS variable to number of rows (requests) returned by the sql query at the top of the page
                var requestCount = <?php echo $row ?>;  
                
                //If request count is zero, do not display the table. Instead, display a message.
                if(requestCount == 0){
                    document.getElementById("table").style.display = "none";
                    document.getElementById("message").style.display = "block";
                } 
            });
            
            /*If the user selects 'Yes' from the drop down in the delete column, this function will set the status of the request to 'Inactive'.*/
            function deleteRequest(requestID){
                
                $.ajax({
                        type: "POST",
                        url: 'requestInactive.php',  //where the request will be sent
                        data : { requestID : requestID},   //Data sent to the server. 
                        success: function(data)   //This function is called if the request succeeds

                        {
                            alert(data);
                            location.reload(true);
                        }, 

                        error: function (e) {
                            console.log("Unsuccessful:", e);
                        }
                    });  //end of AJAX call.

            }  //end of function  
            
        </script>  
       
        
    </main>
    
    <!--include footer.php-->
    <?php include('footer.php'); ?>

    
</body>  <!--end body-->
    
</html> <!--end html-->