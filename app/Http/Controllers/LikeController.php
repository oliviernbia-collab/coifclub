<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'type' => 'required|in:service',
            'id'   => 'required|integer',
        ]);

        $modelClass = Service::class;
        $model = $modelClass::findOrFail($request->id);

        $existing = Like::where('user_id', Auth::id())
            ->where('likeable_type', $modelClass)
            ->where('likeable_id', $request->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id'       => Auth::id(),
                'likeable_type' => $modelClass,
                'likeable_id'   => $request->id,
            ]);
            $liked = true;
        }

        $count = Like::where('likeable_type', $modelClass)
            ->where('likeable_id', $request->id)
            ->count();

        return response()->json(['liked' => $liked, 'count' => $count]);
    }
}
