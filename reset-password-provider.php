<?php
    
    if(isset($_POST["reset-password-submit"])){
        require ("connection.php");
        
        $selector = $_POST['selector'];
        $validator = $_POST['validator'];
        
        $password = $_POST['psw'];
        $passwordRepeat = $_POST['psw-repeat']; 
    
        if(empty($password) || empty($passwordRepeat)){
            echo "One of the password fields was left empty! Please try again.";
            exit();
        } else if($password != $passwordRepeat){
             echo "The passwords did not match! Please try again.";
             exit();
        }
        
        $currentDate = date("U");
        
        $sql = "SELECT * FROM pwdresetprovider WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "There was an error in the SQL prepare statement!";
            exit();
            
        } else{
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            
            if(!$row = mysqli_fetch_assoc($result)){
                echo "You need to re-submit your reset request.";
                exit();
                
            } else {
                $tokenBin = hex2Bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
                
                if($tokenCheck === false){
                    echo "You need to re-submit your reset request.";
                    exit();
                    
                } else if($tokenCheck === true){
                    
                    $tokenEmail = $row['pwdResetEmail'];
                    
                    $sql = "SELECT * FROM provider WHERE email=?;";
                    $stmt = mysqli_stmt_init($conn);
        
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "There was an error in the SQL prepare statement while checking for your email!";
                        exit();
            
                    } else{
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        if(!$row = mysqli_fetch_assoc($result)){
                            echo "There was an error while fetching the results to ensure your email existed!";
                            exit();
                            
                        } else{
                            
                            $sql = "UPDATE provider SET password=? WHERE email=?";
                            $stmt = mysqli_stmt_init($conn);
        
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                echo "There was an error while preparing the SQL statement to update your password!";
                                exit();
            
                            } else{
                                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                
                                $sql = "DELETE FROM pwdResetProvider WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($conn);
                            
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    echo "There was an error while preparing the SQL statement to delete the password reset email from the database!";
                                    exit();
                                } else{
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    
                                    header("Location: login-provider.php?newpwd=passwordupdated"); 
                                }
                                
                            }
                            
                        }
                    }
                }
            }
        } 
        
        
    }



?> 