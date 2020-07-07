<!--PHP session must be started on each page.-->
<?php
    session_start();
    if (isset($_SESSION['userID']) || isset($_SESSION['providerID']) ) {
        $loggedIn = 'true';
    }
?>

<!doctype html>
<!--index.php file for Jon's Snow Removal Page-->
<html lang="en">
    
<!--include header.php-->
<?php include('header.php'); ?>
    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
        <!--Weather widget class and JavaScript-->
        <a class="weatherwidget-io" href="https://forecast7.com/en/38d88n94d82/olathe/?unit=us" data-label_1="OLATHE" data-label_2="WEATHER" data-theme="original" >OLATHE WEATHER</a>
        
        <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js'); 
        </script>   
                
        <!--Start carousel div-->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 900px; margin: 0 auto">
            
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            
            <!--Start carousel inner-->
            <div class="carousel-inner">
            
                <div class="carousel-item active">
                    <img class="d-block w-100" src="manShovelSnowNew.jpg" alt="First slide">
                </div>
            
                <div class="carousel-item">
                    <img class="d-block w-100" src="snowblow.jpg" alt="Second slide">
                </div>
            
                <div class="carousel-item">
                    <img class="d-block w-100" src="cleandriveway.jpg" alt="Third slide">
                </div>
                
            </div>  <!--End carousel inner-->
            
            <!--Carousel controls "previous"-->
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            
            <!--Carousel controls "next"-->
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            
        </div>  <!--End carousel div-->
        
        
        <!-- AR - I want to add margin/padding on the left and right. Had trouble with this for some reason -->
        <h2 class="about">About Us</h2> 
        
        <p>Jon's Snow Removal has been providing quality snow removal service to the Olathe area for the last five years. We recently improved access to our service by implementing a web application. Sign up now to request service or to receive a free quote!</p>
        
        <!--If parameters have been passed to the URL, this script will alert users the appropriate message.-->
        <script>
            $(document).ready(function(){
                var status = '<?php echo $loggedIn ?>';
                if(status === 'true'){
                    document.getElementById("carouselExampleIndicators").style.display = "none";
                }
                
            });  //end function
        </script>
        
    </main>
    
    <!--include footer.php-->
    <?php include('footer.php'); ?>

    
</body>  <!--end body-->
    
</html> <!--end html-->