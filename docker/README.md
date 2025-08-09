# Laravel Multi-Container Development Environment

## 🚀 クイックスタート

### 1. 環境設定
```bash
# 環境変数ファイルの作成
cp .env.example .env

# 必要に応じて .env を編集
vi .env
```

### 2. ローカル開発環境の起動
```bash
# 標準的なローカル開発環境
docker-compose up -d

# コンテナの状況確認
docker-compose ps

# ログの確認
docker-compose logs -f php-fpm
```

### 3. AWS環境の検証
```bash
# AWS環境をローカルで検証
docker-compose -f docker-compose.yml -f docker-compose.aws.yml up -d

# AWS RDS接続テスト
docker-compose exec php-fpm php artisan migrate --force
```

## 📋 利用可能なサービス

| サービス | URL | 説明 |
|---------|-----|------|
| Webアプリケーション | http://localhost | Nginx + PHP-FPM |
| Adminer | http://localhost:8080 | データベース管理 |
| PostgreSQL | localhost:5432 | 開発用データベース |

## 🔧 環境切り替え

### ローカル開発
```bash
export DOCKER_TARGET=local
export ENVIRONMENT=local
docker-compose up -d
```

### AWS検証環境
```bash
export DOCKER_TARGET=aws
export ENVIRONMENT=aws
docker-compose -f docker-compose.yml -f docker-compose.aws.yml up -d
```

## 🛠️ 開発者カスタマイズ

```bash
# 個別設定ファイルの作成
cp docker-compose.override.yml.example docker-compose.override.yml

# 個別設定の編集
vi docker-compose.override.yml

# カスタマイズした環境で起動
docker-compose up -d
```

## 📦 コンテナ管理

### Laravel Artisanコマンド
```bash
# マイグレーション実行
docker-compose exec php-fpm php artisan migrate

# キャッシュクリア
docker-compose exec php-fpm php artisan cache:clear

# コンテナ内でのシェル実行
docker-compose exec php-fpm bash
```

### データベース管理
```bash
# PostgreSQL接続
docker-compose exec postgres psql -U admin -d laravel

# データベースバックアップ
docker-compose exec postgres pg_dump -U admin laravel > backup.sql
```

### 環境のリセット
```bash
# コンテナ停止・削除
docker-compose down

# ボリューム含めて完全削除
docker-compose down -v

# イメージのリビルド
docker-compose build --no-cache
```

## 🔧 トラブルシューティング

### ポート競合の解決
`.env` ファイルでポートを変更：
```bash
APP_PORT=8080
DB_PORT_EXTERNAL=5433
ADMINER_PORT=8081
```

### パーミッション問題
```bash
# ストレージディレクトリの権限修正
sudo chown -R $USER:$USER storage/
sudo chmod -R 775 storage/
```

### データベース接続エラー
```bash
# PostgreSQLの起動確認
docker-compose logs postgres

# 接続テスト
docker-compose exec php-fpm php artisan tinker
# → DB::connection()->getPdo();
```
