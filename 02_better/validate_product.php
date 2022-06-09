<?php

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = '';
    // $date = date('Y-m-d H:i:s');

    if(!$title){
        $errors[] = 'Product title is required';
    }
    if(!$price){
        $errors[] = 'Product price is required';
    }
// echo 'title '.$title;
    if(!is_dir(__DIR__.'/public/images')){ // Use __DIR__ to point to the current directory
        mkdir(__DIR__.'/public/images');  // Since the validate_product.php will be executed by a file located in different directory. Using relative directory will lead to some problmes.
    }

    if(empty($errors)){
        $image = $_FILES['image'] ?: null;
        $imagePath = $product['image'];

        if($image && $image['tmp_name']){
            if($product['image']){
                unlink(__DIR__.'/public/'.$product['image']);
            }
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname(__DIR__.'/public/'.$imagePath));
            move_uploaded_file($image['tmp_name'], __DIR__.'/public/'.$imagePath);
        }

    }
// Here we use prepare rather than exec, the reason is when exec is used, user may fill in some query to drop the database, which is malicious and not safe.

