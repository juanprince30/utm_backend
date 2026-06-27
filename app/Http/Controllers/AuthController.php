<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    
    public function show_login(){
        return view('auth.login');
    }

    public function show_register(){
        return view('auth.register');
    }

    public function show_forgotpassword(){
        return view('auth.forgotpassword');
    }

    public function show_otp(){
        return view('auth.otp');
    }

    public function show_resetpassword(){
        return view('auth.resetpassword');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|numeric|unique:users,telephone',
            'email'     => 'nullable|email|max:255|unique:users,email',
            'addresse'  => 'nullable|string|max:255',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name'      => $request->name,
            'prenom'    => $request->prenom,
            'telephone' => $request->telephone,
            'email'     => $request->email,
            'addresse'  => $request->addresse,
            'password'  => Hash::make($request->password),
            'role'      => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('main')->with('success', 'Compte cree avec succes !');
    }

    
    public function login_admin(Request $request){
        $validator = Validator::make($request->all(), [
            'numero'   => 'required|numeric',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::firstWhere('telephone', $request->numero);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['numero' => 'Numero ou mot de passe incorrect.'])->withInput();
        }

        if(!$user->isActif){
            return back()->withErrors(['numero' => 'Impossible de se connecter.'])->withInput();
        }

        if ($user->role !== 'admin') {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('main')->with('success', 'Connexion reussie !');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Connexion reussie !');
    }




    public function show_profile()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update_profile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|numeric|unique:users,telephone,' . $user->id,
            'email'     => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'addresse'  => 'nullable|string|max:255',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'prenom', 'telephone', 'email', 'addresse']);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil mis a jour avec succes !');
    }
    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'telephone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::firstWhere('telephone', $request->telephone);

        if (!$user) {
            return back()->withErrors(['telephone' => 'Aucun compte associe a ce numero.'])->withInput();
        }

        if (!$user->email) {
            return back()->withErrors(['telephone' => 'Aucun email associe a ce compte. Contactez le support.'])->withInput();
        }

        $otp = rand(1000, 9999);

        session([
            'otp_code'      => $otp,
            'otp_telephone' => $request->telephone,
            'otp_expires'   => now()->addMinutes(10)->timestamp,
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return redirect()->route('otp.form')
                         ->with('info', 'Code envoye sur ' . $user->email);
    }

    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sessionOtp = session('otp_code');
        $expires    = session('otp_expires');

        if (!$sessionOtp || !$expires) {
            return redirect()->route('forgotpassword.form')
                             ->withErrors(['telephone' => 'Session expiree. Recommencez.']);
        }

        if (now()->timestamp > $expires) {
            session()->forget(['otp_code', 'otp_telephone', 'otp_expires']);
            return redirect()->route('forgotpassword.form')
                             ->withErrors(['telephone' => 'Code OTP expire (10 min). Recommencez.']);
        }

        if ($request->otp !== (string) $sessionOtp) {
            return back()->withErrors(['otp' => 'Code OTP incorrect. Verifiez et reessayez.']);
        }

        session(['otp_verified' => true]);

        return redirect()->route('resetpassword.form');
    }

    public function reset_password(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('forgotpassword.form')
                             ->withErrors(['telephone' => 'Verification OTP requise. Recommencez.']);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::firstWhere('telephone', session('otp_telephone'));

        if (!$user) {
            return redirect()->route('forgotpassword.form')
                             ->withErrors(['telephone' => 'Utilisateur introuvable. Recommencez.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        session()->forget(['otp_code', 'otp_telephone', 'otp_expires', 'otp_verified']);

        return redirect()->route('login.form')
                         ->with('success', 'Mot de passe reinitialise avec succes !');
    }
    public function logout(Request $resquest)
    {
        Auth::logout();
        return redirect()->route('main')->with('success', 'Déconnexion réussie.');
    }

}
