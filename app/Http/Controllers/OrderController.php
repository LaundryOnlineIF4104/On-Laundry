<?php

namespace App\Http\Controllers;

use App\Service;
use App\Order;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //      
    
    public function order(){        
        if(Session::get('tipe') == 3){ 
            $orders = Order::where('user_id', Session::get('id'))->where('active','1')->first();            
            if($orders){                
                $payment = Payment::where('order_id',$orders->id)->first();                                                                                                                                                                    
                    return view('progressOrder', compact('orders', 'payment'));                                                                                               
            }   
            else{        
                $services = Service::all();
                return view('order', compact('services'));
            }
        }
        else
            return view('index');
    }

    public function postOrder(Request $request){      
        $jenislaundry = Service::select('jenis_laundry')->where('id', '=', $request->jenislaundry)->first()->jenis_laundry;  
        $price = Service::select('price')->where('id', '=', $request->jenislaundry)->first()->price;
        $Order = new Order();
        $Order->user_id = Session::get('id');
        $Order->service_id = $request->jenislaundry;
        $Order->nama = $request->name;
        $Order->jenis_laundry = $jenislaundry;
        $Order->alamat = $request->alamat;
        $Order->parfum = $request->parfum; 
        $Order->notelp = $request->notelp;   
        $Order->price = $price;
        $Order->active = 1;
        $Order->berat = 0;
        $Order->proses = 1;      

        $Order->save();

        $orders = Order::where('user_id', Session::get('id'))->where('active','1')->first(); 

        if($orders->id){
            $Payment = new Payment();
            $Payment->order_id = $orders->id;            

            $Payment->save();
        }

        $payment = Payment::where('order_id',$orders->id)->first();       
        return view('progressOrder', compact('orders', 'payment'));
    }

}
