<?php
error_reporting(E_ALL ^ E_DEPRECATED);
?>
<h1>List of Products</h1>
    <p>
        <a href="/products/create" class="btn btn-success">Create Product</a>
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
                 <?php if ($product['image']): ?>
                 <img src="/<?php echo $product['image'] ?>" class="thumb-image">
                 <?php endif; ?>
             </td>
             <td>><?php echo $product['title'] ?></td>
             <td>><?php echo $product['price'] ?></td>
             <td>><?php echo $product['create_date'] ?></td>
             <td>
                <a href="/products/update?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                <form style="display: inline-block;" action="/products/delete" method="post">
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
