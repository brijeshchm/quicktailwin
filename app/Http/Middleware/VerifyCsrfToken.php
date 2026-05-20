<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
    'client-verify-otp',
    '/client-verify-otp', 
    'api/auth/send-otp', 
    'api/auth/verify-otp', 
    '/api/auth/verify-otp',
    '/razorPayCheckout',
    '/payment-done',
    '/failed',
    
    
    ];
}
