<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
	public function add(Request $request , $booking)
    {
		$transaction = new Transaction();
		$transaction->id_booking = $booking->id;
		$transaction->id_mechanic = $booking->id_mechanic;
		$transaction->stock_used = "[]";
		$transaction->status = 1;
		
		return $transaction->save();
		//return Auth::check();
	}
	
    public function show(Request $request , $notification=false)
    {
		$data["user"] = Auth::guard('web')->user();
		$data["route"] = "transaction";
		if( $data["user"]["role"] == 0 ){
			$data["transaction"] = Transaction::select('transaction.*','booking.*',"transaction.id as id" ,"transaction.status as status" , "customer.license_plate")
									->join("booking" , 'transaction.id_booking', '=', 'booking.id')
									->join("customer" , 'booking.id_customer', '=', 'customer.id')
									->get() ;
		}else{
			$data["transaction"] = Transaction::select('transaction.*','booking.*',"transaction.id as id" ,"transaction.status as status" , "customer.license_plate")
									->join("booking" , 'transaction.id_booking', '=', 'booking.id')
									->join("customer" , 'booking.id_customer', '=', 'customer.id')
									->where('id_mechanic' , $data["user"]['id'])
									->get() ;
		}
		
		foreach ($data["transaction"] as $key1 => $value){
			$arr = [];
			$stock_used = json_decode( $value->stock_used );
			// var_dump($stock_used); die;
			foreach ( $stock_used as $value1){
				foreach ( $value1 as $key2 => $value2){
					//var_dump($key2); die;
					$stock = DB::table('stock')->where( 'id' , $key2 )->first();
					if($stock){
						$stock->used = $value2;
						array_push($arr, $stock );
					}
				}
			}
			$data["transaction"][$key1]->stock_used = $arr;
		}
		//var_dump( $data["transaction"] ); die;
		$data["stock"] = Stock::all();
		$data["mechanic"] = User::where('role',1)->get() ;
		
		if ( session()->get('notification') ) {
			$data['notification'] = session()->get('notification');
			session()->forget('notification');
		}
		return view('index',$data);
		//return Auth::check();
	}
	
	public function showCustomer(Request $request , $notification=false)
    {
		$data["user"] = Auth::guard('customer')->user();
		$data["route"] = "transaction";
		$data["transaction"] = Transaction::select(
			'transaction.id', 
			'transaction.id_booking',
			'transaction.id_mechanic',
			'transaction.stock_used',
			'transaction.status',
			'transaction.service_price',
			'booking.id_customer',
			'booking.booking_date',
			'booking.complaint',
			'booking.service_type',
			"customer.license_plate"
			)->join('booking', 'transaction.id_booking', '=', 'booking.id')
			->join("customer" , 'booking.id_customer', '=', 'customer.id')
			->where('booking.id_customer' , $data["user"]['id'])->get() ;
		
		foreach ($data["transaction"] as $key1 => $value){
			$arr = [];
			$stock_used = json_decode( $value->stock_used );
			// var_dump($stock_used); die;
			foreach ( $stock_used as $value1){
				foreach ( $value1 as $key2 => $value2){
					//var_dump($key2); die;
					$stock = DB::table('stock')->where( 'id' , $key2 )->first();
					if($stock){
					$stock->used = $value2;
					array_push($arr, $stock );
					}
				}
			}
			$data["transaction"][$key1]->stock_used = $arr;
		}
		
		$data["stock"] = Stock::all();
		$data["mechanic"] = User::where('role',1)->get() ;
		
		if ( session()->get('notification') ) {
			$data['notification'] = session()->get('notification');
			session()->forget('notification');
		}
		return view('index',$data);
		//return Auth::check();
	}
	
	public function insertStock(Request $request , $notification=false)
    {
		$id_transaction = intval($request->input('id'));
		if( $id_transaction > 0 ){
			$arr = [];
			foreach($request->all() as $id => $qty){
				if( intval($id) > 0 ){
					$stock = Stock::where('id',$id)->first() ;
					if($qty < $stock->qty){
						$stock->qty = $stock->qty - $qty;
						if( $stock->save() )array_push($arr,[$id => $qty]);
					}
				}
			}
			$transaction = Transaction::where('id',$id_transaction)->first();
			$transaction->status = 3;
			$transaction->stock_used = json_encode($arr);
			if( $transaction->save() )return redirect('/transaction')->with(['notification' => 'true']);
		}
		return redirect('/transaction')->with(['notification' => 'false']);
	}
	
	
	public function ch_status(Request $request)
    {
		$id = intval($request->post("id"));
		//$status = intval($request->post("status"));
		$stock_used_price = intval($request->post("stock_used_price"));
		$service_price = intval($request->post("service_price"));
		if($id > 0 && $stock_used_price != null && $service_price != null ){
			$transaction = Transaction::find($id);
			$transaction->status = 4;
			$transaction->service_price = $service_price ;
			if ($transaction->save()){
				return redirect('/transaction')->with(['notification' => 'true']);
			}
		}
		return redirect('/transaction')->with(['notification' => 'false']);
	}
}
