#!/bin/bash

# Define variables
DB_ROOT_PASSWORD="password"
SERVER_IP="127.0.0.1"

# Update package lists
sudo apt-get update

# Install Apache with non-interactive mode
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y apache2 software-properties-common

# Add PHP repositories and install PHP 7.2 and PHP 8.3 and required extensions
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.2-fpm php7.2-mysql php7.2-mbstring php7.2-xml php7.2-gd php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-gd

# Install MariaDB and set root password in a non-interactive way
sudo debconf-set-selections <<< "mariadb-server mysql-server/root_password password $DB_ROOT_PASSWORD"
sudo debconf-set-selections <<< "mariadb-server mysql-server/root_password_again password $DB_ROOT_PASSWORD"
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server

# Secure MariaDB installation
sudo mysql_secure_installation <<EOF

$DB_ROOT_PASSWORD
$DB_ROOT_PASSWORD
y
y
y
y
EOF

# Install phpMyAdmin
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y phpmyadmin

# Configure phpMyAdmin
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin

# Enable PHP 7.2 FPM and PHP 8.3 FPM for Apache
sudo a2enconf php7.2-fpm
sudo a2enconf php8.3-fpm

# Restart Apache
sudo systemctl restart apache2


# Add entries to hosts file for php7.dev and php8.dev
echo "$SERVER_IP php7.dev" | sudo tee -a /etc/hosts
echo "$SERVER_IP php8.dev" | sudo tee -a /etc/hosts

# Create directories for php7.dev and php8.dev
sudo mkdir /var/www/html/server1
sudo mkdir /var/www/html/server2

# Create index.php with phpinfo() in Apache document root for php7.dev (PHP 7.2)
sudo bash -c 'echo "<?php phpinfo(); ?>" > /var/www/html/server1/index.php'

# Create index.php with phpinfo() in Apache document root for php8.dev (PHP 8.3)
sudo bash -c 'echo "<?php phpinfo(); ?>" > /var/www/html/server2/index.php'

# Set permissions for the directories
sudo chown -R www-data:www-data /var/www/html/server1
sudo chown -R www-data:www-data /var/www/html/server2

# Configure virtual host for php7.dev (PHP 7.2)
sudo bash -c 'cat <<EOF > /etc/apache2/sites-available/php7.dev.conf
<VirtualHost *:80>
    ServerAdmin webmaster@php7.dev
    ServerName php7.dev
    DocumentRoot /var/www/html/server1
    <Directory /var/www/html/server1>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php7.2-fpm.sock|fcgi://localhost/"
    </FilesMatch>
    ErrorLog ${APACHE_LOG_DIR}/server1_error.log
    CustomLog ${APACHE_LOG_DIR}/server1_access.log combined
</VirtualHost>
EOF'

# Enable the virtual host for php7.dev
sudo a2ensite php7.dev.conf

# Configure virtual host for php8.dev (PHP 8.3)
sudo bash -c 'cat <<EOF > /etc/apache2/sites-available/php8.dev.conf
<VirtualHost *:80>
    ServerAdmin webmaster@php8.dev
    ServerName php8.dev
    DocumentRoot /var/www/html/server2
    <Directory /var/www/html/server2>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.3-fpm.sock|fcgi://localhost/"
    </FilesMatch>
    ErrorLog ${APACHE_LOG_DIR}/server2_error.log
    CustomLog ${APACHE_LOG_DIR}/server2_access.log combined
</VirtualHost>
EOF'

# Enable the virtual host for php8.dev
sudo a2ensite php8.dev.conf

# Reload Apache for changes to take effect
sudo systemctl reload apache2

sudo a2enmod proxy_fcgi setenvif

sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/sites-available/phpmyadmin.conf

sudo a2ensite phpmyadmin.conf

sudo systemctl reload apache2

echo "Installation completed successfully."