FROM public.ecr.aws/docker/library/nginx:1.27.4-bookworm AS base

ENV PHP_FPM_HOST=127.0.0.1

WORKDIR /app

RUN apt update \
    && apt install -y \
        locales \
        ncat \
    && sed -i -E 's/# (ja_JP.UTF-8)/\1/' /etc/locale.gen \
    && locale-gen \
    && update-locale LANG=ja_JP.UTF-8 \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

ENV LANG=ja_JP.UTF-8
ENV TZ Asia/Tokyo

RUN mkdir /etc/nginx/templates
COPY docker/nginx/etc/nginx/templates/default.conf.template /etc/nginx/templates/default.conf.template

FROM base AS deploy
COPY public /app/public

FROM base AS local
