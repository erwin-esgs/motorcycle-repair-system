<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $data["user"] = Auth::user();
		$data["route"] = "user";
		$data["users"] = User::all();
		if ( session()->get('notification') ) {
			$data['notification'] = session()->get('notification');
			session()->forget('notification');
		}
		return view('index',$data);
	}
	
	public function add(Request $request)
    {
	//if($request->input("name") != null && $request->input("email") != null && $request->input("password") != null && $request->input("role") != null){
		$validatedData = $request->validate([
				'name' => ['required', 'max:255'],
				'email' => ['required'],
				'password' => ['required'],
				'role' => ['required'],
			]);
        if($validatedData){
            $user = new User();
            $user->name = $request->input("name");
            $user->email = $request->input("email");
            $user->password = Hash::make($request->input("password"));
            $user->role = $request->input("role");
            
            if ($user->save()){
                return redirect('/user')->with(['notification' => 'true']);
            };
        }
	//}
		return redirect('/user')->with(['notification' => 'false']);
		//return Auth::check();
	}
	
	public function detail(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			$user = User::where('id',$id)->first(); 
			return json_encode($user);
		}
	}
	
	public function edit(Request $request, $id)
    {
		$id = intval($id);
		if($id > 0){
			$validatedData = $request->validate([
				'name' => ['required', 'max:255'],
				'email' => ['required'],
				//'password' => ['required'],
				'role' => ['required'],
			]);
            if($validatedData){
                $user = User::find($id);
                $user->name = $request->input("name");
                $user->email = $request->input("email");
                if($request->input("password") != null && $request->input("password") != '')$user->password = Hash::make($request->input("password"));
                $user->role = $request->input("role");
                
                if ($user->save()){
                    return redirect('/user')->with(['notification' => 'true']);
                };
            }
			return redirect('/user')->with(['notification' => 'false']);
		}
	}
	
	public function remove(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			$user = User::find($id);
			if ($user->delete()){
				return redirect('/user')->with(['notification' => 'true']);
			};
			return redirect('/user')->with(['notification' => 'false']);
		}
	}
}
