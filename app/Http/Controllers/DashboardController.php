<?php

namespace App\Http\Controllers;

use App\Services\InviterCodec;
use App\Services\RsvpRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Port of the legacy dashboard/index.php admin panel: password-protected
 * page showing RSVP + comment stats, plus the personalized invite-link
 * generator. Auth state is kept in the session (no Eloquent user needed,
 * mirroring the original single shared password).
 */
class DashboardController extends Controller
{
    /**
     * GET /dashboard — shows the login form, or the dashboard itself if
     * already authenticated in this session.
     */
    public function index(Request $request)
    {
        return view('dashboard.index', [
            'isLoggedIn' => (bool) $request->session()->get('dashboard_logged_in'),
            'loginError' => $request->session()->get('dashboard_login_error'),
        ]);
    }

    /**
     * POST /dashboard/login — checks the shared dashboard password.
     */
    public function login(Request $request)
    {
        $password = (string) $request->input('password', '');

        if (hash_equals((string) config('wedding.dashboard_password'), $password)) {
            $request->session()->put('dashboard_logged_in', true);
            $request->session()->forget('dashboard_login_error');
        } else {
            $request->session()->flash('dashboard_login_error', 'Mật khẩu không chính xác!');
        }

        return redirect()->route('dashboard.index');
    }

    /**
     * POST /dashboard/logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget('dashboard_logged_in');

        return redirect()->route('dashboard.index');
    }

    /**
     * GET /dashboard/data — AJAX feed of RSVP + comments + stats
     * (port of ?action=get_data). Protected by the dashboard.auth middleware.
     */
    public function data(RsvpRepository $rsvp)
    {
        $rsvpList = $rsvp->getAllRsvp();
        $comments = $rsvp->getAllComments();

        $confirmed = count(array_filter($rsvpList, fn ($item) => ($item['attend'] ?? '') === 'yes'));
        $declined = count(array_filter($rsvpList, fn ($item) => ($item['attend'] ?? '') === 'no'));
        $guests = array_sum(array_column($rsvpList, 'guests'));

        return response()->json([
            'rsvp' => $rsvpList,
            'comments' => $comments,
            'stats' => [
                'total_rsvp' => count($rsvpList),
                'confirmed' => $confirmed,
                'declined' => $declined,
                'total_guests' => $guests,
            ],
        ]);
    }

    /**
     * GET /dashboard/encode-inviter?name=... — encodes a guest name into
     * the opaque /invite/{token} link (port of ?action=encode_inviter).
     * Protected by the dashboard.auth middleware.
     */
    public function encodeInviter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'Thiếu tên người mời',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $name = trim($request->input('name'));

        return response()->json([
            'encoded' => InviterCodec::encode($name, config('wedding.inviter_secret_key')),
        ]);
    }
}
