<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Illuminate\Console\Command;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:update-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza las tasas de cambio de divisas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $exchangeService = new ExchangeRateService();

        $from = 'USD';
        $to = 'MXN';

        $rate = $exchangeService->getRate($from, $to);

        if ($rate) {
            ExchangeRate::updateOrCreate(
                ['from_currency' => $from, 'to_currency' => $to],
                ['rate' => $rate]
            );
            $this->info("Tasa actualizada: 1 {$from} = {$rate} {$to}");
        } else {
            $this->error('No se pudo obtener la tasa de cambio');
        }
    }
}
