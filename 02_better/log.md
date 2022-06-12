# Useful tools & Important Concepts

## Docblock

A DocBlock is a piece of documentation in your source code that informs you what the function of a certain class, method or other Structural Element is. Here is the [link](https://docs.phpdoc.org/guide/getting-started/what-is-a-docblock.html) provides more information.

## Framework

To develope a real big project, it is good to use framework like [lavarel, symphony， codeigniter](https://kinsta.com/blog/php-frameworks/) or [cms](https://devrims.com/blog/best-php-cms-platforms/).

Very often, there is a public folder in the morden framework, so that the browser can get access to this folder. It is a good practice to do so, since we don't want the browser has the ability to reach all the files.

## Virtual Host

A virtual host can run more than one website at a time. Configure it properly, and you'll have one machine that can load two, three, or more websites. The reason is virtual hosts isolate and independently manage multiple sets of resources on the same physical machine. Resources associated with one virtual host **cannot** share data with resources associated with another virtual host.

Before we step into virtual host, Let us try to start a local host, which can be built according to the following command:

```bash
php -S localhost: 8080
```

This command is used within the directory of ~/php-crash-course-2020/14_product_crud/02_better/public. After that, we can see from the browser with the url "localhost:8080/products", all the system we have established up to now.

In the newly established localhost, we need to change path of *css* files and *images* so that they can be included in current system. To this end, we need to modify the header.php file contained in /view/partial. The line

```php
<link rel="stylesheet" href="app.css">
```

should be changed into

```php
<link rel="stylesheet" href="/app.css">
```

The "/" is to include the absolute path, this symbol will take us back to domain, then we can start from there to figure out the location of the css file. Same thing happens on the images. We need to copy the images folder under the path of ~/php-crash-course-2020/14_product_crud/02_better/public, then we need to add a '/' at corresponding position where the images are mentioned, such as Line 10 in the file form.php in the views/products folder:

```php
<img src="/<?php echo $product['image'] ?>" class="updated-image" alt="">
```

## Extra comments on the better version

Even if the codes have been refactored and better organized, the current practice is still not the optimized. The reason is, in order to realize a functionality, we have to create a new file to do this. Eventually, that will lead to tons of such files which are very hard to maintain.

## Useful tips

The magic constant:

```php
__DIR__
```

gives us the current directory where that file is located. This is used in the validat_product.php Ln 16.
