<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use App\Mail\VerifyEmailLink;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'prenom'    => 'required|string|max:255',
                'nom'       => 'required|string|max:255',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|confirmed|min:8',
            ]);

            $user = User::create([
                'first_name'     => $validated['prenom'],
                'last_name'      => $validated['nom'],
                'email'          => $validated['email'],
                'password'       => Hash::make($validated['password']),
                'subscription_id' => '155c8328-70dc-4bfd-bd90-0ac8b511990b', // Assigning the free plan
            ]);

            // Sending the verification link
            $url = URL::temporarySignedRoute(
                'verify-purchase-email',
                now()->addMinutes(60),
                ['user' => $user->id]
            );

            Mail::to($user->email)->send(new VerifyEmailLink($user, $url));

            return redirect()->route('login')->with('success', 'Registration successful! Check your email inbox to activate your account.');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Une erreur est survenue lors de l\'inscription, veuillez contacter notre service technique depuis la page d\'accueil.');
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
                    Auth::logout();
                    return back()->with('error', 'Veuillez vérifier votre email avant de vous connecter.');
                }

                return redirect()->route('dashboard');
            }

            return back()->with('error', 'Identifiants incorrects.');
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Une erreur est survenue lors de la tentative de connexion.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    public function verify(Request $request, User $user)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->with('error', 'Lien invalide ou expiré.');
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login')->with('success', 'Email vérifié, vous pouvez maintenant vous connecter.');
    }

    public function showAskEmail()
    {
        return view('pages.auth.askEmailForgotPassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Un lien de réinitialisation vous a été envoyé.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('pages.auth.passwordReset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé.')
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    }
}
