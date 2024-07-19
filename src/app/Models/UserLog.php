<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity',
        'from_ip',
    ];

    public static function createLog($user_id, $activity)
    {
        return self::create([
            'user_id' => $user_id,
            'activity' => $activity,
            'from_ip' => $_SERVER['REMOTE_ADDR'],
        ]);
    }
}
