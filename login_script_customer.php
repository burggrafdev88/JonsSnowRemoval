<!--php script to log users in-->

<?php
    
   //If we don't access this page by hitting the submit button, display an error message and terminate the script.
    if(!isset($_POST['login-submit-customer'])){
        echo " Error: There is nothing in the POST. Back to login <a href='login-customer.php'>page</a>.";
        exit();
    }

    require("connection.php");

    $mailuid    = $_POST['email'];
    $password   = $_POST['psw'];

    if(empty($mailuid) || empty($password)){
        echo 'There was an error. Back to login <a href="login_script_customer.php">page</a>';
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE email=?;";
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo 'There was an sql error. Back to login <a href="login-customer.php">page</a>';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if($row = mysqli_fetch_assoc($result)){
                
                $pwdCheck = password_verify($password, $row['password']); 
                echo var_dump($pwdCheck);
                
                if($pwdCheck == false){
                    echo 'Incorrect password. Back to login <a href="login-customer.php">page</a>';
                    exit();
                    
                } else if ($pwdCheck == true) {
                    session_start();
                    /*Do I need to create a session varilable for each piece of user data in the table (e.g., f_name,
                    l_name, etc.)? */
                    $_SESSION['userID'] = $row['idUsers'];
                    $_SESSION['userEmail'] = $row['email'];
                    $_SESSION['welcome_name'] = $row['first_name'];
                    $_SESSION['f_name'] = $row['first_name'];
                    $_SESSION['l_name'] = $row['last_name'];
                    $_SESSION['phone'] = $row['phone'];
                    
                    header("Location:index.php?login=success");   //text env:  ../jonssnow/
                    exit();
                } else {
                    echo 'There was an error. Back to login <a href="login-customer.php">page</a>';
                    exit();
                }
            } else {
                echo 'Email address not found. Back to login <a href="login-customer.php">page</a>';
                exit();
            }
        }
    }