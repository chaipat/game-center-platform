<?php
/**
 *   Stake iGaming platform
 *   ----------------------
 *   NotificationChannels.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

trait NotificationChannels
{
    
    public function via($notifiable)
    {
        
        if (!(config('mail.mailers.smtp.host')
            && config('mail.mailers.smtp.port')
            && config('mail.mailers.smtp.username')
            && config('mail.mailers.smtp.password'))) {
            return [];
        }

        
        if ($notifiable instanceof AnonymousNotifiable) {
            return $notifiable->routes['mail'] ? ['mail'] : [];
        } else if ($notifiable instanceof User) {
            return $notifiable->email ? ['mail'] : [];
        }

        return [];
    }
}
