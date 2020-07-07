<!--PHP session must be started on each page.-->
<?php
    session_start();
?>

<!doctype html>
<!--edit-profile-provider.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?> 
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Sign up form-->
        <form action="update-provider-profile.php" method="post" style="border:1px solid #ccc">
            
            <!--start container div-->
            <div class="container">
                
                <div class="row">
                <div class="col">
                
                <h1>Edit Provider Profile</h1>
                <p>Please edit the fields below that you would like to update. (Email address is non-editable.)</p>
                <hr>
                    
                </div>  <!--end col-->
                </div>  <!--end row-->
                
                <div class="row">
                <div class="col-md-8">  
                
                <label for="c_name"><b>Company Name</b></label>
                <input type="text" value="<?php echo $_SESSION['welcome_name']; ?>" name="c_name" required>
                
                <br>
                <label for="c_street"><b>Street Address</b></label>
                <input type="text" value="<?php echo $_SESSION['street_address']; ?>" name="c_street" required>
                    
                <br>
                <label for="c_city"><b>City</b></label>
                <input type="text" value="<?php echo $_SESSION['city']; ?>" name="c_city" required> 
                    
                <br>
                <label for="c_state"><b>State</b></label>
                <select id="c_state" name="c_state">
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
                <label for="c_zip"><b>Zip Code</b></label>
                <input type="text" value="<?php echo $_SESSION['zip']; ?>" name="c_zip" required>
                                    
                <br>
                <label for="c_email"><b>Company Email</b></label>
                <input type="text" value="<?php echo $_SESSION['userEmail']; ?>" name="c_email" required readonly>
                    
                <br>
                <label for="c_phone"><b>Company Number</b></label>
                <input type="tel" value="<?php echo $_SESSION['phone']; ?>" name="c_phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>
                
                <br>
                <label for="f_name"><b>Owner First Name</b></label>
                <input type="text" value="<?php echo $_SESSION['f_name']; ?>" name="f_name" required>
                
                <br>
                <label for="l_name"><b>Owner Last Name</b></label>
                <input type="text" value="<?php echo $_SESSION['l_name']; ?>" name="l_name" required>
                

                <div class="clearfix">
                    <button type="button" name="update-cancel-profile" class="cancelbtn">Cancel</button>
                    <button type="submit" name="update-provider-profile" class="signupbtn">Update</button>
                </div>  
                    
                <p>To change your password, click <a href="edit-provider-pw.php" style="color:dodgerblue">here</a>.</p>
                    
                </div>  <!--end col-->
                
            </div>  <!--end row-->
            
            </div>  <!--end container div-->
            
        </form>  <!--end form-->
        
        <!--If parameters have been passed to the URL, this script will alert users the appropriate message.-->
        <script>
            $(document).ready(function(){
                var queryString = window.location.search;  //get query string from search 
                var urlParams = new URLSearchParams(queryString); //set variable equal to url search parameters
                var message = urlParams.get('message');  //return message variable  
                if(message === 'passwordUpdated'){
                    alert("Your password has been updated.");
                } 

            });  //end function
        </script>
        
    </main>
    
    <!-- Footer -->
    <?php include('footer.php'); ?>
    
    <script>
        $( document ).ready(function() {
            $("#c_state").val("<?php echo $_SESSION['state']; ?>" );
        });
    </script>
    
</body>

</html>