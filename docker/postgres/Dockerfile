FROM postgres:17

# ロケールとタイムゾーンの設定
ENV TZ=Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 日本語ロケールを追加
RUN apt-get update && apt-get install -y locales \
  && echo "ja_JP.UTF-8 UTF-8" >> /etc/locale.gen \
  && locale-gen \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# PostgreSQLの設定
ENV LANG=ja_JP.UTF-8
ENV LANGUAGE=ja_JP:ja
ENV LC_ALL=ja_JP.UTF-8

# カスタム設定ファイルをコピー（必要に応じて）
# COPY ./docker/postgres/postgresql.conf /etc/postgresql/postgresql.conf

EXPOSE 5432
