# Dockerfile
FROM php:8.2-apache-bullseye

# Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libonig-dev libxml2-dev zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia o app
COPY . /var/www/html

# Habilita o Apache mod_rewrite
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html

# Permissões
RUN chown -R www-data:www-data /var/www/html

# Porta padrão do Apache
EXPOSE 80
