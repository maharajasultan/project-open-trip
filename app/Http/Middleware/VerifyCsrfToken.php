<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    // URL yang dikecualikan dari CSRF check
    protected $except = [
        'midtrans/notification',
        'payment/notification',
    ];
}
