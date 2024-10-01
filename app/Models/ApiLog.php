<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = ['method', 'path', 'query_parameters', 'request_body','currency_commission'];
    protected $casts = [
        'query_parameters' => 'json',
        'request_body' => 'json',
    ];
}
