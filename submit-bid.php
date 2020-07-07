<!--PHP session must be started on each page.-->
<?php
    session_start();  
    if(!isset($_SESSION['providerID'])){
        header("Location: login-provider.php");
    }

?>

<!--PHP to connect to database and set up sql query in order to populate drop down lists below-->
<?php
    include_once('connection.php');
    $requestID = $_GET['requestId'];
    $query="SELECT * FROM est_service_time";
    $result=mysqli_query($conn, $query);
?>

<!doctype html>
<!--submit-bid.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?> 
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--start container div-->
        <div class="container">
                
            <div class="row">
                <!--column for html form-->
                <div class="col"> 

                    <!--Sign up form-->

                    <!--The form below contains prepopulated information for the service-request.  These values are prepopulated 
                    using the values passed from the URL.  The information is pulled from the URL using the JavaScript towards the bottom.There are also several hidden fields in the form - these are used to link the bid to the appropriate provider.-->
                    <form action="addbid.php" method="post">

                        <h1>Submit Bid</h1>
                        <p>Fill in the form below to submit your bid.</p>
                        <hr>

                        <!--Prepopulated fields filled in by JavaScript below.-->
                        <input type="hidden" name="providerID" value="<?php echo $_SESSION['providerID']?>">
                        <input type="hidden" id="requestId" name="requestId">

                        <label for="customer_name">Customer Name</label>
                        <input id="customer_name" type="text" name="customer_name" readonly>

                        <br>
                        <label for="customer_street">Street</label>
                        <input id="customer_street" type="text" name="customer_street" readonly>

                        <br>
                        <label for="customer_city">City</label>
                        <input id="customer_city" type="text" name="customer_city" readonly>

                        <br>
                        <label for="customer_state">State</label>
                        <input id="customer_state" type="text" name="customer_state" readonly>

                        <br>
                        <label for="customer_zip">Zip</label>
                        <input id="customer_zip" type="text" name="customer_zip" readonly>

                        <br>
                        <label for="requested_completion_date">Requested Completion Date</label>
                        <input id="requested_completion_date" type="text" name="requested_completion_date" required readonly>
                        
                        <!--Fields requiring provider input-->
                        <br>
                        <label for="bid">Proposed Price $</label>
                        <input type="number" min="0.01" step="0.01" pattern="^\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?$" placeholder="Enter Price" name="bid" title="Please enter your proposed price." required>

                        <br>
                        <label for="estimated_completion_date">Estimated Completion Date</label>
                        <input id="estimated_completion_date" type="text" class="datepicker" name="estimated_completion_date" onchange="changeDateFormat(this.value,'formattedEstCompletionDate')" required>
                        <input type="hidden" name="formattedEstCompletionDate" id="formattedEstCompletionDate" value="">

                        <br>
                        <label for="estimated_completion_time">Estimated Time</label>
                        <select name="estimated_completion_time">

                            <?php
                                while($rows=mysqli_fetch_assoc($result))
                                {
                            ?>
                                <option value="<?php echo $rows['id_service_time']; ?>"><?php echo $rows['service_time']; ?></option>
                            <?php 
                                }
                            ?>
                        </select>

                        <div class="clearfix">
                            <button type="button" name="bid-cancel" class="cancelbtn">Cancel</button>
                            <button type="submit" name="bid-submit" class="submitbtn">Submit</button>
                        </div>  

                     </form>  <!--end form-->

                </div>  <!--end column  for html form-->
                
                <!--column for carousel of request images-->
                <div class="col">
                    <h1 class="carousel-property">Pictures of Property</h1>
                    <p>Below are the pictures of the customer's property.</p>
                    <hr>
                    <!--carousel-->
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <!--Initialize the number of indicators in the carousel-->
                        <ol class="carousel-indicators">
                            <?php
                                $sqlCar = "SELECT img_dir FROM request_image WHERE request_id=?";
                                $stmtCar = mysqli_stmt_init($conn);
                            
                                //Prepare statement
                                if(!mysqli_stmt_prepare($stmtCar, $sqlCar)){
                                   echo 'There was an error with your carousel prepared statement. Please try again. Back to view requests <a href="view-requests.php">page</a>';
                                   exit(); 
                                } 
                            
                                mysqli_stmt_bind_param($stmtCar, "i", $requestID);  //bind parameters                    
                                mysqli_stmt_execute($stmtCar);
                                mysqli_stmt_store_result($stmtCar);
                                $count = mysqli_stmt_num_rows($stmtCar);  //number of rows returned by the query
                                
                                $i = 0;
                                while($i < $count){
                                ?>
                            
                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i++ ?>"></li>
                            
                                <?php
                                }
                            
                            ?>  
                        </ol>  <!--end of initializing carousel indicators-->
                        
                        <!--start of carousel inner-->
                        <div class="carousel-inner">
                            <?php
                                $stmt = $conn->prepare("SELECT img_dir FROM request_image WHERE request_id=?");
                                $stmt->bind_param('i', $requestID);
                                $stmt->execute();
                                $stmt->store_result();    
                                $stmt->bind_result($path);  // #args = #cols in SELECT
                                if($stmt->num_rows > 0) {
                                    $j = 0;
                                    while ($stmt->fetch()) 
                                    {
                                ?>
                                
                                    <div class="carousel-item <?php if($j == 0){echo 'active';} ?>">
                                        <img class="d-block w-100" src="request-images/<?php echo $path ?>" alt="First slide">
                                    </div>
                                    
                                <?php
                                    $j++;
                                    } // end of while loop
                                } //end of if statement

                            ?>
                            
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
   
                        </div>  <!--end carousel inner-->

 
                    </div>  <!--end carousel-->
                    
                    
                    
                </div>  <!--end column for carousel-->

            </div>  <!--end row-->
      
        </div>  <!--end container div-->
            
       
        
        <!--Script to pull information from URL and update appropriate form fields.  Script also sets the min and max for the estimated completion date-->
        <script>
            
            //Create url search parameter variable
            var urlParams = new URLSearchParams(window.location.search);
            
            //Pull customer information from URl and set the appropriate form field to this value
            var customer_name = urlParams.get('name');
            document.getElementById("customer_name").value = customer_name;
            
            var customer_street = urlParams.get('street');
            document.getElementById("customer_street").value = customer_street;
            
            var customer_city = urlParams.get('city');
            document.getElementById("customer_city").value = customer_city;
            
            var customer_state = urlParams.get('state');
            document.getElementById('customer_state').value = customer_state;
            
            var customer_zip = urlParams.get('zip');
            document.getElementById('customer_zip').value = customer_zip;
            
            var requested_completion_date = moment(urlParams.get('date')).format('MM/DD/YYYY');
            document.getElementById('requested_completion_date').value = requested_completion_date;
            console.log(document.getElementById('requested_completion_date').value = requested_completion_date);
            
            //Request ID from the request table
            var requestId = urlParams.get('requestId');
            document.getElementById("requestId").value = requestId;
            
            
            $('.datepicker').datepicker({
                startDate: '0',
                endDate: $('#requested_completion_date').val(),
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
            });
            
            $('.datepicker').datepicker("setDate", new Date());
            
            function changeDateFormat(value, hiddenField){
                var formattedEstCompletionDate = moment(value).format('YYYY/MM/DD');
                $('#formattedEstCompletionDate').val(formattedEstCompletionDate);
            }
        </script>

    </main>
    
    <!-- Footer -->
    <?php include('footer.php'); ?>
    
</body>

</html>