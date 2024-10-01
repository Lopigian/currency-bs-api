<?php

namespace App\Http\Middleware;

use App\Models\ApiLog;
use App\Repository\EloquentCurrencyRepository;
use Closure;
use Illuminate\Http\Request;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $getCommission = new EloquentCurrencyRepository();

        $commission = isset($request->all()['currency']) ? $getCommission->getCommissionRate($request->all()['currency']) : '0';

        // Loglama verilerini alıyorum
        $logData = [
            'method' => $request->method(),
            'path' => $request->path(),
            'currency_commission' => $commission,
            'query_parameters' => $request->query(),
            'request_body' => $request->all(),
        ];

        // Logları veritabanına kaydet
        ApiLog::create($logData);

        return $next($request);
    }
}
