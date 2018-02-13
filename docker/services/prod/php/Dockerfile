# Stage one of the build: fetch the git dependencies.
FROM alpine:latest as git
RUN apk add --no-cache git
RUN git clone https://github.com/TehTotalPwnage/KeyClubInterface.git


# Stage two of the build: deploy PHP.
FROM php:fpm-alpine

# Environment variables.
ARG gid=9999
ARG uid=9999

# Make directories.
RUN mkdir -p /srv/log
RUN mkdir -p /srv/www
WORKDIR /srv/www

# Copy files.
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY getcomposer.sh /usr/local/bin/getcomposer.sh
COPY --from=git /KeyClubInterface /srv/www/

# Install PHP extensions.
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install posix
RUN docker-php-ext-install tokenizer
# By default, the installer will NOT automatically install libxml2-dev, a dependency of the XML extension.
# Therefore, we load it here instead.
# https://lists.alpinelinux.org/alpine-aports/2526.html
RUN apk add --no-cache libxml2-dev
RUN docker-php-ext-install xml
RUN docker-php-ext-install zip

# Install Composer.
RUN chmod +x /usr/local/bin/getcomposer.sh
RUN /usr/local/bin/getcomposer.sh
RUN mv /srv/www/composer.phar /srv/composer.phar

# Set up users and directory permissions.
RUN addgroup -g $gid keyclub
RUN adduser -D -g '' -G keyclub -s /bin/ash -u $uid keyclub
RUN chown -R keyclub:keyclub /srv/log
RUN chown -R keyclub:keyclub /srv/www
