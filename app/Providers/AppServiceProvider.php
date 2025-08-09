<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // カスタムBladeディレクティブを登録
    Blade::directive('asset_version', function ($expression) {
      return "<?php echo asset_version($expression) . '?v=' . (file_exists(public_path($expression)) ? filemtime(public_path($expression)) : time()); ?>";
    });

    Blade::directive('js_version', function ($expression) {
      $file = trim($expression, "'\"");
      return "<?php
                \$file = '$file';
                \$version = file_exists(public_path(\$file)) ? filemtime(public_path(\$file)) : time();
                echo '<script src=\"' . asset_version(\$file) . '?v=' . \$version . '\"></script>';
            ?>";
    });

    Blade::directive('css_version', function ($expression) {
      $file = trim($expression, "'\"");
      return "<?php
                \$file = '$file';
                \$version = file_exists(public_path(\$file)) ? filemtime(public_path(\$file)) : time();
                echo '<link rel=\"stylesheet\" href=\"' . asset_version(\$file) . '?v=' . \$version . '\">';
            ?>";
    });
  }
}
