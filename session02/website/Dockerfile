FROM php:apache

# Setting the servername
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

COPY . /var/www/html

# Restart Apache
RUN service apache2 restart