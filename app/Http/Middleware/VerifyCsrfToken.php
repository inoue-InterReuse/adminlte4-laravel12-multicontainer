<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
  // ここに除外URIなどの設定も追加できます
  protected $except = [
    // 'example/route'
  ];
}
