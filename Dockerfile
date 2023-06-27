FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev zlib1g-dev libxml2-dev libzip-dev libonig-dev libjpeg62-turbo-dev zip unzip git curl libpq-dev \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Установка расширений
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка пользователя и группы
ARG USER_ID=1000
ARG GROUP_ID=1000
RUN groupadd -g ${GROUP_ID} appgroup && useradd -u ${USER_ID} -g ${GROUP_ID} -ms /bin/bash appuser

# Смена владельца рабочей директории
RUN chown -R appuser:appgroup /var/www

USER appuser

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
