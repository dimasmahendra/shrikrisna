FROM php:7.4-fpm
# Set working directory
WORKDIR /var/www

# Arguments defined in docker-compose.yml
ARG branch

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libwebp-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  libzip-dev \
  libgd-dev \
  unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y libpq-dev git \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql
# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install mbstring gd exif pcntl bcmath gd zip



# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .
COPY ./deploy/$branch/env .env

RUN composer update

EXPOSE 8000

CMD [ "sh", "./start.sh" ]