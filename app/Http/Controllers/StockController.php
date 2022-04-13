<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function show(Request $request , $notification=false)
    {
		$data["user"] = Auth::user();
		$data["route"] = "stock";
		$data["stock"] = Stock::all();
		
		if ( session()->get('notification') ) {
			$data['notification'] = session()->get('notification');
			session()->forget('notification');
		}
		return view('index',$data);
		//return Auth::check();
	}
	
	public function add(Request $request)
    {
		$validatedData = $request->validate([
				'name' => ['required', 'max:255'],
				'qty' => ['required'],
				'code' => ['required'],
				//'price' => ['required'],
			]);
		if($validatedData){
			$stock = new Stock();
			$stock->name = $request->input("name");
			$stock->qty = $request->input("qty");
			$stock->code = $request->input("code");
			if($request->input("price") != null ){$stock->price = $request->input("price");} 
			else {$stock->price = 0;} 
			
			if ($stock->save()){
				return redirect('/stock')->with(['notification' => 'true']);
			};
		}
		return redirect('/stock')->with(['notification' => 'false']);
		//return Auth::check();
	}
	
	public function detail(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			$stock = Stock::where('id',$id)->first(); 
			return json_encode($stock);
		}
	}
	
	public function edit(Request $request, $id)
    {
		$id = intval($id);
		if($id > 0){
			$validatedData = $request->validate([
				'name' => ['required', 'max:255'],
				'qty' => ['required'],
				'code' => ['required'],
				//'price' => ['required'],
			]);
			
			$stock = Stock::find($id);
			$stock->name = $request->input("name");
			$stock->qty = $request->input("qty");
			$stock->code = $request->input("code");
			if($request->input("price") != null ) $stock->price = $request->input("price");
			
			if ($stock->save()){
				return redirect('/stock')->with(['notification' => 'true']);
			};
			return redirect('/stock')->with(['notification' => 'false']);
		}
	}
	
	public function remove(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			$stock = Stock::find($id);
			if ($stock->delete()){
				return redirect('/stock')->with(['notification' => 'true']);
			};
			return redirect('/stock')->with(['notification' => 'false']);
		}
	}
}
