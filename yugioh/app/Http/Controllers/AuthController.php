<?php
namespace App\Http\Controllers;

use App\Models\Password_reset;
use Illuminate\Http\Request;
use App\Models\User; // Fix the namespace
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!Auth::check()) {
            $user = User::where('Username', '=', $request->get('Username'))->first();
    
            if ($user && Hash::check($request->password, $user->Password)) {
                // Đăng nhập thành công
                Auth::login($user);
    
                // Chuyển hướng tùy thuộc vào 'IDRole'
                return redirect()->route($user->IDRole == 2 ? 'admin' : 'home');
            }
        }
    
        // Đăng nhập không thành công hoặc đã đăng nhập trước đó
        return redirect()->route('login')->with('error', 'Đăng nhập không thành công');
    }
    
    

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Username' => 'required|unique:users',
            'Email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = new User; // Fix the model name
        $user->Username = $request->input('Username');
        $user->Email = $request->input('Email');
        $user->Password  = Hash::make($request->input('password'));
        $user->NgayTao = now();
        $user->IDRole = 1; // Role mặc định

        $user->save();

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }
    
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $user = User::where('Email', $request->email)->first();
    
        if ($user) {
            $token = Str::random(64);
            $password_reset = new Password_reset();
            $password_reset->Email = $request->email;
            $password_reset->Token = $token;
            $password_reset->Created_at = Carbon::now();
            $password_reset->save();
    
            Mail::send('auth.reset_passsword_form', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject("reset password");
            });
    
            return back()->with('success', 'Chúng tôi đã gửi một email để đặt lại mật khẩu của bạn.');
        }
    
        return back()->withErrors(['email' => 'Không tìm thấy người dùng với địa chỉ email này']);
    }
    
    public function showResetPasswordForm($token)
    {
        $password_reset = Password_reset::where('Token', $token)->first();
    
        if ($password_reset) {
            return view('auth.reset-password', ['token' => $token]);
        }
    
        return back()->withErrors(['token' => 'Liên kết đặt lại mật khẩu không hợp lệ']);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);
    
        $password_reset = Password_reset::where('Token', $request->token)->first();
    
        if ($password_reset) {
            $user = User::where('Email', $password_reset->Email)->first();
    
            if ($user) {
                // Cập nhật mật khẩu
                $user->Password = Hash::make($request->input('password'));
                $user->save();
    
                // Xóa thông tin đặt lại mật khẩu
                $password_reset->delete();
    
                return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại thành công');
            }
        }
    
        return back()->withErrors(['token' => 'Liên kết đặt lại mật khẩu không hợp lệ']);
    }
    
    
}
