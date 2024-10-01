<?php

namespace App\Repository;

use App\Models\CurrencyRatesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Teknomavi\Tcmb\Doviz;

class EloquentCurrencyRepository implements CurrencyRepository
{
    public function getExchangeRate($currencies = '')
    {
        $today = Carbon::today(); // Bugünün tarihi
        $currencyRates = CurrencyRatesModel::all();/*Tüm kur değerleri*/

        $todayCurrencyRates = CurrencyRatesModel::whereDate('created_at', $today)->latest('created_at')->first();/*isteğe bağlı olarak bugünkü kur kontrolü*/

        if($currencies != ''){
            $currencyRates = CurrencyRatesModel::where('currency',$currencies)->whereDate('created_at', $today)->get();
        }

        if(count($currencyRates) > 0 && !is_null($todayCurrencyRates)){
            foreach($currencyRates as $currencyRate){
                $data[][$currencyRate['currency']] = $currencyRate;
                unset($currencyRate['currency']);
                /*Testlerim sırasında aşağıdaki döngüyü değiştirme kararı aldım*/
                //$data[$currencyRate['currency']]['buy'] = $currencyRate['buy'];
                //$data[$currencyRate['currency']]['sell'] = $currencyRate['sell'];
                //$data[$currencyRate['currency']]['time'] = $currencyRate['created_at'];
            }
        }else{
            Artisan::call('fetch:currency');/*istek atılan gün tablomda veri yoksa tabloma veri atacağım*/
            return $this->getExchangeRate();
        }

        return $data;
    }

    public function calculateCustomCurrencyRate($currency,$amount,$isBuying)
    {
        $get_exchange_values = $this->getExchangeRate($currency);

        // Komisyon oranlarını fonksiyondan okuyorum
        $commission = $this->getCommissionRate($currency);

        // Alış veya satış mı kontrol ediyorum ve ona göre hesaplama yapıyorum
        $rate = $isBuying ? $get_exchange_values[0][$currency]['buy'] * (1 + $commission) : $get_exchange_values[0][$currency]['sell'] * (1 + $commission);

        // Toplam alış/satış maliyetini hesaplıyorum
        $totalCost = $amount * $rate;

        return $totalCost;

    }

    public function getCommissionRate($currency)
    {
        $commissionRates = [
            'USD' => 0.05,
            'EUR' => 0.04,
            'GBP' => 0.03,
        ];

        return $commissionRates[$currency];
    }

    public function getExchangeRatewithTime($currencies = '')
    {
        // Burada döviz kuru verilerini composer ile eklediğim Teknomavi ile okuyorum
        $tcmb = new Doviz();

        $currencies = $currencies == '' ? ['USD','EUR','GBP'] : array($currencies);/*bu kısımda belli döviz alış ve satış kuru için if else eklendi, örneğin sadece USD alış satışı isteniyorsa USD ile ilgili bize dönecektir*/
        foreach($currencies as $currency){
            $data[$currency]['buy'] = $tcmb->kurAlis($currency);
            $data[$currency]['sell'] = $tcmb->kurSatis($currency);
            $data[$currency]['time'] = Carbon::now();
        }

        return $data;
    }

}
