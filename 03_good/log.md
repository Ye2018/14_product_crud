# Userful tools and important concepts

## Composer

Compose is a tool for dependency manager for PHP. It can be downloaded from this [link](https://getcomposer.org/download/).

After composer is correctly installed, we need to use bash terminal to enter the directory we want to manage, and

Step1: input the command to generate composer.json:

```bash
composer init
```

The composer.json I generated is like:

```json
{
    "name": "ye/03_good",
    "autoload": {
        "psr-4": {
            "Ye\\03Good\\": "src/",
            "app\\":"./"
        }
    },
    "authors": [
        {
            "name": "myName",
            "email": "myName@sampleemail.com"
        }
    ],
    "require": {}
}

```

In this file, we need to specify **psr-4**, which is a community standard relating to class autoloading. By doing so, we can map namespace to physical directoyr structures. This can effectively help us to remove the *require\*/include\** keywords in our project.
