<?php
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return view('reset-password.forgot-password');
    }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

    
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subHours(1))
            ->first();

        if ($existingToken) {
            return redirect()->back()->withErrors('A reset link has already been sent to this email.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('mail.reset-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->back()->with('success', 'Reset link successfully sent');
    }

    public function resetPassword($token)
    {
        return view('reset-password.new-password', compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where('email', $validatedData['email'])
            ->where('token', $request->token)
            ->whereNull('deleted_at')
            ->first();

        if (!$updatePassword) {
            return redirect()->route('reset.password', ['token' => $request->token])->withErrors('Invalid');
        }

        User::where('email', $validatedData['email'])
            ->update(['password' => Hash::make($validatedData['password'])]);

        DB::table('password_reset_tokens')->where('email', $validatedData['email'])->delete();

        return redirect()->route('admin.login')->with('success', 'Password reset successfully');
    }
}
