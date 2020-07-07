<!--PHP session must be started on each page.-->
<?php
    session_start();
?>

<!doctype html>
<!--login-provider.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--login form-->
        <form action="login_script_provider.php" method="post">
        
           <!--start container div-->
           <div class="container">
               
                <h1>Provider Log In</h1>
                <hr>

                <label for="c_email"><b>Provider Email</b></label>
                <input type="text" placeholder="Enter Email" name="c_email" required>
                
                <br>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
               
                <p><a href="forgot-pw-provider.php">Forgot your password?</a></p>

                <div class="clearfix">
                    <button type="button" class="cancelbtn">Cancel</button>
                    <button type="submit" name="login-submit-provider" class="loginbtn">Log In</button>
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