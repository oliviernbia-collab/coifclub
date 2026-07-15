<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.footer_sub_invalid'),
            ], 422);
        }

        $email = strtolower(trim($request->email));

        $exists = DB::table('newsletter_subscribers')->where('email', $email)->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'already' => true,
                'message' => __('messages.footer_sub_already'),
            ]);
        }

        DB::table('newsletter_subscribers')->insert([
            'email'      => $email,
            'locale'     => app()->getLocale(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('messages.footer_sub_success'),
        ]);
    }
}
