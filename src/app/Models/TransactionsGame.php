<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionsGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'round_id',
        'amount',
        'balance',
        'bet',
        'code',
        'win',
        'losses',
        'profit',
        'table_id',
        'game_status',
        'total_income',
        'total_loss',
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

    public function game()
    {
        return $this->belongsTo(GameNew::class);
    }
}
