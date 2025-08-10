FROM public.ecr.aws/docker/library/php:8.4.5-fpm-bookworm AS base

ENV COMPOSER_PROCESS_TIMEOUT=0
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_NO_INTERACTION=1
ENV AWS_DEFAULT_REGION=ap-northeast-1

WORKDIR /app

RUN apt update \
  && apt install -y \
  locales \
  git \
  unzip \
  postgresql-client \
  libpq-dev \
  libzip-dev \
  libpng-dev \
  ncat \
  && sed -i -E 's/# (ja_JP.UTF-8)/\1/' /etc/locale.gen \
  && locale-gen \
  && update-locale LANG=ja_JP.UTF-8 \
  && apt clean \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
  opcache \
  pcntl \
  pdo \
  pdo_pgsql \
  pgsql \
  zip \
  gd \
  && pecl install \
  apcu \
  && docker-php-ext-enable \
  apcu \
  && pecl clear-cache

ENV LANG=ja_JP.UTF-8
ENV TZ Asia/Tokyo

# Install Composer directly without Docker Hub dependency
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php-fpm/usr/local/bin/origin-docker-entrypoint.sh /usr/local/bin/origin-docker-entrypoint.sh
ENTRYPOINT ["sh", "/usr/local/bin/origin-docker-entrypoint.sh"]
CMD ["php-fpm"]

FROM base AS deploy
COPY --chown=www-data:www-data ./ /app
RUN composer install

FROM base AS local
COPY --chown=www-data:www-data ./ /tmp/laravel
