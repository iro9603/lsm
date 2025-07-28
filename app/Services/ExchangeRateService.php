<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.exchange_rate.base_url');
        $this->apiKey = config('services.exchange_rate.key');
    }

    public function getRate($from = 'USD', $to = 'MXN')
    {
        return Cache::remember("exchange_rate_{$from}_{$to}", now()->addHours(12), function () use ($from, $to) {
            $url = "{$this->baseUrl}/{$this->apiKey}/latest/{$from}";
            logger()->info('Calling ExchangeRate API', ['url' => $url]);
            $response = Http::withOptions([
                'http_version' => 1.1,
                'verify' => false,  // no recomendado para producción
            ])->get($url);

            logger()->info('ExchangeRate API response', ['response' => $response]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['conversion_rates'][$to] ?? null;
            }

            return null;
        });
    }

    public function convert($amount, $from = 'USD', $to = 'MXN')
    {
        $rate = $this->getRate($from, $to);
        return $rate ? round($amount * $rate, 2) : null;
    }
}
