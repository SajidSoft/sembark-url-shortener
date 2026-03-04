<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Mail\InvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteService
{
    public function handleInvite($data)
    {
        return DB::transaction(function () use ($data) {

            $invite = Invitation::where('email', $data['email'])
                ->where('status', 0)
                ->first();

            if ($invite) {
                // limit attempts
                if ($invite->send_attempts >= 5) {
                    throw new \Exception('Invite resend limit reached.');
                }

                if (!empty($invite->last_sent_at)) {

                    $lastSentTime = strtotime($invite->last_sent_at);
                    $fiveMinutesAgo = strtotime('-5 minutes');

                    if ($lastSentTime > $fiveMinutesAgo) {
                        throw new \Exception('Please wait for 5 minutes to resending invite.');
                    }
                }

                $invite->increment('send_attempts');
                $invite->update(['last_sent_at' => now()]);

                Mail::to($invite->email)->queue(new InvitationMail($invite->token));

                return;
            }

            $token = Str::uuid()->toString();

            if (Auth::user()->role == UserRole::ADMIN) {
                $companyId = Auth::user()->company_id;
            } else {
                $companyId = Company::insertGetId(['name' => $data['name']]);
            }

            $invite = Invitation::create([
                'company_id' => $companyId,
                'email' => $data['email'],
                'token' => $token,
                'role' => isset($data['role']) ? $data['role'] : UserRole::ADMIN->value,
                'last_sent_at' => now(),
            ]);

            Mail::to($invite->email)->queue(new InvitationMail($token));
        });
    }

    public function getInvitation($token)
    {
        return Invitation::where('token', $token)->first();
    }

    public function completeRegistration($data, $invitation)
    {
        $existingUser = User::where('email', $invitation->email)->first();

        if ($existingUser) {
            return null;
        }
        return DB::transaction(function () use ($data, $invitation) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $invitation->email,
                'password' => Hash::make($data['password']),
                'email_verified_at' => now(),
                'role' => $invitation->role,
                'company_id' => $invitation->company_id,
            ]);

            return $user;
        });
    }

    public function deleteInvitation($token)
    {
        Invitation::where('token', $token)->delete();
    }
}
