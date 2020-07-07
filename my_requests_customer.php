<!--PHP session must be started on each page.-->
<?php
    session_start();  
    if(!isset($_SESSION['userID'])){
        header("Location: login-customer.php");
    }

?>

<!--PHP to connect to database and pull customer's requests information for the table below.-->
<?php
    include_once('connection.php');

    $userEmail = $_SESSION['userEmail'];
    $query="SELECT * FROM request JOIN request_status ON request.status = request_status.id WHERE (email = '$userEmail') AND (request.status IN (1,2))";

    $result=mysqli_query($conn, $query);
    $row = mysqli_num_rows($result); 
?>

<!doctype html>
<!--my_requests_customer.php file for Jon's Snow Removal Page-->
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
        
        <!--message below is displayed when user has no open requests-->
        <p id="message" display="none">You have no open requests to display at this time.</p>
        
        <!--initialize arrays-->
        <script> 
            var bidsReceivedArray = []; 
            var requestStatusArray = []; 
        </script>  <!--end of script initializing arrays-->
        
        <!--table-->
        <table class="table-format" id="table">
            <tr>
                <th>No.</th>
                <th>Street Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Bids Received</th>
                <th>Status</th>
                <th>Cancel Request</th>
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
                  
                    <!--PHP to retreieve the number of bids recieved-->
                    <?php 
                        $requestID = $rows['idRequests'];
                    ?>
                    
                    <script>console.log(<?php echo $requestID ?>); </script>
                    
                    <?php
                        $queryBids = "SELECT COUNT(*) AS total FROM bid WHERE (request_id = '$requestID') AND (status=1)";
                    
                        /*$queryBids = "SELECT COUNT(*) AS total, bid_id, provider_ID, estimated_completion_date, estimated_completion_time, cost, status FROM bid WHERE (request_id = '$requestID') AND (status=1)";*/
                    
                        $resultBids=mysqli_query($conn, $queryBids);  //run query
                        $rowBids = mysqli_fetch_assoc($resultBids);  //fetch results
                        $total = $rowBids['total'];  //total number of results
                    ?>
                
                    <!--Setting the value of the id for the anchor tag to the value of 'bidsReceieved' + $i.  This value will be inserted into the bidsReceieved array and $i will be incremented by one at the bottom of the loop. A script will run at the bottom of the page to iterate over the array-->  
                    <td><a id="bidsReceived<?php echo $i ?>" href="bids_per_request_customer.php?requestID=<?php echo $requestID ?>"><?php echo $total ?></a></td>

                    <!--Insert "push" each value of i into the bids receieved array-->
                    <script> bidsReceivedArray.push("bidsReceived<?php echo $i ?>"); </script>
                    <script>console.log(<?php echo $row_count ?>); </script>
                    
                    <!--Setting the value of the id tag equal to 'status' + $i. This value will be inserted into the requestStatus array and $i will be incremented by one at the bottom of the loop. A script will run at the bottom of the page to iterate over the array.-->

                    <td><a id="status<?php echo $i ?>" href="accepted-bid.php?requestID=<?php echo $requestID ?>" title="View Accepted Bid Information"><?php echo $rows['status']; ?></a></td>

                    <script> requestStatusArray.push("status<?php echo $i ?>")</script>

                    <!--Cancel Request-->
                    <td>
                        <select id="<?php echo $requestID ?>" onchange="deleteRequest(this.id)">
                            <option></option>
                            <option>Cancel</option>
                        </select>
                    </td>
 
                </tr>
            
                <?php 
                    $i++;
                }  //end of while loop
                
            }  //end of if statement

          ?>
              
        </table>
        
        <!--First function will run when the page is loaded. If the user does not have any requests, the script will hide the table and display a message. Second function will remove the HREF attribute from the 'Bids Receieved' column if the bid count is zero. Third function will remove the HREF attribute from the 'Status' column if the status is 'Bids Requested'. Fourth function is called when the user selects 'Cancel' from the dropdown.-->
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
            
            bidsReceivedArray.forEach(function(id){
                //Set bidcount equal to text content of ID
                var bidCount = document.getElementById(id).textContent;
                
                //If bidcount is zero, remove the HREF attribute
                if(bidCount == 0){
                    document.getElementById(id).removeAttribute("href");
                } 
            });
            
            requestStatusArray.forEach(function(id){
               var status = document.getElementById(id).textContent;
                if((status == "Bids Requested") || (status == "Work Complete")){
                    document.getElementById(id).removeAttribute("href");
                }
            });
            
            /*If the user selects 'Cancel', this function will delete the request from the request table.*/
            function deleteRequest(requestID){

                $.ajax({
                        type: "POST",
                        url: 'cancelRequest.php',  //where the request will be sent
                        data : { requestID : requestID},   //Data sent to the server. 
                        success: function(data)   //This function is called if the request succeeds

                        {
                            alert("Your request has been cancelled.");
                            location.reload(true);
                            /*var table = document.getElementsByClassName("table-format");
                            table.refresh();*/

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