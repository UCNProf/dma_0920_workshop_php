FROM php:apache

# Setting the servername
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

# Install sqlite
RUN apt-get update
RUN apt-get install sqlite3

# Create database
RUN mkdir /data
RUN sqlite3 /data/todo.db "CREATE TABLE todoitems (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, due TEXT)"

# Give Apache access to data
RUN chown -R www-data:www-data /data

COPY ./todo /var/www/html/todo
COPY index.html /var/www/html

# Restart Apache
RUN service apache2 restart