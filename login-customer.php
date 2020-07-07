<!--PHP session must be started on each page.-->
<?php
    session_start();
?>

<!doctype html>
<!--login-customer.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--login form-->
        <form action="login_script_customer.php" method="post">
        
           <!--start container div-->
           <div class="container">
               
                <h1>Customer Log In</h1>
                <br>

                <label for="email"><b>User Email</b></label>
                <input type="text" placeholder="Enter User Email" name="email" required>
                
                <br>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
               
                <p><a href="forgot-pw-customer.php">Forgot your password?</a></p>
               
                <div class="clearfix">
                    <button type="button" class="cancelbtn">Cancel</button>
                    <button type="submit" name="login-submit-customer" class="loginbtn">Log In</button>
                </div> 
               
            </div>  <!--end container div-->
        </form>  <!--end form-->
        
        <?php
        
        if(isset($_GET["newpwd"])){
            if($_GET["newpwd"] == "passwordupdated"){
                echo '<p class="signupsuccess">Your password has been reset!</p>';
            }
        }
        
        ?>

    </main>
    
    <br>
    <br>
    <br>
    <br>
    <br>
    
    <!--include footer.php-->
    <?php include('footer.php'); ?>
    
</body>
    
</html>