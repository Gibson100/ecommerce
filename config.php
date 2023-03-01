<?php
    $con = mysqli_connect('localhost','root','','shoppingcart');
    if (!$con) {
        die('connection failed '. mysqli_connect_error());
    }


