<!--PHP session must be started on each page.-->
<?php
    session_start();
?>

<!doctype html>
<!--signup-provider.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?> 
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Sign up form-->
        <form action="addsignupdata-provider.php" method="post" style="border:1px solid #ccc">
            
            <!--start container div-->
            <div class="container">
                
                <div class="row">
                <div class="col">
                
                <h1>Sign Up As a Provider</h1>
                <p>Please fill in this form to create a provider account.</p>
                <hr>
                    
                </div>  <!--end col-->
                </div>  <!--end row-->
                
                <div class="row">
                <div class="col-md-8">  
                    
                <label for="c_name"><b>Company Name</b></label>
                <input type="text" placeholder="Enter Company Name" name="c_name" required>
                
                <br>
                <label for="c_street"><b>Street Address</b></label>
                <input type="text" placeholder="Enter Street Address" name="c_street" required>
                    
                <br>
                <label for="c_city"><b>City</b></label>
                <input type="text" placeholder="Enter City" name="c_city" required> 
                    
                <br>
                <label for="c_state"><b>State</b></label>
                <select name="c_state">
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
                <input type="text" placeholder="Enter Zip Code" name="c_zip" required>
                                    
                <br>
                <label for="c_email"><b>Company Email</b></label>
                <input type="text" placeholder="Enter Company Email" name="c_email" required>
                    
                <br>
                <label for="c_phone"><b>Company Number</b></label>
                <input type="tel" placeholder="XXXXXXXXXX" name="c_phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>
                
                <br>
                <label for="f_name"><b>Owner First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="f_name" required>
                
                <br>
                <label for="l_name"><b>Owner Last Name</b></label>
                <input type="text" placeholder="Enter Last Name" name="l_name" required>
                
                <br>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    
                <br>
                <label for="psw-repeat"><b>Confirm Password</b></label>
                <input type="password" placeholder="Repeat Password" id="psw2" name="psw-repeat" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

                <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                <div class="clearfix">
                    <button type="button" name="signup-cancel" class="cancelbtn">Cancel</button>
                    <button type="submit" name="signup-submit-provider" class="signupbtn">Sign Up</button>
                </div>  
                    
                </div>  <!--end col-->
                
                <div class = "col-md-4">
            
                    <div id="message">
                        <h5>Password must contain the following:</h5>
                        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                        <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                        <p id="number" class="invalid">A <b>number</b></p>
                        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                    </div>   


                    <div id="pwMustMatch">
                        <h3 id="pwMustMatchMessage">Passwords must match.</h3>
                    </div>   
                    
                </div>  <!--end col-->
                
            </div>  <!--end row-->
            
            </div>  <!--end container div-->
        </form>  <!--end form-->
        
    <!--JavaScript to validate password requirements-->
    <script>
        var myInput = document.getElementById("psw");
        console.log(myInput);
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        
        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
            console.log("Function is getting called.");
        }
        
        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        }
        
        // When the user starts to type something inside the password field
        myInput.onkeyup = function() { 
            console.log("On key up is getting called.");
            
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }
            
            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }
            
            // Validate numbers
            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }
            
            // Validate length
            if(myInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }   
        }
        
        var myInput2 = document.getElementById("psw2");
        
        // When the user clicks on the confirm password field, show the message box
        myInput2.onfocus = function() {
            document.getElementById("pwMustMatch").style.display = "block";
            console.log("Function is getting called.");
        }
        
        // When the user clicks outside of the password field, hide the message box
        myInput2.onblur = function() {
            document.getElementById("pwMustMatch").style.display = "none";
        }
        
        
        // When the user starts to type something inside the repeat password field
        myInput2.onkeyup = function() { 
            console.log("My input2 on key up is getting called.");
            
            // Validate lowercase letters
            var password1 = document.getElementById("psw").value;
            var password2 = document.getElementById("psw2").value;
            var pw = document.getElementById("pwMustMatchMessage");
            
            console.log(password1);
            console.log(password2);
            console.log(pw);
            
            if(password1 == password2) {
                pw.classList.remove("invalid");
                pw.classList.add("valid");
                console.log("Password matching is being called.");
            } else {
                pw.classList.remove("valid");
                pw.classList.add("invalid");
                console.log("Password NOT matching is being called.");
            }
            
        }
        
    </script>  <!--end script to validate password requirements-->
        

    </main>
    
    <!-- Footer -->
    <?php include('footer.php'); ?>
    
</body>

</html>