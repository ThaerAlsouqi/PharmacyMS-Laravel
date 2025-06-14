<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Check if the request is for admin routes
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('login'); // Admin login
            }
            
            // Check if the request is for customer routes
            if ($request->is('customer') || $request->is('customer/*')) {
                return route('customer.login'); // Customer login
            }
            
            // Default to customer login for public routes
            return route('customer.login');
        }
    }
}