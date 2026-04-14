<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Mostrar formulário de login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth.login');
    }

    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Atualizar último login
            Auth::user()->update(['last_login_at' => now()]);
            
            return $this->redirectBasedOnRole();
        }

        throw ValidationException::withMessages([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    /**
     * Mostrar formulário de registro
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth.register');
    }

    /**
     * Processar registro
     */
    public function register(Request $request)
    {
        $isCompany = $request->input('account_type') === 'company';

        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];

        if ($isCompany) {
            $rules['company_name'] = 'required|string|max:255';
            $rules['nif']          = 'nullable|string|max:20';
            $rules['logo']         = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
            $rules['industry']     = 'nullable|string|max:100';
            $rules['website']      = 'nullable|url|max:255';
        }

        $request->validate($rules, [
            'name.required'         => 'O nome é obrigatório.',
            'email.required'        => 'O email é obrigatório.',
            'email.email'           => 'Por favor, insira um email válido.',
            'email.unique'          => 'Este email já está a ser usado.',
            'password.required'     => 'A password é obrigatória.',
            'password.min'          => 'A password deve ter pelo menos 6 caracteres.',
            'password.confirmed'    => 'A confirmação da password não confere.',
            'company_name.required' => 'O nome da empresa é obrigatório.',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'type'      => $isCompany ? 'company_admin' : 'user',
            'is_active' => true,
        ]);

        // Se empresa: criar Company e ligar o utilizador como admin
        if ($isCompany) {
            $slug    = Str::slug($request->company_name);
            $baseSlug = $slug;
            $counter  = 1;
            while (Company::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            $company = Company::create([
                'name'      => $request->company_name,
                'slug'      => $slug,
                'email'     => $request->email,
                'nif'       => $request->nif,
                'logo'      => $logoPath,
                'industry'  => $request->industry,
                'website'   => $request->website,
                'is_active' => true,
            ]);

            $company->users()->attach($user->id, [
                'role'     => 'Administrador',
                'is_admin' => true,
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        Mail::to($user)->send(new WelcomeEmail($user));
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')->with('success', 'Conta criada! Verifica o teu email para continuares.');
    }

    /**
     * Processar logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Você saiu com sucesso!');
    }

    /**
     * Redirecionar baseado no tipo de usuário
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCompanyAdmin()) {
            return redirect()->route('company.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Mostrar formulário de esqueci a senha
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Processar solicitação de reset de senha
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
        ]);

        Password::sendResetLink($request->only('email'));

        // Resposta genérica por segurança (não revela se o email existe)
        return back()->with('success', 'Se existir uma conta com este email, receberás instruções para redefinir a tua password.');
    }

    /**
     * Mostrar formulário de reset de senha
     */
    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Processar reset de senha
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required'  => 'A password é obrigatória.',
            'password.min'       => 'A password deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da password não confere.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password redefinida com sucesso! Podes fazer login agora.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Mostrar página de verificação de email
     */
    public function showVerifyEmail()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Reenviar email de verificação
     */
    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Email de verificação reenviado! Verifica a tua caixa de entrada.');
    }
}