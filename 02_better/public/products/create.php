<?php

/** @var $pdo \PDO */
require_once "../../database.php";
require_once "../../function.php";

$errors = [];

$title = '';
$price = '';
$description = '';
$product = [  // This varialbe is not used in create.php. However, in order to resude form.php, we need to 
              // create such a variable to avoid the error like undefined variable.
    'image' => ''
];
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    require_once "../../validate_product.php";

// echo 'title '.$title;
    if(empty($errors)){

        $statement = $pdo -> prepare("INSERT INTO products (title, image, description, price, create_date)
                    VALUES(:title, :image, :description, :price, :date)");
                // VALUE('$title', '', '$description', $price, '$date')");
        $statement->bindValue(':title', $title); 
        $statement->bindValue(':image', $imagePath); 
        $statement->bindValue(':description', $description); 
        $statement->bindValue(':price', $price); 
    // $date = date('Y-m-d H:i:s');
        $statement->bindValue(':date', date('Y-m-d H:i:s')); 
        $statement->execute();
        header('LOCATION: index.php');
    }
// Here we use prepare rather than exec, the reason is when exec is used,
// user my fill in some query to drop the database, which is malicious and not safe.
}

?>
<?php include_once '../../view/partials/header.php' ?>
<p>
    <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
</p>
<h1>Create New Product</h1>

<?php include_once "../../view/products/form.php" ?>
</body>
</html>