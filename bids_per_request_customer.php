<!--PHP session must be started on each page.-->
<?php
    session_start();  
    if(!isset($_SESSION['userID'])){
        header("Location: login-customer.php");
    }

    require('connection.php');
    $requestID = $_GET["requestID"];
?>

<!doctype html>
<!--bids_per_request_customer.php file for Jon's Snow Removal Page-->
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
        
        <?php 
            if($stmt = $conn -> prepare ("SELECT * FROM request WHERE idRequests=?")){
            
            /*Bind parameters*/
            $stmt->bind_param("s", $requestID);
            $stmt->execute();
            $result = $stmt -> get_result();  //get the mysqli result
            $row = $result -> fetch_assoc();  //fetch data
        
            } else {
                echo 'There was a SQL error. Please try again. Back to submit bid <a href="my_requests_customer.php">page</a>';
                exit(); 
            }
        ?>
        
        <h1>Request Information</h1>
        <h5>Street: <?php echo $row['street']; ?> </h5>
        <h5>City: <?php echo $row['city']; ?></h5>
        <h5>State and Zip: <?php echo $row['state']; ?> <?php echo $row['zip']; ?></h5>
        <h5>Requested Completion Date: <?php echo $row['requested_completion_date']; ?></h5>
        
        <p id="bidAccepted" style="display: none">The provider has been notified that you have accepted their bid! If the anticipated completion date or time changes, the provider will notify you via phone or email. Back to My Requests <a href="my_requests_customer.php">page</a>.</p>
        
        <table class="table-format">
            <tr>    
                <th colspan="6" class="tableHeader">Bids</th>
            </tr>
            
            <tbody class="table-format">
                <tr>
                    <th>No.</th>
                    <th>Company</th>
                    <th>Bid</th>
                    <th>Est. Completion Date</th>
                    <th>Est. Completion Time</th>
                    <th class="bidSubmitted">Accept/Decline</th>
                </tr>

        <script> var bidIDArray = []; </script>
          
          <!--PHP to connect to database and pull customer's requests information for the table below.-->
          <?php
              $query="SELECT * FROM bid JOIN provider ON bid.provider_ID = provider.idProviders JOIN est_service_time ON bid.estimated_completion_time = est_service_time.id_service_time WHERE request_id = '$requestID' AND status=1";
              $result=mysqli_query($conn, $query);

                  $i = 1;
                  while($rows=mysqli_fetch_assoc($result))
                  {
            ?>  
              <tr>
                <td><?php echo $i ?></td>                
                <td><?php echo $rows['company']; ?></td>
                <td>$<?php echo $rows['cost']; ?></td>
                <td><?php echo $rows['estimated_completion_date']; ?></td>
                <td><?php echo $rows['service_time']; ?></td>
                <td class="bidSubmitted">
                    <select id="<?php echo $rows['bid_id']; ?>" onchange="updateTables(this.id)">        
                        <option value=""></option>
                        <option value="Accept">Accept</option>
                        <option value="Decline">Decline</option>
                    </select>  
                </td>
               
              <!--Insert "push" each bid ID into the bidIDArray-->
              <script> bidIDArray.push(<?php echo $rows['bid_id']; ?>); </script>
              </tr>
          <?php 
                $i++;
              }
              
          ?>
            </tbody>
              
          </table>
        
    
    <script>
        function updateTables(bidIDSelected){
            
            /*If the user selects "Accept"*/
            if(document.getElementById(bidIDSelected).value === "Accept"){
                
                /*Get the accepted bid ID by it's element ID*/
                $acceptedBidID = document.getElementById(bidIDSelected).id;
                
                /*Remove the accepted bidID from the array.  The remaining array will contain the bidIDs that were not accepted.*/
                bidIDArray = arrayRemove(bidIDArray, bidIDSelected);
                
                $('#bidAccepted').show();
                $('.bidSubmitted').hide();
                $('.table-format').hide(); 
               
                /*Make an AJAX call - pass the accepted bid ID and the remaining bids in the array to the function*/
                ajaxBidAccepted($acceptedBidID, bidIDArray);
                                
            } else if(document.getElementById(bidIDSelected).value === "Decline"){
                
                /*Get the declined bid ID by it's element ID*/
                $declinedBidID = document.getElementById(bidIDSelected).id;
                
                /*Make an AJAX call - pass the declined bid ID to the function*/
                ajaxBidDeclined($declinedBidID);
            }
            
            
            /*Loop over each bid element in the array, if value of element equals "Accept", remove this element from the array. Execute a sql query to send the bid information to a "commit" table.  Notify the provider their bid has been accepted. The commit information should be sent to the Providers "my commitments" page. Update the user status to "Awaiting Service". The awaiting service should contain a link to the winning bid. Customer's Bids should then be moved to 0.*/  
            
            
        }
        
        /*If user accepts "Accept" on one of the bids, this function will remove the selected bid from the array of bidIds.*/
        function arrayRemove(arr, value){
            return arr.filter(function(ele){ return ele != value; });
        
        }
        
        
    </script>
        
    <script>
        /*The function below will make an AJAX call to update the status of the accepted and declined bids in their respective table.*/
        function ajaxBidAccepted(acceptedBidID){
             
             $.ajax({
                    type: "POST",
                    url: 'update-accepted-declined-bids.php',
                    data : { acceptedBid : acceptedBidID, declinedBids: bidIDArray},
                    success: function(data)
                    {
                        console.log(data);
                    }, 
                 
                    error: function (e) {
                        console.log("Unsuccessful:", e);
                    }
                });
            
        }
        
        /*The function below will make an AJAX call to update the declined bid in its respective table.*/
        function ajaxBidDeclined(declinedBidID){
             
             $.ajax({
                    type: "POST",
                    url: 'update-declined-bids.php',
                    data : { declinedBid : declinedBidID},
                    success: function(data)
                    {
                        alert("Your response has been submitted to the provider.");
                        console.log(data);
                        location.reload(true);
                    }, 
                 
                    error: function (e) {
                        console.log("Unsuccessful:", e);
                    }
                });
            
        }
        
    </script>
        
    </main>
        
    <!--include footer.php-->
    <?php include('footer.php'); ?>

    
</body>  <!--end body-->
    
</html> <!--end html-->