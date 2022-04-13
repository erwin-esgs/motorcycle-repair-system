<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Customer;
use Session;

class CustomerController extends Controller
{
	public function login(Request $request)
    {
		if( Auth::guard('web')->user() || Auth::guard('customer')->user())return redirect('/logout');
		return view('loginCustomer');
	}
	
	public function loginInput(Request $request)
    {
		$customer = Customer::where( 'email',$request->input('email') )->first(); 
		$customerPhone = Customer::where( 'phone','like', '%'.$request->input('email').'%' )->first(); 
		$data["otp"] = sprintf("%04d", mt_rand(1, 9999));
		$data["emailTo"] = $request->input("email");
		
		if($customerPhone){
			if( isset( $customerPhone->name ) ){
				return view('loginCustomer',[
					"email" => $request->input("email"),
					"exist" => true
				]);
			}
		}else{
			if( $customer ){
				$customer->otp = $data["otp"];
				$customer->save();
				if( isset( $customer->name ) ){
					return view('loginCustomer',[
						"email" => $request->input("email"),
						"exist" => true
					]);
				}else{
					Mail::send(['html' => 'mail.otp'], $data, function ($message) use ($data) {
						$message->to( $data["emailTo"] , 'You')->subject
								('Kode OTP Registerasi');
						$message->from(env("MAIL_FROM_ADDRESS"), 'System_Service');
					});
					
					return view('loginCustomer',[
						"email" => $request->input("email"),
						"exist" => false
					]);
				}
				
			}else{
				if( str_contains($request->input('email'), '@') ){
					$customer = new Customer();
					$customer->email = $request->input("email");
					$customer->otp = $data["otp"];
					//Mail::to( $request->input("email") )->send();
					Mail::send(['html' => 'mail.otp'], $data, function ($message) use ($data) {
						$message->to( $data["emailTo"] , 'You')->subject
								('Kode OTP Registerasi');
						$message->from(env("MAIL_FROM_ADDRESS"), 'System_Service');
					});
					if ($customer->save()){
						return view('loginCustomer',[
							"email" => $request->input("email"),
							"exist" => false
						]);
					}
				}
			}
		}
		
		return view('loginCustomer');
	}
	
	public function register(Request $request)
    {

		$validatedData = $request->validate([
			'otp' => ['required'],
			'name' => ['required', 'max:255'],
			'email' => ['required'],
			'phone' => ['required'],
			'password' => ['required'],
			'vehicle_type' => ['required'],
			'license_plate' => ['required'],
		]);
		if($validatedData){
			$customer = Customer::where( 'email',$request->input('email') )->first(); 
			if($customer){
				if( $request->input('otp') == $customer->otp ){
					$customer->name = $request->input("name");
					if($request->input("address") != null){$customer->address = $request->input("address");}
					$customer->phone = $request->input("phone");
					$customer->password = Hash::make($request->input("password"));
					$customer->vehicle_type = $request->input("vehicle_type");
					$customer->license_plate = $request->input("license_plate");
					$customer->otp = null;
					
					if ($customer->save()){
						return redirect('/login')->with(['notification' => 'false']);
						//return redirect('/stock')->with(['notification' => 'true']);
					};
				}
			}
		}
		
		return redirect('/login')->with(['notification' => 'false']);
		//return Auth::check();
	}
	
	public function logout(Request $request)
    {
		Auth::guard('customer')->logout();
		Auth::guard('web')->logout();
		$request->session()->flush();
        $request->session()->regenerate();
		return '<script language="javascript">alert("Berhasil");window.location.href = "/login";</script>';
	}
	public function verify(Request $request)
    {
		$remember = $request->input("remember") ? true : false;
		if( str_contains($request->input('email'), '@') ) {
			$userdata = array( 'email' => $request->input('email') , 'password' => $request->input('password') );
		}else{
			$userdata = array( 'phone' => $request->input('email') , 'password' => $request->input('password') );
		}
		//$userdata = User::where('email', $request->email) ->where('password', $request->password) ->first();
		//$customer = Customer::where('email', $request->input('email') )->first(); 
		//if( ! Hash::check( $customer->password , $request->input('password') ) )
		if ( Auth::guard('customer')->attempt( $userdata , false ) )
		//if ( $userdata )
          {
		  //Auth::login($userdata, $remember);
          return redirect('/booking');
          }
          else { return '<script language="javascript">alert("Gagal!");window.location.href = "/login";</script>'; }
        return json_encode(["Halo" , Auth::check() ]);
    }
	
    public function show(Request $request)
    {
		$data["user"] = Auth::user();
		$data["route"] = "customer";
		$data["customer"] = Customer::all();
		if ( session()->get('notification') ) {
			$data['notification'] = session()->get('notification');
			session()->forget('notification');
		}
		return view('index',$data);
	}
	
	public function detail(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			$customer = Customer::where('id',$id)->first(); 
			return json_encode($customer);
		}
	}
	
	public function edit(Request $request, $id)
    {
		$id = intval($id);
		if($id > 0){
			$validatedData = $request->validate([
				'name' => ['required', 'max:255'],
				'address' => ['required'],
				'email' => ['required'],
				'phone' => ['required'],
				'vehicle_type' => ['required'],
				'license_plate' => ['required'],
			]);
			
			$customer = Customer::find($id);
			$customer->name = $request->input("name");
			$customer->address = $request->input("address");
			if ($request->input("email") != null){$customer->email = $request->input("email");}
			if($request->input("phone") != null){$customer->phone = $request->input("phone");}
			$customer->vehicle_type = $request->input("vehicle_type");
			$customer->license_plate = $request->input("license_plate");
			
			if ($customer->save()){
				return redirect('/customer')->with(['notification' => 'true']);
			};
			return redirect('/customer')->with(['notification' => 'false']);
		}
	}
	
	public function remove(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			$customer = Customer::find($id);
			if ($customer->delete()){
				return redirect('/customer')->with(['notification' => 'true']);
			};
			return redirect('/customer')->with(['notification' => 'false']);
		}
	}
	
	public function forgotpass(Request $request)
    {
		//echo $request->get('email'); die;
		if ( $request->get('email') != null ){
			$customer = Customer::where('email', $request->get('email') )->first();
			if($customer){
				$data["emailTo"] = $request->get('email');
				$data["otp"] = sprintf("%04d", mt_rand(1, 9999));
				$customer->otp = $data["otp"];
				$customer->save();
				
				Mail::send(['html' => 'mail.otp'], $data, function ($message) use ($data) {
					$message->to( $data["emailTo"] , 'You')->subject('Kode OTP Forgot Pass');
					$message->from(env("MAIL_FROM_ADDRESS"), 'System_Service');
				});
				return redirect('/newpass?email='.$request->get('email'));
			}
		}
		return '<script language="javascript">alert("Gagal!");window.location.href = "/login";</script>';
	}
	
	public function newpass(Request $request)
    {
		$data["email"] = $request->get('email');
		return view('newpass' , $data);
	}
	
	public function verifynewpass(Request $request)
    {
		//echo $request->get('email'); die;
		if ( $request->input('email') != null ){
			$customer = Customer::where('email', $request->get('email') )->first();
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
