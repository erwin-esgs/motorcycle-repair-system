<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
 
class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	
	
	public function index(Request $request)
    {
		return view('index', ['user' => Auth::user() ]);
	}
	
	public function login(Request $request)
    {
		if( Auth::guard('web')->user() || Auth::guard('customer')->user())return redirect('/');
		return view('login');
	}
	 
    public function verify(Request $request)
    {
		$remember = $request->input("remember") ? true : false;
		
		$userdata = array( 'email' => $request->input('email') , 'password' => $request->input('password') );
		//$userdata = User::where('email', $request->email) ->where('password', $request->password) ->first();
		
		if (Auth::attempt( $userdata , $remember ))
		//if ( $userdata )
          {
		  //Auth::login($userdata, $remember);
          return redirect('/transaction');
          }
        return '<script language="javascript">alert("Gagal!");window.location.href = "/admin";</script>'; 
        //return json_encode(["Halo" , Auth::check() ]);
    }
	public function logout(Request $request)
    {
		Auth::guard('customer')->logout();
		Auth::guard('web')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
		return '<script language="javascript">alert("Berhasil");window.location.href = "/login";</script>';
		//return json_encode("Logged out");
	}
	
	public function register(Request $request)
    {
		$user = new User();
		$user->password = Hash::make('admin');
		$user->email = 'admin';
		$user->name = 'admin';
		$user->role = 0;
		if ($user->save())return json_encode(true);
		return json_encode(false);
	}
	
	public function forgotpass(Request $request)
    {
		//echo $request->get('email'); die;
		if ( $request->get('email') != null ){
			$customer = User::where('email', $request->get('email') )->first();
			if($customer){
				$data["emailTo"] = $request->get('email');
				$data["otp"] = sprintf("%04d", mt_rand(1, 9999));
				$customer->otp = $data["otp"];
				$customer->save();
				
				Mail::send(['html' => 'mail.otp'], $data, function ($message) use ($data) {
					$message->to( $data["emailTo"] , 'You')->subject('Kode OTP Forgot Pass');
					$message->from(env("MAIL_FROM_ADDRESS"), 'System_Service');
				});
				return redirect('/newpassAdmin?email='.$request->get('email'));
			}
		}
		return '<script language="javascript">alert("Gagal!");window.location.href = "/login";</script>';
	}
	
	public function newpass(Request $request)
    {
		$data["email"] = $request->get('email');
		return view('newpassAdmin' , $data);
	}
	
	public function verifynewpass(Request $request)
    {
		//echo $request->get('email'); die;
		if ( $request->input('email') != null ){
			$customer = User::where('email', $request->get('email') )->first();
			if($customer){
				if( $request->input('otp') == $customer->otp ){
				$customer->password = Hash::make($request->input("password"));
				$customer->save();
				return '<script language="javascript">alert("Berhasil!");window.location.href = "/login";</script>';
				}
			}
		}
		return '<script language="javascript">alert("Gagal!");window.location.href = "/login";</script>';
	}
	
}
