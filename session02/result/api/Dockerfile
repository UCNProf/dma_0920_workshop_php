FROM php:apache

# Install PDO for MySql driver
RUN docker-php-ext-install pdo_mysql

# Setting the servername
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

COPY . /var/www/html

# enable mod_rewrite
RUN a2enmod rewrite

# Restart Apache
RUN service apache2 restart