<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameNew;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{

    // TODO : แก้ไขชื่อตามราง game_news เมื่อรวม database
    public function games()
    {
        $perPage = request()->get('per_page', 10);

        $data = GameNew::select('id', 'name', 'image', 'url', 'desc')
            ->paginate($perPage);

        return response()->json($data, 200);
    }
}
