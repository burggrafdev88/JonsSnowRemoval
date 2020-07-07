<!--PHP session must be started on each page.-->
<?php
    session_start();
?>

<!doctype html>
<!--edit-profile-customer.php file for Jon's Snow Removal Page-->
<html lang="en">

<!--include header.php-->
<?php include('header.php'); ?> 
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Sign up form-->
        <form action="update-customer-profile.php" method="post" style="border:1px solid #ccc">
            
            <!--start container div-->
            <div class="container">
                
                <div class="row">
                <div class="col">
                
                <h1>Edit Customer Profile</h1>
                <p>Please edit the fields below that you would like to update. (Email address is non-editable.)</p>
                <hr>
                    
                </div>  <!--end col-->
                </div>  <!--end row-->
                
                <div class="row">
                <div class="col-md-8">  
                
                <label for="f_name"><b>First Name</b></label>
                <input type="text" value="<?php echo $_SESSION['f_name']; ?>" name="f_name" required>
                
                <br>
                <label for="l_name"><b>Last Name</b></label>
                <input type="text" value="<?php echo $_SESSION['l_name']; ?>" name="l_name" required>
                
                <br>
                <label for="email"><b>Email</b></label>
                <input type="text" value="<?php echo $_SESSION['userEmail']; ?>" name="email" required readonly>
                
                <br>
                <label for="phone"><b>Mobile Number</b></label>
                <input type="tel" value="<?php echo $_SESSION['phone']; ?>" name="phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required>

                <div class="clearfix">
                    <button type="button" name="update-cancel-profile" class="cancelbtn">Cancel</button>
                    <button type="submit" name="update-customer-profile" class="signupbtn">Update</button>
                </div>  
                    
                <p>To change your password, click <a href="edit-customer-pw.php" style="color:dodgerblue">here</a>.</p>
                    
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
    
</body>

</html>