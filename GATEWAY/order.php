<?php
    require "config.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM products WHERE id=$id";

        $result = mysqli_query($con, $sql);

        $row = mysqli_fetch_array($result);

        $pname = $row['product_name'];
        $pprice = $row['product_price'];
        $del_charge = 5;
        $total_price = $pprice + $del_charge;
        $pimage = $row['product_image'];

    }
    else {
        echo "No product found";
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <title>Complete your order</title>
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php">Shopping Cart</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categories.php">Categories</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5">
                <h4 class="text-center p-2 text-primary">Fill the details to complete the order</h4>
                <h3>Product Details</h3>
                <table class="table table-bordered" width="500px">
                    <tr>
                        <th>Product Name</th>
                        <td><?= $pname ?></td>
                        <td rowspan="4" class="text-center"><img src="<?=$pimage?>" width="200"></td>
                    </tr>
                    <tr>
                        <th>Product Price</th>
                        <td>$<?= number_format($pprice) ?></td>
                    </tr>
                    <tr>
                        <th>Delivery Charge</th>
                        <td>$<?=number_format($del_charge)?></td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>$<?=$total_price ?></td>
                    </tr>
                </table>
                <h4>Enter your details</h4>
                <form action="pay.php" method="post" accept-charset="utf-8">
                    <input type="hidden" name="product_name" value="<?=$pname?>">
                    <input type="hidden" name="product_price" value="<?=$pprice?>">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-danger btn-lg" value="Click to pay : $<?=$total_price?>">
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="../jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>
