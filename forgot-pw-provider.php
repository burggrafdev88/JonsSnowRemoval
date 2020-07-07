<!doctype html>
<!--forgot-pw-provider.php file for Jon's Snow Removal Page-->
<!--The provider fills out the form below and the information is then passed to the reset-request-provider page for processing.-->  
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--login form-->
        <form action="reset-request-provider.php" method="post">
        
           <!--start container div-->
           <div class="container">
               
                <h1>Reset Provider Password</h1>
                <p>An email will be sent to you with instructions on how to reset your password.</p>
                
                <label for="email"><b>Provider Email</b></label>
                <input type="text" placeholder="Enter Your Email Address " name="email" required>
                
                <br>               
                <div class="clearfix">
                    <button type="submit" name="reset-request-submit" class="submitbtn">Request Password</button>
                </div> 
               
            </div>  <!--end container div-->
        </form>  <!--end form-->
        
        <?php 
            if(isset($_GET["reset"])){
                if($_GET["reset"] == "success"){
                    echo '<p>Check your email!</p>';
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