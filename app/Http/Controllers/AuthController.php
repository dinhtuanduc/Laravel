<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function home(){
        $user = new User();
        $data = [
          'active_status' => $user->active_status
        ];
        return view('auth.home',$data);
    }
    public function login(){
        return view('auth.login');
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function postLogin(Request $request){
        $validation = $request->validate([
                'email' => 'required|email',
                'pwd' => 'required'
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Định dạng email không đúng',
                'pwd.required' => 'Vui lòng nhập password'
            ]);
        $email = $request->email;
        $password = $request->pwd;
        $remember = $request->remember == 1 ? 'true' : 'false';
        if (Auth::attempt(['email' => $email, 'password' => $password],$remember)) {
            return redirect('/')->with('success_login','Đăng nhập thành công');
        }else{
            return back()->with('failse_login','Tài khoản mật khẩu bị sai');
        }
    }
    public function register(){
        return view('auth.register');
    }
    public function postRegister(Request $request){
        $validation = $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:users,email',
           'pwd' => 'required|regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i',
           'pwd_confirm' => 'required|same:pwd',
        ],
        [
            'name.required' => 'Vui lòng nhập name',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.unique' => 'Email này đã tồn tại',
            'pwd.required' => 'Vui lòng nhập password',
            'pwd.regex' => 'Hãy nhập password từ 8 đến 16 ký tự bao gồm chữ hoa, chữ thường và ít nhất một chữ số',
            'pwd_confirm.required' => 'Vui lòng nhập password',
            'pwd_confirm.same' => 'Không khớp với mật khẩu trên',
        ]);
        $name = $request->name;
        $email = $request->email;

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($request->pwd);
        $user->save();


        $email_verified_active = bcrypt(md5(time().$email));
        $email_verified_at = Carbon::now();
        $user->email_verified_active = $email_verified_active;
        $user->email_verified_at = $email_verified_at;
        $user->save();
        $url = route('email.verified',['id' => $user->id ,'active' => $email_verified_active]);
        $data = [
            'name' => $request->name,
            'id' => $request->id,
            'url' => $url,
            'email' => $email,
            'active' => $email_verified_active
        ];
        Mail::send('auth.email-verified',$data, function ($messeage) use ($email, $name){
            $messeage->to($email, $name)->subject('Xác thực tài khoản');
        });
        return redirect('/login');
    }
    public function forgotPassword(){
        return view('auth.forgot-password');
    }
    public function postForgotPassword(Request $request){
        $validition = $request->validate([
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Định dạng email không đúng',
        ]);
        $email = $request->email;
//        $user = DB::table('users')->where('email',$email)->first();
        $user = User::where('email', $email)->first();
        if (!$user){
            return back()->with('exist_email','Email này không tồn tại');
        }
        $code_forgot_pwd = bcrypt(md5(time().$email));
        $time_code_forgot_pwd = Carbon::now();
        $user->code_forgot_pwd = $code_forgot_pwd;
        $user->time_code_forgot_pwd = $time_code_forgot_pwd;
        $user->save();

        $name =$user->name;

        $url = route('reset.password', ['code' => $user->code_forgot_pwd, 'email' => $user->email]);
        $data = [
            'url' => $url,
            'email' =>  $email,
            'code_forgot_pwd' =>  $code_forgot_pwd,
            'time_code_forgot_pwd' =>  $time_code_forgot_pwd
        ];
        Mail::send('auth.email-reset-password', $data, function ($message) use ($email, $name){
            $message->to($email, $name)->subject("Lấy lại mật khẩu cho $name");
        });

        return back()->with('send_forgot_pwd','Link lấy lại mật khẩu đã được gửi vào email của bạn');
    }
    public function resetPassword(Request $request){
        $data = ['email' => $request->email];
        return view('auth.reset-password',$data);
    }
    public function postResetPassword(Request $request){
        $validation = $request->validate([
           'pwd' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i',
           'pwd_confirm' => 'required|same:pwd',
        ],
        [
            'pwd.required' => 'Vui lòng nhập password',
            'pwd.regex' => 'Hãy nhập password từ 8 đến 16 ký tự bao gồm chữ hoa, chữ thường và ít nhất một chữ số',
            'pwd_confirm.required' => 'Vui lòng nhập password',
            'pwd_confirm.same' => 'Không khớp với mật khẩu trên'
        ]);
        $user = DB::table('users')->where('email',$request->email)->update(['password' => Hash::make($request->pwd)]);
        if ($user){
            return redirect('/login');
        }else{
            dd('Lỗi');
        }
    }
    public function emailVerified(Request $request){
        $id = $request->id;
        $active = $request->active;
        $user = User::where(['id' => $id, 'email_verified_active' => $active])->first();
        if ($user){
            $user->active_status = 1;
            $user->save();
            return redirect('/')->with('email_verified_success', 'Xác minh tài khoản thành công');
        }else{
            return redirect('/')->with('email_verified_failse', 'Xác minh tài khoản thất bại');
        }
    }

}
