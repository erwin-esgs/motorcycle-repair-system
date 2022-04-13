<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Stock;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function dashboardAdmin(Request $request ){
		$data["user"] = Auth::guard('web')->user() ;
		$data["route"] = "dashboard";
		$data["booking"] = Booking::whereMonth('created_at' , intval(date('m')) )->get() ;
		$data["transaction"] = Transaction::all() ;
		$data["customer"] = Customer::all() ;
		$data["stock"] = Stock::all() ;
		return view("index",$data);
	}
	
	public function dashboard(Request $request ){
		$data["user"] = Auth::guard('customer')->user() ;
		$data["route"] = "dashboard";
		$data["booking"] = Booking::where("id_customer" , $data["user"]->id )->where("status" , "<" ,2 )->get() ;
		$data["transaction"] = Transaction::select(
			'transaction.id', 
			'transaction.id_booking',
			'transaction.id_mechanic',
			'transaction.stock_used',
			'transaction.status',
			'booking.id_customer',
			'booking.booking_date',
			'booking.complaint',
			'booking.service_type'
			)->join('booking', 'transaction.id_booking', '=', 'booking.id')->where('booking.id_customer' , $data["user"]['id'])->get() ;
		return view("index",$data);
	}
}
