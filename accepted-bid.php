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
<!--accepted-bid.php file for Jon's Snow Removal Page-->
<html lang="en">
    
<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Class and JavaScript for weather widget-->
        <a class="weatherwidget-io" href="https://forecast7.com/en/38d88n94d82/olathe/?unit=us" data-label_1="OLATHE" data-label_2="WEATHER" data-theme="original" >OLATHE WEATHER</a>
        
        <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js'); 
        </script>  
        
        <!--End weather widget-->
        
        <!--Query to select accepted bid-->
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
        
        <!--Display request information in a table/box-->
        <div id="request-table">
            <h2>Request Information</h2>
            <h5>Street: <?php echo $row['street']; ?> </h5>
            <h5>City: <?php echo $row['city']; ?></h5>
            <h5>State and Zip: <?php echo $row['state']; ?> <?php echo $row['zip']; ?></h5>
            <h5>Requested Completion Date: <?php echo $row['requested_completion_date']; ?></h5>
        </div>
        
        <!--Display the accepted bid information in a table-->
        <table class="table-format">
            <tr>    
                <th colspan="5" class="tableHeader">Accepted Bid</th>
            </tr>
            
            <tbody class="tableBody">
                <tr>
                    <th>No.</th>
                    <th>Company</th>
                    <th>Bid Amount</th>
                    <th>Est. Completion Date</th>
                    <th>Est. Completion Time</th>
                </tr>

                <script> var bidIDArray = []; </script>
          
                <!--PHP to connect to database and pull the accepted bid information for the table.-->
                <?php
                    $query="SELECT * FROM bid JOIN provider ON bid.provider_ID = provider.idProviders JOIN est_service_time ON bid.estimated_completion_time = est_service_time.id_service_time WHERE request_id = '$requestID' AND status=2";
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
                    </tr>
                <?php 
                    $i++;
                    }

                ?>
            </tbody>
              
          </table>  <!--end table-->
        
        <p>Back to 'My Requests' <a href="my_requests_customer.php">page</a>.</p>
        
    </main>
        
    <!--include footer.php-->
    <?php include('footer.php');?>

    
</body>  <!--end body-->
    
</html> <!--end html-->