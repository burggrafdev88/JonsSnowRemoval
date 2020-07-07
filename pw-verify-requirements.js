//JavaScript to validate password requirements
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
        
    </script>