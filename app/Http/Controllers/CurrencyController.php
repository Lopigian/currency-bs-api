<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRateRequest;
use App\Http\Resources\CalculateCustomCurrencyRateResource;
use App\Repository\CurrencyRepository;

class CurrencyController extends Controller
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getExchangeRate()
    {
        $exchangeRate = $this->currencyRepository->getExchangeRate();

        return response()->json($exchangeRate);
    }

    public function calculateCustomCurrencyRate(ExchangeRateRequest $request)
    {
        $data = $request->validated();

        $currency = $request->input('currency');
        $amount = $request->input('amount');
        $isBuying = $request->input('isBuying');

        $exchangeRate = $this->currencyRepository->calculateCustomCurrencyRate($currency,$amount,$isBuying);

        $response = array(
            /*Döndüğüm değeri gösterdiğim kısım*/
            'currency' => $currency,
            'type' => $isBuying ? 'buy' : 'sell',
            'amount' => $amount,
            'result' => number_format($exchangeRate,4)
        );

        return CalculateCustomCurrencyRateResource::make($response);
    }
}
