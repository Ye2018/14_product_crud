<?php

/** @var $pdo \PDO */ // This is a docblock, telling us $pdo is and instance of class PDO.
require_once "../../database.php";
require_once '../../function.php';

$id = $_GET['id'] ?: null;

if (!$id){
    header('LOCATION: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

// var_dump($product);
// exit;
$errors = [];

$title = $product['title'];
$price = $product['price'];
$description = $product['description'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    require_once "../../validate_product.php";
// echo 'title '.$title;
    if(empty($errors)){
        // $image = $_FILES['image'] ?: null;
        // $imagePath = $product['image'];

        // if($image && $image['tmp_name']){
        //     if($product['image']){
        //         unlink($product['image']);
        //     }
        //     $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        //     mkdir(dirname($imagePath));
        //     move_uploaded_file($image['tmp_name'], $imagePath);
        // }

        $statement = $pdo -> prepare("UPDATE products SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");

        $statement->bindValue(':title', $title); 
        $statement->bindValue(':image', $imagePath); 
        $statement->bindValue(':description', $description); 
        $statement->bindValue(':price', $price); 
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('LOCATION: index.php');
    }
// Here we use prepare rather than exec, the reason is when exec is used, user may fill in some query to drop the database, which is malicious and not safe.
}


// var_dump($_POST);
?>

<?php include_once '../../view/partials/header.php' ?>

<p>
    <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
</p>
<h1>Update Existing Product <b><?php echo $product['title'] ?></b></h1>

<?php include_once "../../view/products/form.php" ?>

</body>
</html>
