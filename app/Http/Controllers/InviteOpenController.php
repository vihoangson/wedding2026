<?php

namespace App\Http\Controllers;

use App\Services\InviteRepository;
use App\Services\InviterCodec;
use Illuminate\Http\Request;

class InviteOpenController extends Controller
{
    /**
     * POST /api/invite-opens — sent by the invite page's JS once it has
     * loaded, so link-preview crawlers (Zalo, Messenger...) that fetch the
     * URL without running scripts are not counted as the guest opening it.
     */
    public function store(Request $request, InviteRepository $invites)
    {
        $token = (string) $request->input('token', '');
        $name = InviterCodec::decode($token, config('wedding.inviter_secret_key'));

        if ($name === false || $name === '') {
            return response()->json(['error' => 'Invalid token'], 422);
        }

        $invites->recordOpen($token, $name);

        return response()->noContent();
    }
}
