<?php
    $con = mysqli_connect('localhost','root','','shopping');

    if (!$con) {
        die('Failed to connect to the database : '.mysqli_connect_error());
    }