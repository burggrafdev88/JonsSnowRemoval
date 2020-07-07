<!--php script to end session-->

<?php

session_start();

session_unset();

session_destroy();

header("Location:index.php");   //test env:  removed  ../jonssnow/