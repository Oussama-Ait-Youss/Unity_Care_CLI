# 1. THE BASE: Start with an official PHP version with Apache web server
# You can change 8.2 to 8.0 or 7.4 if you need an older version
FROM php:8.2-apache

# 2. UPDATE: Update linux package manager (optional but good practice)
RUN apt-get update && apt-get upgrade -y

# 3. INSTALL EXTENSIONS: This is the most important part for you!
# This installs the 'mysqli' library so you can connect to databases.
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# 4. CONFIGURATION: Enable Apache mod_rewrite
# This allows you to use .htaccess files for clean URLs later
RUN a2enmod rewrite

# 5. WORKDIR: Tell Docker where your code lives inside the container
WORKDIR /var/www/html

# (Optional) COPY: You don't need this if you use 'volumes' in docker-compose,
# but usually, you might see "COPY . /var/www/html" here.