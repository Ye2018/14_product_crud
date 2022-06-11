
<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root',''); // the third paramter is password. For windows, it is empty
//Super Globals $_COOKIE, $_SESSION, $_SERVER, $_GET, $_FILES, $_POST, $_ENV etc. 
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$price = '';
$description = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){ // To check is the current is POST or not
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    if(!$title){  // title is a mandatory value, if it dosen't exist, it is an error
        $errors[] = 'Product title is required';
    }
    if(!$price){
        $errors[] = 'Product price is required';
    }
// echo 'title '.$title;
    if(empty($errors)){
        $image = $_FILES['image'] ?: null; // check if the image file exists.
        $imagePath = '';
        if($image && $image['tmp_name']){ // only use the condition $image is NOT enough, because even if
            // there is no image uploaded, we can still see array related to $image. For this reason, 
            // we need to go down further to check if there is a non-empty "tmp_name".
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        // The snipet of code above is to generate a unique directory for the images so that each images  
        // will have unique path to store. By doing so, even if two images have the same name, the new one 
        // will NOT overwrite the old one.
        // exit;

        //The following block of codes are to send the data to the database
        $statement = $pdo -> prepare("INSERT INTO products (title, image, description, price, create_date)
                    VALUES(:title, :image, :description, :price, :date)");
                // VALUE('$title', '', '$description', $price, '$date')");
        $statement->bindValue(':title', $title); 
        $statement->bindValue(':image', $imagePath); 
        $statement->bindValue(':description', $description); 
        $statement->bindValue(':price', $price); 
        $statement->bindValue(':date', $date); 
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">

    <title>Create New Product</title>
  </head>
  <body>
    <h1>Create New Product</h1>

    <?php if(!empty($errors)): ?> <!--This line means only when $errors array is NOT empy, we 
    will show the conent of div below-->
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
               <div><?php echo $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <!--Here for the method, we use 'post' rather than 'get'. 
        The reason is, when 'get' is used, the information to be sent will be 
        shown in url, which is not secure. The displayed information will be like
        "image=&title=&description=&price=", which is called query string. The query string
        appears when each of the input was given a "name" such as name = "image", etc.
        Using enctype attribute like this, we can upload files, like an imaage of a cell phone.
        -->
        <!--
            The attribute enctype="multipart/form-data" is telling the form, I am ganna submit files
        -->
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </body>
</html>