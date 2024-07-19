<?php
/**
 *   Stake iGaming platform
 *   ----------------------
 *   EmailAuth.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailAuth
{
    
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(config('settings.users.email_auth'), 403);

        return $next($request);
    }
}
