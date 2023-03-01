<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <title>Shopping</title>
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="#">Shopping Cart</a>

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
    <?php
        require 'config.php';

        $sql = "SELECT * FROM products";
        $result = mysqli_query($con,$sql);
    ?>
    <div class="container">
        <div class="row">
            <?php
                while ($row = mysqli_fetch_array($result)) :
            ?>
            <div class="col-lg-3 col-md-3 col-sm-6 my-3 my-md-0 b-2">
                <div class="card-deck mt-1">
                    <div class="card border-info p-2">
                        <img src="<?= $row['product_image'] ?>" class="img-fluid card-img-top" height="150px">
                        <h5 class="cart-title text-center"><?= $row['product_name']?></h5>
                        <h3 class="text-center">$<?= number_format($row['product_price'])?></h3>
                        <a href="order.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-block btn-lg">Buy</a>
                    </div>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>

<script src="../jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>
