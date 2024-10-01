<?php

namespace App\Repository;

interface CurrencyRepository
{
    public function getExchangeRate();
    public function calculateCustomCurrencyRate($currency,$amount,$isBuying);

}
