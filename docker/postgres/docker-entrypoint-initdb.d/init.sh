#!/bin/bash
set -e

# テスト用データベースを作成
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE DATABASE testing;
    GRANT ALL PRIVILEGES ON DATABASE testing TO $POSTGRES_USER;
EOSQL

echo "PostgreSQL初期化完了"
