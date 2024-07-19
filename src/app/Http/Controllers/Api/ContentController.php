<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\GameNew;
use App\Models\TransactionsGame;
use Carbon\Carbon;

class ContentController extends Controller
{
    public function game()
    {
        $perPage = request()->get('per_page', 10);
        $data = GameNew::paginate($perPage)->through(function ($game) {
            $game->image = env('IMAGE_URL') . '/' . $game->image;
            return $game;
        });

        return response()->json($data, 200);
    }

    public function winner()
    {
        $data = TransactionsGame::join('users', 'transactions_games.user_id', '=', 'users.id')
            ->join('game_news', 'transactions_games.game_id', '=', 'game_news.id')
            ->groupBy('transactions_games.user_id', 'transactions_games.game_id')
            ->selectRaw('transactions_games.user_id, count(transactions_games.win) as win, sum(transactions_games.win) as sum_win, 
            users.name, users.avatar, game_news.name as game, users.currency')
            ->orderBy('sum_win', 'desc')
            ->get();

        $data->transform(
            function ($item) {
                $lastWin = TransactionsGame::where('user_id', $item->user_id)->latest()->first();
                $item->create_at = Carbon::parse($lastWin->created_at)->diffForHumans();
                if ($item->avatar) $item->avatar = env('IMAGE_URL') . '/' . $item->avatar;
                return $item;
            }
        );

        $response = [
            'status' => 'OK',
            'code' => 200,
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    public function category()
    {
        $data = Category::all();
        $response = [
            'status' => 'OK',
            'code' => 200,
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    public function blog()
    {
        $perPage = request()->get('per_page', 10);
        $data = Blog::where('status', 'active')->orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json($data, 200);
    }

    public function blogCategory($id)
    {
        $perPage = request()->get('per_page', 10);
        $data = Blog::where('category_id', $id)
                    ->where('status', 'active')
                    ->paginate($perPage);
        return response()->json($data, 200);
    }

    public function blogDetail($id)
    {
        $data = Blog::where('id', $id)->with('category:id,title')->first();

        if ($data) {
            $response = [
                'status' => 'OK',
                'code' => 200,
                'data' => $data,
            ];

            return response()->json($response, 200);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 404,
                'message' => 'not found',
            ], 404);
        }
    }
}
