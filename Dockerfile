# ---- Laravel Mix Build Stage ----
FROM node:18-bookworm AS laravel-mix-build

WORKDIR /app

# Copying the package.json and package-lock.json files
COPY ./src/package*.json /app/
# Install npm dependencies
RUN npm ci

# Copying the Laravel source files
COPY ./src /app
# Run production build
RUN npm run prod


# ---- Main Stage ----
FROM php:8.2-fpm-bookworm

# Install system dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y zip unzip libzip-dev libgmp-dev cron supervisor nginx && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql bcmath gmp opcache zip
RUN docker-php-ext-enable pdo_mysql bcmath gmp opcache zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory in container
WORKDIR /var/www

# Copy Laravel application from the local src directory
COPY src/ .

# Copy built assets from the laravel-mix-build stage, replacing the existing public directory
COPY --from=laravel-mix-build /app/public /var/www/public

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www

# Modify PHP-FPM and Nginx configuration
RUN echo "expose_php = Off" > /usr/local/etc/php/conf.d/disable-x-powered-by.ini && \
    sed -i 's/user = www-data/user = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/group = www-data/group = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/pm.max_children = 5/pm.max_children = 25/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/user nginx;/user www-data;/' /etc/nginx/nginx.conf

# Copy Nginx site configuration
COPY nginx.conf /etc/nginx/nginx.conf
COPY nginx-site.conf /etc/nginx/sites-available/default

# Copy the scheduler cron job to the cron.d directory
COPY laravel-cron /etc/cron.d/laravel-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laravel-cron

# Apply cron job
RUN crontab -u www-data /etc/cron.d/laravel-cron

# Copy the Supervisor configuration file into the container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Clear all storage links
RUN find public -type l -exec rm {} \;

# Create laravel storage link
RUN php artisan storage:link

# Start Supervisor
CMD sh -c "export NUM_CPUS=$(( ($(nproc) + 1) / 2 )); exec /usr/bin/supervisord"

EXPOSE 80
