# Applications for registration and authorization

Configure URL rewriting on your web server (Example for Apache):

    Create in you `public` directory `.htaccess` file containing this code:
    ```
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule .* index.php [L]
    ```