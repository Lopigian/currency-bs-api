<?php

namespace App\Console\Commands;

use App\Models\CurrencyRatesModel;
use Illuminate\Console\Command;
use App\Repository\EloquentCurrencyRepository;


class FetchCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*Veritabanına tcmb den gelen kuru kayıt atıyorum*/
        $repository = new EloquentCurrencyRepository();
        $currencies = $repository->getExchangeRatewithTime('');

        foreach($currencies as $currency => $value){
            $data['currency'] = $currency;
            $data['buy'] = $value['buy'];
            $data['sell'] = $value['sell'];
            $data['created_at'] = $value['time'];
            CurrencyRatesModel::create($data);
        }
        return true;
    }
}
