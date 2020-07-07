<!--PHP session must be started on each page.-->
<?php
    session_start();
    if(!isset($_SESSION['providerID'])){
        header("Location: login-provider.php");
    }
?>

<!doctype html>
<!--view-requests.php file for Jon's Snow Removal Page-->
<html lang="en">
    
    <!--Custom header for Google Map's Page-->
    <head>
        <title>Jon's Snow Removal</title>
        
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <!--Bootstrap style sheet-->
        <link rel="stylesheet" href="styles2.css">
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    </head>  

    
<body>
    
    <!--include navigation.php-->
    <?php include('navigation.php'); ?>
    
    <main>
        
         <!--script will run on page load. If a parameter is passed through the url, the script will display the appproprite message-->
        <script>
            $(document).ready(function(){
                var queryString = window.location.search;  //get query string from search 
                var urlParams = new URLSearchParams(queryString); //set variable equal to url search parameters
                var message = urlParams.get('message');  //return message variable  
                if(message === 'bidSubmitted'){
                    alert("Your bid has been submitted.");
                } 
            });  //end function
        
        </script>
        
        <div id="map"></div>
        
        <!--script for google maps-->
        <script>
            function initMap(){
                //Define location for company headquarters
                var lat = <?php echo $_SESSION['lat'] ?>;
                var lng = <?php echo $_SESSION['lng'] ?>;
                var companyHQ = {lat: lat, lng: lng};
                
                //Create map and set location
                var map = new google.maps.Map(document.getElementById('map'), {
                center: companyHQ, zoom: 11});
                            
                //Declare and initialize new google maps info window
                var infoWindow = new google.maps.InfoWindow;
                
                //Create map marker for company HQ
                var pointHQ = new google.maps.LatLng(lat, lng);
                var image = 'http://maps.google.com/mapfiles/kml/pal2/icon10.png';
                var markerHQ = new google.maps.Marker({
                    map: map,
                    position: pointHQ,
                    icon: image
                }); 
                
                //Create a new element containing content, this content will be placed in the infoWindow variable
                var infowincontentHQ = document.createElement('div');
                                    
                /*Declare and initialize company name variable. Create a new strong element that is bold and append it to 
                the infocontent window.*/
                var nameHQ = `<?php echo $_SESSION['welcome_name'] ?>`
                var strongHQ = document.createElement('strongHQ');
                    strongHQ.textContent = nameHQ
                    infowincontentHQ.appendChild(strongHQ);
                
                //When user clicks, display the content in the infoWindow
                markerHQ.addListener('click', function() {
                    infoWindow.setContent(infowincontentHQ);
                    infoWindow.open(map, markerHQ);
                });
                
                //Call outputxml.php file, if received, execute function
                downloadUrl('http://ec2-3-135-62-86.us-east-2.compute.amazonaws.com/outputXML.php', function(data) {   //removed /jonssnow from url for prod env
                    
                    //Set xml variable equal to data.responseXML, which returns an XML document
                    var xml = data.responseXML;
                    
                    //Set markers variable equal to marker elements
                    var markers = xml.documentElement.getElementsByTagName('marker');
                    
                    //Loop through the markers and apply the function 
                    Array.prototype.forEach.call(markers, function(markerElem) {
                        
                        //Initialize variables to the marker element attributes
                        var name = markerElem.getAttribute('name');
                        var email = markerElem.getAttribute('email');
                        
                        //Get address, get requested completion date, concatenate the city, zip, and state
                        var street = markerElem.getAttribute('street');
                        var city = markerElem.getAttribute('city');
                        var state = markerElem.getAttribute('state');
                        var zip = markerElem.getAttribute('zip');
                        var cityAndStateAndZip = city + ', ' + state + ' ' + zip;
                        var requested_completion_date = markerElem.getAttribute('requested_completion_date');
                        var requestId = markerElem.getAttribute('requestId');
                        
                        //Position of the marker
                        var point = new google.maps.LatLng(
                            parseFloat(markerElem.getAttribute('lat')),
                            parseFloat(markerElem.getAttribute('lng')));
                        
                        //Create a new element containing content, this content will be placed in the infoWindow variable
                        var infowincontent = document.createElement('div');
                        
                        //Create a new element that is bold, add children for the name
                        var strong = document.createElement('strong');
                            strong.textContent = name
                            infowincontent.appendChild(strong);
                            infowincontent.appendChild(document.createElement('br'));
                        
                        /*  **Commented this out for now - I may not want to share the email with the users**
                        //Create a new text element, add the email
                        var text = document.createElement('text');
                            text.textContent = email
                            infowincontent.appendChild(text);
                            infowincontent.appendChild(document.createElement('br')); */
                        
                        //Create a new text element, add the street
                        var text2 = document.createElement('text');
                            text2.textContent = street
                            infowincontent.appendChild(text2);
                            infowincontent.appendChild(document.createElement('br'));
                        
                        //Create a new text element, add the city and state
                        var text3 = document.createElement('text');
                            text3.textContent = cityAndStateAndZip
                            infowincontent.appendChild(text3);
                            infowincontent.appendChild(document.createElement('br'));
                        
                        //Create a new text element, add the date to it
                        var text4 = document.createElement('text');
                            text4.textContent = 'Complete By: ' + requested_completion_date
                            infowincontent.appendChild(text4);
                            infowincontent.appendChild(document.createElement('br'));
                        
                        var anchor = document.createElement('a');
                        var link = document.createTextNode("View Photos and Submit Bid");
                        anchor.appendChild(link);
                        anchor.title = "View Customer Photos and Submit Bid";
                        anchor.href = "http://ec2-3-135-62-86.us-east-2.compute.amazonaws.com/submit-bid.php?name="+name+"&street="+street+"&city="+city+"&state="+state+"&zip="+zip+"&date="+requested_completion_date+"&requestId="+requestId;
                        
                        infowincontent.appendChild(anchor);
                        
                        //var icon = customLabel[type] || {};
                        
                        //Create marker for each element
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                           // label: icon.label
                        });
                        
                        //When user clicks, display the content in the infoWindow
                        marker.addListener('click', function() {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });
                        
                    });  //end of for each call for Array.prototype
                    
                });  //end of downloadURL function data
                
            }  //end initmap
      
        //Pass a url and a function to call on success
        function downloadUrl(url, callback) {
            
            //If truthy, execute ActiveXObject, otherwise execute XMLHttpRequest
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            //set up handling of the state change, we only want the 4th
            request.onreadystatechange = function() {

              if (request.readyState == 4) { //request done
                request.onreadystatechange = doNothing;  // removed this anonymous function on 4th state (done)
                callback(request, request.status);   // call the supplied function with result

              }  //end if statement

            };  //end on ready state change function

            request.open('GET', url, true);  // now initialize
            request.send(null);  // now execute
            
      }  //end download URL function

      function doNothing() {}  
            
        </script>
        
        <!--Load the API from the specified URL
            * The async attribute allows the browser to render the page while the API loads
            * The callback parameter executes the initMap() function
        -->
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpasZnCrZDvcAjyWcoeBcVqqo5Yfzd05A&callback=initMap">
        </script> 

    </main>
    
    <!-- Footer -->
    <?php include('footer.php'); ?>
    
</body>

</html>