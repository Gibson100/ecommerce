<?php
session_start();
require 'config.php';
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pcode = $_POST['pcode'];
    $pqty = 1;

    $sql = "SELECT 'product_code' FROM cart WHERE product_code='$pcode' LIMIT 1 ";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result) < 1) {
        $query = "INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES(
                '$pname','$pprice','$pimage',$pqty,'$pprice','$pcode'
                )";
        mysqli_query($con, $query) or die(mysqli_error($con));

        echo "<div class='alert alert-success alert-dismissible mt-2'>
                      <span type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></span>
                      <strong>Success!</strong> Item added to your cart
                    </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible mt-2'>
                      <span type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></span>
                      <strong>Failed!</strong> Item already added to your cart
                    </div>";
    }
}
//get what is in the cart table
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart-item') {
    $query = "SELECT * FROM cart";
    $result = mysqli_query($con,$query);
    mysqli_store_result($con);
    echo mysqli_num_rows($result);
}
//remove from cart

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    $del_query = "DELETE FROM cart WHERE id=$id";
    if(mysqli_query($con, $del_query)) {
        $_SESSION['alert'] = 'block';
        $_SESSION['message'] = 'Item removed from cart';
        header('location:cart.php');
    }
}

//remove all items from cart table

if (isset($_GET['clear'])) {
    $delete_all = "DELETE FROM cart";
    if(mysqli_query($con, $delete_all)){
        session_destroy();
        header('location:cart.php');
    }
}

if (isset($_POST['qty'])) {
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $total_price = $qty*$pprice;

    if($qty < 1){
       return;
    }
    else {
        $query = "UPDATE cart SET qty='$qty', total_price='$total_price' WHERE id='$pid'";

        mysqli_query($con, $query);
    }
}

if(isset($_POST['action']) && isset($_POST['action']) == 'order'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $grand_total = $_POST['grand_total'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];

    $data = '';

    $query = "INSERT INTO orders(name,email,phone,address,pmode,products,amount_payed)
                VALUES('$name','$email','$phone','$address','$pmode','$products','$grand_total')";

    if (mysqli_query($con,$query)) {
        $data .= '<div class="text-center">
                    <h1 class="display-4 mt-2 text-danger">Thank You for shopping with us!</h1>
                    <h2 class="text-success">Your order is Placed Successfully</h2>
                    <h4 class="bg-danger text-light rounded p-2">Items Purchased : '.$products.'</h4>
                    <h4>Your name : '.$name.'</h4>
                    <h4>Your email : '.$email.'</h4>
                    <h4>Your phone : '.$phone.'</h4>
                    <h4>Your Total Amount Paid : $'.number_format($grand_total).'</h4>
                    <h4>Payment Mode : '.$pmode.'</h4>
                    </div>';
        echo $data;
    }
    else{

        echo 'Order Failed';
    }
}

