<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ReferralController extends Controller
{
    public function index()
    {
        $data = User::where('ref_id', auth()->user()->id)->paginate(request()->all());
        return response()->json($data);
    }
}
