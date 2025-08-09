<?php

if (!function_exists('asset_version')) {
  function asset_version($file)
  {
    return \App\Helpers\AssetHelper::version($file);
  }
}

if (!function_exists('asset_bust')) {
  function asset_bust($file)
  {
    return \App\Helpers\AssetHelper::cacheBust($file);
  }
}

if (!function_exists('css_version')) {
  function css_version($file)
  {
    return \App\Helpers\AssetHelper::css($file);
  }
}

if (!function_exists('js_version')) {
  function js_version($file)
  {
    return \App\Helpers\AssetHelper::js($file);
  }
}
