# Useful tools

## Bootstrap

It is link is [Home page of Bootstrap](https://getbootstrap.com/).  Bootstrap provides us with a lot of templates for start up our web page. In this project, *table*(color: blue;), *button* and *form* are copied and modified from bootstrap. However, bootstrap has been developed into different versions. The version used in current project is [v4.5](https://getbootstrap.com/docs/4.5/getting-started/introduction/).

If for some reason, css file provided by Bootstrap cannot be linked, we can download the file.

1. Google the CDN and Bootstrap;
2. Go to [the page of CDN](https://www.bootstrapcdn.com/). Please note, we are using v4.5.3. When the video was published, there were some issues with this edition, then it was fixed;

## PDO (PHP Data Objects)

Actually, we have another way of connecting to the database, which is **MySQLi** extension (the "i" stands for improved). We can read more about this topic from [W3SCHOOL](https://www.w3schools.com/php/php_mysql_connect.asp).

Typtical sentences of PDO are:

```php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root',''); // the third paramter is password. 
// For windows, it is empty
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// When there is error in the connection, just throw the exception.

//The following block of codes are to send the data to the database
$statement = $pdo -> prepare("INSERT INTO products (title, image, description, price, create_date)
            VALUES(:title, :image, :description, :price, :date)");
        // VALUE('$title', '', '$description', $price, '$date')"); The reason we don't use exec() rather
        // than prepare() is that the value to be inserted into the database directly is NOT secure. 
        // Some user may insert some SQL commands here to manage the database in the malicious ways.
$statement->bindValue(':title', $title); 
$statement->bindValue(':image', $imagePath); 
$statement->bindValue(':description', $description); 
$statement->bindValue(':price', $price); 
$statement->bindValue(':date', $date); 
$statement->execute();
```
