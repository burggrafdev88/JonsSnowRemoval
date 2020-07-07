<?php

require('connection.php');

$sql = "UPDATE user SET password=? WHERE email=?";
$stmt = mysqli_stmt_init($conn);

$password = 'Aa111111';
var_dump($password);
$email = 'burggrafdev88@gmail.com';
$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
var_dump($hashedPwd);

echo $hashedPwd;

mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $email);
mysqli_stmt_execute($stmt);

        
?>