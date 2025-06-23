# Utilise une image de base qui inclut Nginx et PHP-FPM
FROM richarvey/nginx-php-fpm:1.7.2

# Copie tout le code de votre application dans le conteneur
COPY . /var/www/html

# Configurer Nginx pour pointer vers le dossier public de Laravel
COPY docker/nginx/default.conf /etc/nginx/sites-available/default.conf

# Installer les dépendances Composer (en s'assurant que Composer est disponible)
RUN composer install --no-dev --optimize-autoloader

# Exposer le port Nginx
EXPOSE 80

# Démarrer PHP-FPM et Nginx
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]