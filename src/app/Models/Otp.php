<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'contry_code',
        'contact',
        'channel',
        'length_otp',
        'length_ref_code',
        'code',
        'ref_code',
        'verify_count',
        'verify_time',
        'status',
        'expired_at',
    ];
}
