<?php session_start(); ?>
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
    <title>Cart</title>
</head>
<body>
<!--navbar -->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="index.php"><i class="fas fa-shopping-basket"></i>&nbsp;&nbsp;Online Shopping System</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger ml-1">1</span></a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div style="display:<?php if(isset($_SESSION['alert'])){echo $_SESSION['alert'];}else{echo 'none'; unset($_SESSION['alert']);} ?>" class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?php if (isset($_SESSION['message'])){echo $_SESSION['message']; unset($_SESSION['message']);} ?></strong>
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th colspan="7">
                                <h4 class="text-center text-info m-0">
                                    Products in your cart
                                </h4>
                            </th>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>IMAGE</th>
                            <th>PRODUCT</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL PRICE</th>
                            <th><a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure you want to clear your cart?')"><i class="fas fa-trash"></i>&nbsp;Clear cart</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once 'config.php';
                            $query = "SELECT * FROM cart";

                            $result = mysqli_query($con, $query);
                            if(mysqli_num_rows($result) > 0) {
                                $grand_total = 0;
                                while ($row = mysqli_fetch_assoc($result)) :
                        ?>
                        <tr>
                            <td><b><?= $row['id'] ?></b></td>
                            <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                            <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                            <td><i class="fas fa-dollar-sign"></i>&nbsp<b><?= number_format($row['product_price']) ?></b></td>
                            <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                            <td><b><?= $row['product_name'] ?></b></td>
                            <td><input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width: 75px"></b></td>
                            <td><b><i class="fas fa-dollar-sign"></i>&nbsp<b><?= number_format($row['total_price']) ?></b></td>
                            <td><a href="action.php?remove=<?= $row['id'] ?>"
                                   class="text-danger lead"
                                   onclick="return confirm('Are you sure you want to remove this item from cart?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                                    $grand_total += $row['total_price'];
                                endwhile;          }
                            else {
                                session_destroy();
                                $grand_total = 0;
                                echo '<div class="alert alert-success">
                                  <button type="button" class="close" data-dismiss="alert"></button>
                                  <strong>Your cart is Empty</strong><a href="index.php">&nbsp;&nbsp;Click here to continue Shopping</a>
                                </div>';
                                echo '<style>table{display: none;}</style>';
                            }
                            ?>
                        <tr>
                            <td colspan="3">
                                <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;Continue Shopping</a>
                            </td>
                            <td colspan="2"><b>Grand Total</b></td>
                            <td>
                                <i class="fas fa-dollar-sign"></i>&nbsp<b><?= number_format($grand_total) ?></b>
                            </td>
                            <td>
                                <a href="checkout.php" class="btn btn-info <?= ($grand_total > 1)?"":"disabled" ?>"><i class="fas fa-credit-card"></i>&nbsp;Checkout</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Always load jquery before bootstrap otherwise you will have issues-->
<script src="jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".itemQty").on('change', function() {
            var $el = $(this).closest('tr');

            var pid = $el.find(".pid").val();
            var pprice = $el.find(".pprice").val();
            var qty = $el.find(".itemQty").val();

            $.ajax({
                url: 'action.php',
                method: 'post',
                cache: false,
                data: {qty:qty,pid:pid,pprice:pprice},
                success: function(response) {
                    location.reload();
                    //console.log(response)
                }
            });
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
            });
        }
    })
</script>
</body>
</html>

