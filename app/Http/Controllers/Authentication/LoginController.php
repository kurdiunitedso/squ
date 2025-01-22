<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\PatientModel;
use App\Models\TawkHistory;
use App\Models\User;
use App\Models\WhatsappHistory;
use App\Models\WhatsappHistoryModel;
use Carbon\Carbon;
use Gr8Shivam\SmsApi\Exception\Exception;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Locale;

class LoginController extends Controller
{

    public function signIn(Request $request)
    {
        return view('CP.authentication.signIn');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $user = User::where('email', $request->email)->first();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString()
            ]);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'title' => 'Invalid credentials',
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }




    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
