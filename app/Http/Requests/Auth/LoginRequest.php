<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}

    /**
     * Handle failed authentication attempt
     */
    public function handleFailedAuth(): void
    {
        $ip = $this->ip();
        $email = $this->input('email');

        // 失敗試行回数をカウント
        $attempts = cache()->get("failed_login_attempts_{$ip}", 0) + 1;
        cache()->put("failed_login_attempts_{$ip}", $attempts, 3600); // 1時間

        // 疑わしい活動の検知
        if ($attempts >= 5) {
            Log::alert('Multiple failed login attempts detected', [
                'ip' => $ip,
                'email' => $email,
                'attempts' => $attempts,
                'user_agent' => $this->userAgent(),
                'timestamp' => now()->toISOString()
            ]);

            // CloudWatch Alarm トリガー
            $this->sendFailedLoginMetric($attempts);
        }

        // 地理的位置情報チェック（IPアドレスベース）
        $this->checkGeolocation($ip);
    }

    private function sendFailedLoginMetric(int $attempts): void
    {
        try {
            $command = sprintf(
                'aws cloudwatch put-metric-data --namespace "LaravelAuth" --metric-data MetricName=FailedLoginAttempts,Value=%d,Unit=Count --region %s',
                $attempts,
                escapeshellarg(env('AWS_DEFAULT_REGION', 'ap-northeast-1'))
            );
            exec($command);
        } catch (\Exception $e) {
            Log::error('Failed to send failed login metric', ['error' => $e->getMessage()]);
        }
    }

    private function checkGeolocation(string $ip): void
    {
        // 簡易的な地理的チェック（本格運用時は GeoIP サービス使用推奨）
        $knownSafeIPs = [
            '123.198.241.102', // 設定済み許可IP
            '203.141.155.122'
        ];

        if (!in_array($ip, $knownSafeIPs) && !$this->isPrivateIP($ip)) {
            Log::warning('Login attempt from unknown location', [
                'ip' => $ip,
                'email' => $this->input('email'),
                'user_agent' => $this->userAgent(),
                'timestamp' => now()->toISOString()
            ]);
        }
    }

    private function isPrivateIP(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }
