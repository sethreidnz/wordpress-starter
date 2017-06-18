# WordPress Starter Kit

This project was created as a starting point for building a WordPress site ready to be deployed to an Azure Web App with In-App MySQL
and with continuous deployment in mind. It uses [Composer](https://getcomposer.org/) to manage
the WordPress core files, plugins and themes.

You can create a add your own environment specific database configuration files so if you wanted
to run it locally or a full fledged MySQL instance in the future.

[Click here](http://wordpress-starter.azurewebsites.net/) to see an example running on the free tier Azure Web App.

**Prerequisites:**

- [Setup a WordPress development environment](https://developer.wordpress.org/themes/getting-started/setting-up-a-development-environment/)
- Install [Composer](https://getcomposer.org) (PHP package manager)

## Quick Start - Azure

This starter kit is optimized to work out of the box with the [MySQL in app](https://blogs.msdn.microsoft.com/appserviceteam/2016/08/18/announcing-mysql-in-app-preview-for-web-apps/) feature of Azure Web Apps. The easiest way to get started with this project is to fork it and deploy it straight to azure.

> **NOTE:** You will need an azure account. [Get one here](https://azure.microsoft.com/free/)

1. Fork the repository in GitHub

1. Click on the this button to deploy the resources:

    [![Deploy to Azure](http://azuredeploy.net/deploybutton.svg)](https://azuredeploy.net/)

1. Complete the fields (note that the appName must be **globally unique** to azure).

1. At the end of the dialog click on **Manage your resources** to open the resource group created in Azure

1. Click on the App Service within that resource group to open its settings blade

1. From the left menu click on **Deployment options**

1. Click on **Configure required settings**

1. Choose GitHub and choose the forked wordpress-starter repository you created earlier

1. Wait for this to complete

1. Click on the **Deployment options** menu item again. If it is not already syncing automatically click **sync**

1. From the left menu click on **Overview**

1. Copy the **URL** of the app service to your clipboard

1. Visit the URL but add '/wp' on the end. For example: http://wordpress-starter.azurewebsites.net/wp

    >**NOTE:** This is because WordPress is installed in a sub-folder. We will fix the URL in the following steps

1. Go through the usual WordPress setup steps

1. Log into your new site

1. From the admin screen in the left menu click on the menu Settings->General

1. In the text box **Site Address (URL)** and remove the '/wp' from the end

You are done! Now you can make changes to your github repo and this will be reflected in your life site! To make 
full use of this you really need a local environment though. See the [quick start for that](#quick-start-local)

## Quick Start - Local

> **Note:** This guide assumes you have a LAMP, WAMP or MAMP stack already setup and understand the basics of configuring this

It is fairly straightforward to get this project up and running locally provided you have the pre-requisites complete. The configuration
in terms of the Apache Virtual Host setup vary between platforms so I have given only the conguration details not detailed steps. Some good guides for each platform are as follows:

- [WAMP](https://john-dugan.com/wamp-vhost-setup)
- TODO Add Linux
- TODO Add Mac

>**NOTE:** If you have any good guides on Linux and Mac please submit and issue or PR!

1. Clone the repository into a folder on your computer

1. Add an Apache virtual host to point to the directory. 

    The configuration I use is the following:

    ```
    <VirtualHost *:80>
        ServerName my-website.local
        DocumentRoot C:/dev/mywebsite
        <Directory  "C:/dev/mywebsite">
                Options +Indexes +Includes +FollowSymLinks +MultiViews
                AllowOverride All
                Require local
            </Directory>
    </VirtualHost>
    ```

1. Add WP_ENV environment variable

    You will need to add the WP_ENV environment with the directive **SetEnv WP_ENV local** inside the `<VirtualHost></VirtualHost>` definition.

    For example:

    ```
    <VirtualHost *:80>
        ServerName mywebsite.local
        DocumentRoot C:/dev/mywebsite
        SetEnv WP_ENV local
            <Directory  "C:/dev/mywebsite">
                Options +Indexes +Includes +FollowSymLinks +MultiViews
                AllowOverride All
                Require local
            </Directory>
    </VirtualHost>
    ```

    >**NOTE:** This value could be anything it just must match the wp-config file created in a later step

1. Update your windows hosts file to have an entry for your website e.g.

    127.0.0.1 mywebsite.local

1. Install the PHP dependencies with composer:

    ```bash
    composer install
    ```

1. Create a MySQL database user with a username and a password

1. Make a copy of the file 'wp-config.local-sample.php' and rename it to 'wp-config.local.php'

1. Fill out the database details in the 'wp-config.local.php' file

## Roadmap

- [ ] More comprehensive documentation
- [ ] Companion blog(s)
- [ ] Add sample theme using Webpack 
- [ ] Add sample plugin