<?php
// app/Helpers/AssetHelper.php

namespace App\Helpers;

class AssetHelper
{
  /**
   * ファイルの更新時間をバージョンとして付与
   */
  public static function version($file)
  {
    $path = public_path($file);

    if (file_exists($path)) {
      $version = filemtime($path);
      return asset($file) . '?v=' . $version;
    }

    // ファイルが存在しない場合は現在時刻を使用
    return asset($file) . '?v=' . time();
  }

  /**
   * 環境に応じてキャッシュバスティング
   */
  public static function cacheBust($file)
  {
    if (config('app.env') === 'local') {
      // 開発環境では常に現在時刻を使用（強制更新）
      return asset($file) . '?v=' . time();
    }

    // 本番環境ではファイル更新時間を使用
    return self::version($file);
  }

  /**
   * CSS用のヘルパー
   */
  public static function css($file)
  {
    $url = self::version($file);
    return '<link rel="stylesheet" href="' . $url . '">';
  }

  /**
   * JavaScript用のヘルパー
   */
  public static function js($file)
  {
    $url = self::version($file);
    return '<script src="' . $url . '"></script>';
  }
}
