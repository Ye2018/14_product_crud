<?php
// two ways to make a database connection. One is mysqli, the other is pdo
// pdo support multiple databases and OOP
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root',''); // the third paramter is password. For windows, it is empty
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// When there is error in the connection, just throw the exception.

// $search = $_GET['search'] ?: '';
if(!empty($_GET['search'])){
    $search = $_GET['search'];
}else{
    $search = '';
}
if ($search){
    $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC'); 
    $statement -> bindValue(':title', "%$search%");
}else{
    $statement = $pdo -> prepare('SELECT * FROM products ORDER BY create_date DESC');  // exec is anotther option, but it is recommended in making some changes in the databases kema.
}

$statement -> execute();
$products = $statement -> fetchAll(PDO::FETCH_ASSOC); // each record inside the table to be fetched in an associated array
// var_dump($products);
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

    <title>Product Crud!</title>
  </head>
  <body>
    <h1>Products CRUD</h1>
    <p>
        <a href="create.php" class="btn btn-success">Create Product</a>
    </p>

    <form action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $search ?>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
            </div>
        </div>
    </form>

    <table class="table">
    <tbody>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</Title></th>
            <th scope="col">Price</th>
            <th scope="col">Create Date</th>
            <th scope="col">Action</th> <!--Put edit or delete button-->
          </tr>
        </thead>
        <?php foreach ($products as $i => $product):  ?> <!-- set up two php tags so that we can write html in between-->
            <tr> 
             <th scope="row"><?php echo $i + 1 ?></th>
             <td>
                 <img src="<?php echo $product['image'] ?>" class="thumb-image">
             </td>
             <td>><?php echo $product['title'] ?></td>
             <td>><?php echo $product['price'] ?></td>
             <td>><?php echo $product['create_date'] ?></td>
             <td>
                <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a> 
                <!-- we use $product['id'] to tell which item should be 
                deleted or updated -->
                <form style="display: inline-block;" action="delete.php" method="post"> 
                <!--Use display: inline-block to avoid the two buttons to stack together-->
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    <!--Here Delet is designed as a button with the type of submit. Whenever this button
                        is clicked, the value of hidden input will be submitted to the form. In this form
                        action delet.php will be executed with the method post. That's why we need to 
                        include this button in a form with a hidden input above it.
                    -->
                </form>
             </td>
            </tr>
        <?php endforeach ?>
        <!--
            we can also use  <?php //foreach ($products as $product) { ?>

            <!php } ?>
        -->
    </tbody>
</table>
  </body>
</html>