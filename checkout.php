<?php
    require_once 'config.php';

    $grand_total = 0;
    $allItems = '';
    $items = array();

    $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price
    FROM cart";

    $result  = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $grand_total += $row['total_price'];
        $items[] = $row['ItemQty'];

    }
    $allItems = implode(",",$items);
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--    bootstrap library-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <title>Online Shopping System</title>
</head>
<body>
<!--navbar -->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php"><i class="fas fa-shopping-basket"></i>Checkout</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger ml-1"></span></a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 px-4 pb-4" id="order">
            <h4 class="text-center text-info p-2">Complete your order</h4>
            <div class="jumbotron p-3 mb-2 text-center">
                <h6 class="lead"><b>Product(s) : <?= $allItems ?></b></h6>
                <h6 class="lead"><b>Delivery Charge </b>Free</h6>
                <h5><b>Total Amount Payable : $<?=number_format($grand_total)?></b></h5>
            </div>
            <form action="" method="post" id="placeOrder">
                <input type="hidden" name="products" value="<?=$allItems?>">
                <input type="hidden" name="grand_total" value="<?=$grand_total?>">
                <div class="form-group">
                    <input type="text" name="name" class="form-control"
                    placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control"
                           placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control"
                           placeholder="Enter phone" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="address" id="" rows="3" cols="10" placeholder="Enter your delivery address" required></textarea>
                </div>
                <h6 class="text-center lead"><b>Select Payment Mode<b></b></h6>
                <div class="form-group">
                    <select name="pmode" class="form-control">
                        <option value="" selected disabled>Select payment mode</option>
                        <option value="cod">Cash on delivery</option>
                        <option value="netbanking">Net Banking</option>
                        <option value="cards">Debit/Credit card</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
                </div>
            </form>
        </div>
    </div>
</div>

<!--Always load jquery before bootstrap otherwise you will have issues-->
<script src="jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#placeOrder").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'action.php',
                method: 'post',
                data: $('form').serialize()+"&action=order",
                success: function(response) {
                    $("#order").html(response);
                }
            })
        });

        load_cart_item_number();
        function load_cart_item_number() {
            $.ajax({
                url: 'action.php',
                method: 'get',
                data: {cartItem:"cart_item"},
                success: function(response) {
                    $("#cart-item").html(response);
                }
            })
        }
    });
</script>
</body>
</html>
