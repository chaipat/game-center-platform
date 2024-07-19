<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Game;
use App\Models\TransactionsGame;

class ContentController extends Controller
{
    public function game()
    {
        $perPage = 20;
        $currentPage = request()->input('page', 1);

        $data = Game::paginate($perPage, ['*'], 'page', $currentPage);

        $response = [
            'status' => 'OK',
            'code' => 200,
            'option' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_page' => $data->lastPage(),
            ],
            'lists' => $data->items(),
        ];

        return response()->json($response);
    }

    public function winner()
    {
        $data = TransactionsGame::groupBy('user_id')
            ->selectRaw('user_id, sum(win) as win')
            ->orderBy('win', 'desc')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    public function category()
    {
        $data = Category::all();
        return response()->json($data);
    }

    public function blog()
    {
        $perPage = 20;
        $currentPage = request()->input('page', 1);

        $data = Blog::paginate($perPage, ['*'], 'page', $currentPage);

        $response = [
            'status' => 'OK',
            'code' => 200,
            'option' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_page' => $data->lastPage(),
            ],
            'lists' => $data->items(),
        ];

        return response()->json($response);
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

            return response()->json($response);
        } else {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => 'Not found id:' . $id,
            ], 500);
        }
    }
}
