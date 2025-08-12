
    /**
     * 追加のセキュリティヘッダー設定
     */
    private function setAdditionalSecurityHeaders(Response $response): void
    {
        // Strict Transport Security
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Permission Policy (旧 Feature Policy)
        $response->headers->set('Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), encrypted-media=(), payment=()');

        // Cross-Origin Resource Policy
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        // Cross-Origin Embedder Policy
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');

        // Cross-Origin Opener Policy
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // セキュリティヘッダーの検証ログ
        Log::debug('Security headers applied', [
            'headers' => [
                'CSP' => $response->headers->get('Content-Security-Policy'),
                'HSTS' => $response->headers->get('Strict-Transport-Security'),
                'X-Frame-Options' => $response->headers->get('X-Frame-Options')
            ]
        ]);
    }
