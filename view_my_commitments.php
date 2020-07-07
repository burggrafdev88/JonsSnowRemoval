<!--PHP session must be started on each page.-->
<?php
    session_start();  
    if(!isset($_SESSION['providerID'])){
        header("Location: login-provider.php");
    }

?>

<!--php to pull company bids from table-->
<?php
    include_once('connection.php');

    /*$companyName = $_SESSION['welcome_name'];
    $companyName = str_replace("'","\'",$companyName);*/
    $providerID = $_SESSION['providerID'];

    /*This query is used to estbalish how many bids are in the bid table. It will also be used to return information in the bid table*/
    $query="SELECT * FROM bid JOIN request ON bid.request_id = request.idRequests JOIN est_service_time ON bid.estimated_completion_time = est_service_time.id_service_time JOIN bid_status ON bid.status = bid_status.id WHERE (provider_ID = '$providerID') AND (bid.status=2)";

    $result=mysqli_query($conn, $query);

    $row = mysqli_num_rows($result); 
?>

<!doctype html>
<!--my_bids_provider.php file for Jon's Snow Removal Page-->
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
        
        <!--message below is displayed when user has no commitments-->
        <p id="message" display="none">You have no commitments to display at this time.</p>
                
        <table class="table-format" id="table">
            <tr>
                <th>No.</th>
                <th>Customer Name</th>
                <th>Street Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Bid Amount</th>
                <th>Est. Completion Date</th>
                <th>Est. Completion Time</th>
                <th>Status</th>
                <th>Complete</th>
            </tr>
              
          <?php
              $i = 1;
              while($rows=mysqli_fetch_assoc($result))
              {
          ?>  
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $rows['first_name']; ?></td>
                <td><?php echo $rows['street']; ?></td>
                <td><?php echo $rows['city']; ?></td>
                <td><?php echo $rows['state']; ?></td>
                <td><?php echo $rows['zip']; ?></td>                  
                <td>$<?php echo $rows['cost']; ?></td>
                <td><?php echo $rows['estimated_completion_date']; ?></td>
                <td><?php echo $rows['service_time']; ?></td>
                <td><?php echo $rows['status']; ?></td>  
                <td>
                    <select id="<?php echo $rows['bid_id']; ?>" onchange="markComplete(this.id)">
                        <option></option>
                        <option>Yes</option>
                    </select>  
                </td>
              </tr>
          <?php 
                $i++;
              }
              
          ?>
              
          </table>
        
        
          <script>
              
            /*Function below will run when the page loads.  If the provider has no commitments, the function will hide the bid table and display a message.*/
            $(document).ready(function(){
                //Set JS variable to number of rows (commitments) returned by the sql query at the top of the page
                var commitmentCount = <?php echo $row ?>;  
                
                //If commitment count is zero, do not display the table. Instead, display a message.
                if(commitmentCount == 0){
                    document.getElementById("table").style.display = "none";
                    document.getElementById("message").style.display = "block";
                } 
                
            });    
            
            /*If the user selects 'Cancel', this function will delete the request from the request table.*/
            function markComplete(bidID){
                console.log(bidID);

                $.ajax({
                    type: "POST",
                    url: 'markComplete.php',  //where the request will be sent
                    data : { bidID : bidID},   //Data sent to the server. 
                    success: function(data)   //This function is called if the request succeeds

                    {
                        alert("The customer has been notified that this work is complete.");
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