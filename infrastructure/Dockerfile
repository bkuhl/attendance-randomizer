FROM php:7.1-alpine

WORKDIR /var/www/html

COPY install_composer.php /var/www/html/install_composer.php

RUN apk add --update --no-cache \

        # needed for composer
        git zip unzip \

    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \

    # Installing composer
    && php /var/www/html/install_composer.php \

    && mkdir -p /home/www-data/.composer/cache \

    && echo "3       21       *       *       1       php /var/www/html/submit-attendance.php" > /etc/crontabs/www-data

COPY submit-attendance.php .

CMD ['crond', '-f', '-d', '8']