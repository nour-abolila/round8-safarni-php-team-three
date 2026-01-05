<?php

namespace App\Services\Auth;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function generateOtpCode(User $user)
    {
        OtpCode::where('user_id', $user->id)->delete();

        // توليد كود 6 أرقام
        $code = rand(100000, 999999);

        OtpCode::create([
            'user_id'    => $user->id,
            'code'       => Hash::make($code),
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($code));

        return $code;
    }


    public function verifyOtpCode(User $user, $code)
    {
        $otp = OtpCode::where('user_id', $user->id)->first();

        if (!$otp) {
            return false;
        }

        // لو الكود منتهي
        if (Carbon::now()->greaterThan($otp->expires_at)) {
            $otp->delete();
            return false;
        }

        // لو الكود غلط
        if (!Hash::check($code, $otp->code)) {
            return false;
        }

        // ✔️ الكود صح → نحذفه
        $otp->delete();
        $user->update([
            'email_verified_at' => Carbon::now(),
        ]);

        return true;
    }
}
