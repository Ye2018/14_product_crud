
<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root',''); 
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    // $date = date('Y-m-d H:i:s');

    if(!$title){
        $errors[] = 'Product title is required';
    }
    if(!$price){
        $errors[] = 'Product price is required';
    }
// echo 'title '.$title;
    if(empty($errors)){
        $image = $_FILES['image'] ?: null;
        $imagePath = $product['image'];

        if($image && $image['tmp_name']){
            if($product['image']){
                unlink($product['image']);
            }
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $statement = $pdo -> prepare("UPDATE products SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");

        $statement->bindValue(':title', $title); 
        $statement->bindValue(':image', $imagePath); 
        $statement->bindValue(':description', $description); 
        $statement->bindValue(':price', $price); 
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('LOCATION: index.php');
    }
// Here we use prepare rather than exec, the reason is when exec is used, user my fill in some query to drop the database, which is malicious and not safe.
}

function randomString($n){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++){
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}
// var_dump($_POST);
?>

<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">

    <title>Update Existing Product</title>
  </head>
  <body>

      <p>
          <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
      </p>
      <h1>Update Existing Product <b><?php echo $product['title'] ?></b></h1>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
               <div><?php echo $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <?php if ($product['image']): ?>
            <img src="<?php echo $product['image'] ?>" class="updated-image" alt="">
        <?php endif ?>
        <div class="form-group">
            <label> Product Image </label>
            <br>
            <input type="file" name="image">
        </div>
        <div class="form-group">
            <label> Product Title </label>
            <input type="text" name = 'title' class="form-control" value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
            <label> Product Description </label>
            <textarea type="text" class="form-control" name="description" <?php echo $description; ?>></textarea>
        </div>
        <div class="form-group">
            <label> Product Price </label>
            <input type="number" step='0.01' name="price" value="<?php echo $price; ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">UPDATE</button>
    </form>
  </body>
</html>
