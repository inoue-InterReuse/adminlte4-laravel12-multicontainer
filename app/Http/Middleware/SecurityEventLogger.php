<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityEventLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 疑わしいリクエストの検知
        $this->detectSuspiciousActivity($request, $response);

        return $response;
    }

    private function detectSuspiciousActivity(Request $request, Response $response)
    {
        $suspiciousPatterns = [
            'sql_injection' => '/(\bunion\b|\bselect\b|\bdrop\b|\binsert\b|\bupdate\b|\bdelete\b)/i',
            'xss_attempt' => '/<script|javascript:|vbscript:|onload=|onerror=/i',
            'path_traversal' => '/\.\.\/|\.\.\\\\|\%2e\%2e\%2f|\%2e\%2e\%5c/i',
            'command_injection' => '/(\||\;|\&|\$\(|\`)/i'
        ];

        $requestData = json_encode([
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'input' => $request->all()
        ]);

        foreach ($suspiciousPatterns as $type => $pattern) {
            if (preg_match($pattern, $requestData)) {
                Log::warning('Suspicious activity detected', [
                    'type' => $type,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'pattern_matched' => $pattern,
                    'timestamp' => now()->toISOString()
                ]);

                // CloudWatch Custom Metrics
                $this->sendCloudWatchMetric($type);
                break;
            }
        }

        // 高頻度リクエスト検知
        $this->detectHighFrequencyRequests($request);

        // 異常なレスポンス時間検知
        $this->detectAbnormalResponseTime($request, $response);
    }

    private function sendCloudWatchMetric(string $threatType)
    {
        // CloudWatch Custom Metrics送信
        try {
            $command = sprintf(
                'aws cloudwatch put-metric-data --namespace "LaravelSecurity" --metric-data MetricName=%s,Value=1,Unit=Count --region %s',
                escapeshellarg($threatType),
                escapeshellarg(env('AWS_DEFAULT_REGION', 'ap-northeast-1'))
            );
            exec($command);
        } catch (\Exception $e) {
            Log::error('Failed to send CloudWatch metric', ['error' => $e->getMessage()]);
        }
    }

    private function detectHighFrequencyRequests(Request $request)
    {
        $cacheKey = 'security_rate_limit_' . $request->ip();
        $currentCount = cache()->get($cacheKey, 0);

        if ($currentCount > 100) { // 5分間に100リクエスト以上
            Log::alert('High frequency requests detected', [
                'ip' => $request->ip(),
                'request_count' => $currentCount,
                'url' => $request->fullUrl(),
                'timestamp' => now()->toISOString()
            ]);
        }

        cache()->put($cacheKey, $currentCount + 1, 300); // 5分間キャッシュ
    }

    private function detectAbnormalResponseTime(Request $request, Response $response)
    {
        $processingTime = microtime(true) - LARAVEL_START;

        if ($processingTime > 5.0) { // 5秒以上
            Log::warning('Abnormal response time detected', [
                'processing_time' => $processingTime,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'status_code' => $response->getStatusCode(),
                'timestamp' => now()->toISOString()
            ]);
        }
    }
}
