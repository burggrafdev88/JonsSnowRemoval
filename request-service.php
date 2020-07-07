<!--PHP session must be started on each page.-->
<?php
    session_start();
      if(!isset($_SESSION['userID'])){
        header("Location: login-customer.php");
    }
?>

<!doctype html>
<!--request-service.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?> 
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Sign up form-->
        <form action="addrequest.php" method="post" style="border:1px solid #ccc" enctype="multipart/form-data">
            
            <!--start container div-->
            <div class="container">
                <h1>Request Service</h1>
                <p>Fill in the form below to request service.</p>
                <hr>
                
                <br>
                <label for="email">Email</label>
                <input type="text" name="email" value="<?php echo $_SESSION['userEmail']; ?>" readonly>
                
                <br>
                <label for="f_name">First Name</label>
                <input type="text" name="f_name" value="<?php echo $_SESSION['f_name']; ?>" readonly>
                
                <br>
                <label for="phone">Mobile Number</label>
                <input type="tel" name="phone" value="<?php echo $_SESSION['phone']; ?>" readonly>
                
                <br>
                <label for="address">Street Address</label>
                <input type="text" placeholder="Enter Street Address" name="address" required>
                
                <br>
                <label for="city">City</label>
                <input type="text" placeholder="Enter City" name="city" required>
                
                <br>
                <label for="state">State</label>
                <select name="state">
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>	            
                
                <br>
                <label for="zip">Zip Code</label>
                <input type="text" placeholder="Enter Zip Code" name="zip" required>
                
                <br>
                <label for="completion_date">Requested Completion Date</label>
                <input id="datepicker" type="date" name="completion_date" required>
                
                <!--Image upload-->
                <br>
                <label for="file">Upload Images</label>
                <input type="file" name="file[]" id="image" accept="image/jpg, image/gif, image/jpeg, image/png" required multiple>
                
                <!--Submit / cancel buttons-->
                <br>
                <div class="clearfix">
                    <button type="button" name="signup-cancel" class="cancelbtn">Cancel</button>
                    <button type="submit" name="service-submit" class="submitbtn">Submit</button>
                </div>  

            </div>  <!--end container div-->

        </form>  <!--end form-->
        
        <!--Script to restrict the number of files a user can upload.-->
        <script>
            var limit = 5;  //maximum number of pictures allowed
            $(document).ready(function(){
                $('#image').change(function(){
                    var files = $(this)[0].files;
                    if(files.length > limit){
                        alert("You can select max "+limit+" images.");
                        $('#image').val('');
                        return false;
                    }else{
                        return true;
                    }
                });
            });  //end script
        </script>

    </main>
    
    <!-- Footer -->
    <?php include('footer.php'); ?>
    
</body>

</html>