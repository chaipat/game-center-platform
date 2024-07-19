<?php

use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\CreateMocDataController;
use App\Http\Controllers\Api\TransactionsGamesController;
use App\Http\Controllers\Api\TransactionsBetsController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\TopupController;
use App\Http\Controllers\Api\TransactionsBetsBehindController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\MasterDataController;
use App\Http\Controllers\Api\TransactionCashoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
| Update: change database to backoffice 07-02-2024
*/

Route::prefix('auth')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::put('set_password', [AuthController::class, 'setPassword']);
        Route::post('checkusername', [AuthController::class, 'checkusername']);
    });

// Game
Route::get('content/publish/game', [ContentController::class, 'game']);
Route::get('content/publish/winners', [ContentController::class, 'winner']);

// Blog
Route::get('content/publish/category', [ContentController::class, 'category']);
Route::get('content/publish/blog', [ContentController::class, 'blog']);
Route::get('content/publish/blog/{id}', [ContentController::class, 'blogDetail']);
Route::get('content/publish/blog/category/{id}', [ContentController::class, 'blogCategory']);

// Master data game
Route::get('master/game', [MasterDataController::class, 'games']);

// Login success
Route::middleware(['jwt:api'])->group(function () {
    // Authentication
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::put('auth/me', [AuthController::class, 'updateme']);
    Route::post('auth/changepassword', [AuthController::class, 'changePassword']);
    Route::get('check_token', [AuthController::class, 'checkToken']);
    Route::post('auth/upload-avatar', [FileUploadController::class, 'upload']);
    Route::get('auth/avatar', [FileUploadController::class, 'getLink']);

    // Transaction Summary
    Route::get('transaction', [TransactionsGamesController::class, 'index']);
    Route::post('transaction', [TransactionsGamesController::class, 'create']);
    Route::post('transaction/blackjack', [TransactionsGamesController::class, 'createBlackjack']);
    Route::put('transaction/{id}', [TransactionsGamesController::class, 'update']);

    // Transaction bet
    Route::get('transaction/bet', [TransactionsBetsController::class, 'index']);
    Route::post('transaction/bet', [TransactionsBetsController::class, 'create']);
    Route::post('transaction/blackjack/bet', [TransactionsBetsController::class, 'createBlackjack']);
    Route::put('transaction/bet/{id}', [TransactionsBetsController::class, 'update']);

    // Transaction bet behind
    Route::post('transaction/betbehind', [TransactionsBetsBehindController::class, 'create']);

    // Transaction cashout (Rocket)
    Route::post('transaction/cashout', [TransactionCashoutController::class, 'create']);

    // Refer
    Route::get('refer_friend', [ReferralController::class, 'index']);

    // Otp
    Route::post('otp/request', [OtpController::class, 'request']);
    Route::post('otp/verify', [OtpController::class, 'verify']);

    // Topup
    Route::post('topup', [TopupController::class, 'create']);

    // Activity user
    Route::post('log_activity', [ActivityLogController::class, 'create']);

    // Create moc data
    Route::post('creatmocdata/transactionbet', [CreateMocDataController::class, 'transactionbet']);
});

Route::any('{path}', function () {
    return response()->json([
        'status' => 'failed',
        'code' => 404,
        'message' => 'route not found'
    ], 404);
})->where('path', '.*');
