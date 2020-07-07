<!doctype html>
<!--create-new-pw-provider.php file for Jon's Snow Removal page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
           <!--start container div-->
           <div class="container">
               
                <?php 
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"];
               
                    if(empty($selector) || empty($validator)){
                        echo "We could not validate your request.";
                    } else{
                        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                ?>
               
                            <div class="row">
                            <div class="col">

                                <h1>Reset Provider Password</h1>
                                <p>Insert your new password below.</p>

                            </div>  <!--end column-->
                            </div>  <!--end row-->
               
                            <div class="row">
                                
                            <div class="col-md-8">
                                
                                <form action="reset-password-provider.php" method="post">
                                    <input type="hidden" name="selector" value="<?php echo $selector ?>"> 
                                    <input type="hidden" name="validator" value="<?php echo $validator ?>"> 

                                    <label for="psw"><b>Password</b></label>
                                    <input type="password" placeholder="Enter Password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

                                    <br>
                                    <label for="psw-repeat"><b>Confirm Password</b></label>
                                    <input type="password" placeholder="Repeat Password" id="psw2" name="psw-repeat" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

                                    <br>
                                    <button type="submit" name="reset-password-submit">Reset Password</button>
                                </form>
                                
                            </div>  <!--end column-->
               
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
                              
                <?php
                        }  //end if statement
                    }  //end else statement
               
                ?>
               
            </div>  <!--end container div-->
        
        <?php 
            if(isset($_GET["reset"])){
                if($_GET["reset"] == "success"){
                    echo '<p class = "signupsuccess">Check your email!</p>';
                }
            }
        ?>

    </main>
    
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
    
    <br>
    <br>
    <br>
    
    <!--include footer.php-->
    <?php include('footer.php'); ?>
    
</body>
    
</html>