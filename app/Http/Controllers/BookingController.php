<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Swithcer;

class BookingController extends Controller
{
	public function all(Request $request , $notification=false)
    {
		$data["user"] = Auth::guard('web')->user();
		$data["route"] = "booking";
		$data["booking"] = Booking::all() ;
		$data["todayBooking"] = Booking::where("booking_date" , date("Y-m-d") )->where("status" , 1 )->get() ;
		$data["mechanic"] = User::where('role',1)->get() ;
		if ( session()->get('notification') ) {
			$data['notification'] = session()->get('notification');
			session()->forget('notification');
		}
		return view('index',$data);
		//return Auth::check();
	}
	
    public function show(Request $request , $notification=false)
    {
		$data["user"] = Auth::guard('customer')->user();
		$data["route"] = "booking";
		$data["booking"] = Booking::where("id_customer" , $data["user"]->id )->where("status" , "<" ,2 )->get() ;
		$data["todayBooking"] = Booking::where("booking_date" , date("Y-m-d") )->where("status" , 1 )->get() ;
		//$data["todayBooking"] = Booking::whereDate("created_at" , date("Y-m-d") )->where("status" , 1 )->get() ;
		//var_dump($data["todayBooking"]);die;
		$data["mechanic"] = User::where("role" , 1 )->get() ;
		
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
			'date' => ['required'],
			//'time' => ['required'],
			'complaint' => ['required'],
			'service_type' => ['required'],
		]);
		
		if($validatedData){
			$booking = new Booking();
			//$booking->booking_date = $request->input("date") .' '. $request->input("time").':00';
			$booking->booking_date = $request->input("date");
			$booking->id_customer = Auth::guard('customer')->user()->id;
			$booking->complaint = $request->input("complaint");
			$booking->service_type = $request->input("service_type");
			$booking->status = 1;
			
			$data["booking_date"] = $booking->booking_date;
			$data["id_customer"] = $booking->id_customer;
			$data["complaint"] = $booking->complaint;
			$data["service_type"] = $booking->service_type;
			$data["emailTo"] = Auth::guard('customer')->user()->email;
			
			if ($booking->save()){
			
				Mail::send(['html' => 'mail.register'], $data, function ($message) use ($data) {
					$message->to( $data["emailTo"] , 'You')->subject
							('Registerasi Berhasil');
					$message->from(env("MAIL_FROM_ADDRESS"), 'System_Service');
				});
				
				return redirect('/booking')->with(['notification' => 'true']);
			};
		}
		return redirect('/booking')->with(['notification' => 'false']);
		//return Auth::check();
	}
	
	public function edit(Request $request , $id)
    {
		$validatedData = $request->validate([
			'date' => ['required'],
			//'time' => ['required'],
			'complaint' => ['required'],
			'service_type' => ['required'],
		]);
		
		if($validatedData){
			$booking = Booking::where('id' , $id)->first();
			if($booking){
				$booking->booking_date = $request->input("date") .' '. $request->input("time");
				$booking->id_customer = Auth::guard('customer')->user()->id;
				$booking->complaint = $request->input("complaint");
				$booking->service_type = $request->input("service_type");
				
				if ($booking->save()){
					return redirect('/booking')->with(['notification' => 'true']);
				};
			}
		}
		return redirect('/booking')->with(['notification' => 'false']);
		//return Auth::check();
	}
	
	public function remove(Request $request , $id)
    {	
		$id = intval($id);
		if($id > 0){
			
			$booking = Booking::find($id);
			if ($booking->delete()){
				return redirect('/booking')->with(['notification' => 'true']);
			};
		}
		return redirect('/booking')->with(['notification' => 'false']);
	}
	
	public function accept(Request $request )
    {	
		$id_booking = intval($request->id_booking);
		
		if($id_booking > 0){
			$booking = Booking::find($id_booking);
			if( $booking->status == 1 ){
				$booking->status = 2;
				$saved = $booking->save();
				
				$booking->id_mechanic = intval($request->id_mechanic);
				$TransactionController = new TransactionController();
				if( $TransactionController->add( $request , $booking ) && $saved )return redirect('/allBooking')->with(['notification' => 'true']);
			}
		}
		return redirect('/allBooking')->with(['notification' => 'false']);
		
	}
	
	public function reject(Request $request , $id )
    {	
		$id_booking = intval($id);
		
		if($id_booking > 0){
			$booking = Booking::find($id_booking);
			if( $booking->status == 1 ){
				$booking->status = 0;
				$saved = $booking->save();
				
				if( $saved )return redirect('/allBooking')->with(['notification' => 'true']);
			}
		}
		return redirect('/allBooking')->with(['notification' => 'false']);
		
	}
	
	/*
	public function ch_status(Request $request , $id , $status)
    {
		$id = intval($id);
		$status = intval($status);
		if($id > 0 && $status > -1 ){
			$booking = Booking::find($id);
			if( $booking->status == 1){
				$booking->status = $status;
				if ($booking->save()){
					return redirect('/allBooking')->with(['notification' => 'true']);
				}
			}
		}
		return redirect('/allBooking')->with(['notification' => 'false']);
	}
	*/
	
}
