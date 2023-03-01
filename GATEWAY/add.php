<?php
    require 'config.php';

    $msg = '';
    define('MAXSIZE',1000000);
    const ALLOWED_EXTENSIONS = array('jpeg','png','jpg');
    define('DIR','image/');

    if (isset($_POST['submit'])) {
        $pName = $_POST['pName'];
        $pPrice = $_POST['pPrice'];

        $pImage = $_FILES['pImage']['name'];
        $tmp_file = $_FILES['pImage']['tmp_name'];
        $image_size = $_FILES['pImage']['size'];

        $targetFile = DIR.basename($pImage);

        $extension = strtolower(end(explode('.', $_FILES['pImage']['name'])));

        if (in_array($extension,ALLOWED_EXTENSIONS) && $image_size <= MAXSIZE) {

            if (move_uploaded_file($tmp_file, $targetFile)) {
                $query = "INSERT INTO products(product_name,product_price,product_image)
                        VALUES('$pName','$pPrice','$targetFile')";

                if (mysqli_query($con, $query)) {
                    $msg = "Product Added successfully";
                }
                else {
                    die(mysqli_error($con));
                    $msg = "Failed to Add product";
                }
            }
            else {
                echo "Error";
            }
        }
        else {
            $msg = "The Image format/extension is not allowed";
        }
    }

    mysqli_close($con);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <title>Add Product Information</title>
</head>
<body class="bg-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light mt-5 rounded">
                <h2 class="text-center p-2">Add Product Information</h2>
                <form action="" method="post" class="p-2" enctype="multipart/form-data" id="form-box">
                    <div class="form-group">
                        <input type="text" name="pName" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="pPrice" class="form-control" placeholder="Product Price" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="pImage" class="custom-file-input" id="customFile" required>
                            <label for="customFile" class="custom-file-label">Choose Product Image</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-danger btn-block" value="Add">
                    </div>
                    <div class="form-group">
                        <h4 class="text-center"><?= $msg ?></h4>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 mt-3 p-4 bg-light rounded">
                <a href="index.php" class="btn btn-warning btn-block btn-lg">Go to Products Page</a>
            </div>
        </div>
    </div>
<script src="../jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>
