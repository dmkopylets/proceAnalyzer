<?php

namespace App\Commands;

use App\Services\Exchanges\ExchangeManager;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class GetPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Binance exchange info';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $manager = new ExchangeManager();
//
//        foreach ($manager->all() as $exchange) {
//            $this->info(strtoupper($exchange->getName()));
//
//            $pairs = $exchange->getPairs();
//            $prices = $exchange->getPrices();
//
//            foreach (array_slice($pairs, 0, 5) as $pair) {
//                if (isset($prices[$pair])) {
//                    $this->line("$pair : {$prices[$pair]}");
//                }
//            }
//
//            $this->line('');
//        }
            $manager = new ExchangeManager();

            foreach ($manager->all() as $exchange) {
                $this->info(strtoupper($exchange->getName()));

                $prices = $exchange->getPrices();

                if (empty($prices)) {
                    $this->error('No prices received');
                    continue;
                }

                foreach (array_slice($prices, 0, 20) as $pair => $price) {
                    $this->line("$pair : $price");
                }

                $this->line('');
            }

            return self::SUCCESS;
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
