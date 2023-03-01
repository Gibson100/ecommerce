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
    <a class="navbar-brand" href="index.php"><i class="fas fa-shopping-basket"></i>&nbsp;&nbsp;Online Shopping System</a>

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
    <div id="message"></div>
    <div class="row mt-2 pb-3 justify-content-center">
        <?php
            include 'config.php';
            $result = mysqli_query($con,'SELECT * FROM product');
            if (!mysqli_num_rows($result) > 0) {
                die(mysqli_error($con));
            }
            while ($row = mysqli_fetch_assoc($result)) :
        ?>
        <div class="col-lg-3 col-md-3 col-sm-6 my-3 my-md-0 b-2">
            <div class="card-deck">
                <div class="card p-2 border-secondary mb-2">
                    <img src="<?= $row['product_image'] ?>" class="img-fluid card-img-top" height="150px" alt=<?= $row['product_name'] ?>></img>
                    <div class="card-body p-1">
                        <h4 class="card-title text-center text-info">
                            <?=$row['product_name'] ?>
                        </h4>
                        <h5 class="card-text text-center"><i class="fas fa-dollar-sign"></i>
                            <?= number_format($row['product_price']) ?>
                        </h5>
                    </div>
                    <div class="card-footer p-1">
                        <!-- create a form to fetch data -->
                        <form action="" class="form-submit">
                            <input type="hidden" class="pid" value="<?= $row['id']?>">
                            <input type="hidden" class="pname" value="<?= $row['product_name']?>">
                            <input type="hidden" class="pprice" value="<?= $row['product_price']?>">
                            <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                            <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">

                            <button type="submit" class="btn btn-info btn-block addItem"><i class="fas fa-cart-plus"></i>&nbsp;Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!--Always load jquery before bootstrap otherwise you will have issues-->
<script src="jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".addItem").click(function (e) {
            e.preventDefault();

            var $form = $(this).closest(".form-submit");
            var pid = $form.find(".pid").val();
            var pname = $form.find(".pname").val();
            var pprice = $form.find(".pprice").val();
            var pimage = $form.find(".pimage").val();
            var pcode = $form.find(".pcode").val();

            $.ajax({
                url: 'action.php',
                method: 'post',
                data: {pid: pid, pname: pname, pprice: pprice, pimage: pimage, pcode: pcode},
                success: function (response) {
                    load_cart_item_number();
                    $("#message").html(response);
                    $("#message").fadeTo(2000, 500).slideUp(600, function () {
                        $("#message").slideUp(600);
                        window.scrollTo(0,0);
                    });
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
                })
            }
    });
</script>
</body>
</html>
