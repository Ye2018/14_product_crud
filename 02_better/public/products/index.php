<?php

// $pdo = require_once "database.php"; we can use this on the condition in database.php, $pdo is returned

/** @var $pdo \PDO */
require_once "../../database.php";

// $search = $_GET['search'] ?: '';
if(!empty($_GET['search'])){
    $search = $_GET['search'];
}else{
    $search = '';
}
if ($search){
    $statement = $pdo -> prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC'); 
    $statement -> bindValue(':title', "%$search%");
}else{
    $statement = $pdo -> prepare('SELECT * FROM products ORDER BY create_date DESC');  // exec is anotther option, but it is recommended in making some changes in the databases kema.
}

$statement -> execute();
$products = $statement -> fetchAll(PDO::FETCH_ASSOC); // each record inside the table to be fetched in an associated array
// var_dump($products);
?>
<?php include_once '../../view/partials/header.php' ?>

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
                 <img src="/<?php echo $product['image'] ?>" class="thumb-image">
             </td>
             <td>><?php echo $product['title'] ?></td>
             <td>><?php echo $product['price'] ?></td>
             <td>><?php echo $product['create_date'] ?></td>
             <td>
                <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                <form style="display: inline-block;" action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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