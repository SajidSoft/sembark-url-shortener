<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\InviteRequest;
use App\Http\Requests\ProcessInviteRequest;
use App\Services\InviteService;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function __construct(protected InviteService $inviteService) {}

    public function invite(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('invite');
        }

        $data = app(InviteRequest::class)->validated();

        try {
            $this->inviteService->handleInvite($data);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Invitation sent successfully.');
        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function acceptInvite($token)
    {
        $invitation = $this->inviteService->getInvitation($token);

        if (!$invitation) {
            return redirect()->route('login')->with('error', 'This invitation link is invalid or has expired.');
        }

        return view('register-invite', compact('invitation', 'token'));
    }

    public function processInvite($token)
    {
        $invitation = $this->inviteService->getInvitation($token);

        if (!$invitation) {
            return back()->withInput()->with('error', 'This invitation link is invalid or has expired.');
        }

        $data = app(ProcessInviteRequest::class)->validated();

        $user = $this->inviteService->completeRegistration($data, $invitation);

        if (!$user) {
            return back()->withInput()->with('error', 'An account with this email already exists. Please login.');
        }

        $this->inviteService->deleteInvitation($token);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
}
