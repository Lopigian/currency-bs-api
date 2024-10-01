<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRatesModel extends Model
{
    use HasFactory;

    protected $table = 'currency_rates';
    protected $fillable = ['buy','sell','currency']; // Alanları belirtiyorum

}
