<?php

namespace App\Http\Controllers;

use App\Models\TransactionsGame;
use Illuminate\Http\Request;

class TransactionsGamesController extends Controller
{
    public function index()
    {
        $data = TransactionsGame::where('user_id', auth()->user()->id)->paginate(request()->all());
        return response()->json($data);
    }
}
