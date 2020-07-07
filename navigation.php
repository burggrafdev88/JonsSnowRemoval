<!--navigation.php for Jon's snow removal--> 

<!--Navbar class expand small-->
    <nav class = "navbar sticky-top navbar-expand-sm">
        
        <!--Anchor tag for site brand-->
        <a class="navbar-brand" href="index.php">Jon's Snow Removal</a>
        
        <!--button class for hamburger icon-->
        <button class="navbar-toggler" data-toggle="collapse" data-target="#hamburgermenu">
            <span class="navbar-toggler-icon">
                <!--defined in my css file-->
            </span>
        </button>

        <!--Collapsable navbar-->
        <div class="collapse navbar-collapse" id="hamburgermenu">
            <ul class="navbar-nav">
                <li class="nav-item dropdown" id="login">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="login-customer.php">As Customer</a>
                        <a class="dropdown-item" href="login-provider.php">As Provider</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown" id="signup">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sign Up</a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="signup-customer.php">As Customer</a>
                        <a class="dropdown-item" href="signup-provider.php">As Provider</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown" id="customer-portal">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Customer Portal</a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="request-service.php">Request Service</a>
                        <a class="dropdown-item" href="my_requests_customer.php">My Open Requests</a>
                        <a class="dropdown-item" href="my_completed_requests_customer.php">My Completed Requests</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown" id="provider-portal">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Provider Portal</a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="view-requests.php">View Requests</a>
                        <a class="dropdown-item" href="view_my_bids.php">My Bids</a>
                        <a class="dropdown-item" href="view_my_commitments.php">My Commitments</a>
                        <a class="dropdown-item" href="view_my_completed_work.php">My Completed Work</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown" id="account-customer">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="edit-profile-customer.php">Edit Profile</a>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </li>
                
                <li class="nav-item dropdown" id="account-provider">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="edit-profile-provider.php">Edit Profile</a>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </li>
                
            </ul>
        </div> <!--End collapsable navbar-->
        
        <!--Slogan on right side of navbar, only shows when not logged in-->
        <span id="gurantee-message" class="navbar-text">
            FAST | CONVENIENT | 100% SATISFACTION GUARANTEE
        </span>   
        
        <!--welcome message on right side of navbar, only shows when user is logged in-->
        <span id="welcome-message" class = "navbar-text">
            Welcome, <?php echo $_SESSION['welcome_name'] ?>!
        </span>
    
    
    </nav>  <!--end of navbar class small-->

<!--php script to show/hide links and navbar-text classes based on whether or not the user is logged in-->
<?php
            if(isset($_SESSION['userID'])){
        ?>      <script type="text/javascript">document.getElementById('login').style.display = 'none';</script>
                <script type="text/javascript">document.getElementById('signup').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('gurantee-message').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('provider-portal').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('account-provider').style.display = 'none';</script> 
        <?php
            } else if(isset($_SESSION['providerID'])) {
        ?>      <script type="text/javascript">document.getElementById('login').style.display = 'none';</script>
                <script type="text/javascript">document.getElementById('signup').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('gurantee-message').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('customer-portal').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('account-customer').style.display = 'none';</script> 
        
        <?php
            } else{
        ?>      <script type="text/javascript">document.getElementById('account-customer').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('account-provider').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('customer-portal').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('provider-portal').style.display = 'none';</script> 
                <script type="text/javascript">document.getElementById('welcome-message').style.display = 'none';</script>
        <?php
            }
?>     