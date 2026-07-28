FROM php:8.4-cli

# Install system dependencies and the PostgreSQL extension used by Laravel.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 22 for the Vite asset build.
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install Composer.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy only the Laravel app that lives in the nested project directory.
COPY p2p-tracker/ .

# Install dependencies and build frontend assets.
RUN composer install --no-dev --optimize-autoloader
RUN npm ci
RUN npm run build

EXPOSE 8080

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
