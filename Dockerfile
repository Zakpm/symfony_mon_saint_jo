# Définir l'image de base avec PHP 8 et les extensions requises
FROM php:8.2-cli

# Créer un répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Copier les fichiers de votre application dans le conteneur
COPY . . 

# Installer les dépendances (Composer et Node.js)
RUN apt-get update && \
    apt-get install -y \
        unzip \
        libicu-dev \
        zlib1g-dev \
        nodejs \
        npm && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances PHP avec Composer
RUN composer install --no-interaction

# Installer les dépendances JavaScript avec npm et exécuter Webpack
RUN npm install && \
    npm run build

# Exposer le port sur lequel votre application Symfony écoute (par exemple, 8000)
EXPOSE 8000


# Commande de démarrage de l'application Symfony
CMD ["php", "bin/console", "server:run", "0.0.0.0:8000"]

