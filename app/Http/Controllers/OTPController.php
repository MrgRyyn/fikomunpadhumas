<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendOTP;
use Illuminate\Support\Facades\Mail;
use App\Models\OTP;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;


class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npm' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid NPM.'], 422);
        }

        $npm = $request->input('npm');
        $email = Mahasiswa::where('npm', $npm)->value('email');
        $user = Mahasiswa::where('npm', $npm)->value('nama');

        $existing = OTP::where('email', $email)->orderByDesc('updated_at')->first();

        // === CEK LIMIT RESEND 5 MENIT ===
        if ($existing) {

            // Jika last_resend tidak null → artinya sudah pernah resend → cek limit 5 menit
            if ($existing->last_resend !== null) {

                $minutes = Carbon::parse($existing->last_resend)->diffInMinutes(Carbon::now());

                if ($minutes < 5) {
                    return response()->json([
                        'message' => "OTP already sent. Try again in " . (5 - $minutes) . " minute(s)."
                    ], 429);
                }
            }
        }

        $otpPlain = rand(100000, 999999);
        $otpHash = Hash::make((string) $otpPlain);
        $expiresAt = Carbon::now()->addMinutes(10);
        $sessionID = Session::getId();

        if ($existing) {
            $existing->update([
                'otp'        => $otpHash,
                'session_id' => $sessionID,
                'expires_at' => $expiresAt,
            ]);
            $record = $existing;
        } else {
            $record = OTP::create([
                'email'      => $email,
                'session_id' => $sessionID,
                'otp'        => $otpHash,
                'expires_at' => $expiresAt,
                'last_resend' => null,
            ]);
        }

        try {
            Mail::to($email)->send(new SendOTP([
                'otp'  => $otpPlain,
                'user' => $user,
            ]));

            if ($existing) {
                $record->update([
                    'last_resend' => Carbon::now()
                ]);
            }

        } catch (\Exception $e) {
            $record->delete();
            return response()->json(['message' => 'Failed to send OTP email.'], 500);
        }

        Session::put('npm', $npm);
        return response()->json(['message' => 'OTP sent successfully!']);
    }


    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npm' => 'required|string',
            'otp'   => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input.'], 422);
        }

        $npm = $request->input('npm');
        $email = Mahasiswa::where('npm', $npm)->value('email');
        $otpInput = $request->input('otp');
        $sessionID = Session::getId();

       
        $record = OTP::where('email', $email)
            ->where('session_id', $sessionID)
            ->where('expires_at', '>', Carbon::now())
            ->orderByDesc('updated_at')
            ->first();

        if (! $record) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        if (Hash::check((string) $otpInput, $record->otp)) {
            $record->delete(); 
            $user = Mahasiswa::where('npm', $npm)->first();
            if ($user) {
                Auth::login($user);
                // regenerate session to prevent fixation and ensure session cookie is fresh
                $request->session()->regenerate();
                // Optionally persist npm in session for legacy view code
                Session::put('npm', $npm);
                return response()->json(['message' => 'OTP is valid!']);
            }
            return response()->json(['message' => 'User not found.'], 404);
        }

        return response()->json(['message' => 'Invalid or expired OTP.'], 400);
    }
}
