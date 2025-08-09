# システム開発

開発環境の構築
1. VSCodeをインストールしてください。
2. Dockerをインストールしてください。
3. Dockerを起動させる。
4. リポジトリをクローンします。
5. プロジェクトディレクトリに移動し.env copy.exampleをコピーし.envファイルを作成
6. コンテナーで開く
7. ワークスペースを開く
6. 以下のコマンドを実行します：
php artisan key:generate
php artisan migrate
php artisan db:seed

10. http://localhost にアクセスしてアプリケーションを確認できます。
11. http://localhost:8080 にアクセスしてphpMyAdminを確認できます。

12. 作業後はフォルダーローカルで再度開く
