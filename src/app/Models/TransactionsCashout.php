<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionsCashout extends Model
{
    use HasFactory;

    protected $fillable = [
        'round_id',
        'user_id',
        'cashout',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
