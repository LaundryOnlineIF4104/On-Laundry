<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use App\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class editOrderController extends Controller
{
    public function orderList(){
        if(Session::get('tipe') == 2){              
            $order = DB::table('orders')
                ->join('payments', 'orders.id', '=', 'payments.order_id')
                ->select('orders.id AS id', 'orders.nama','orders.alamat','orders.jenis_laundry','orders.notelp', 'orders.parfum', 'orders.berat', 'orders.active', 'orders.proses','payments.metode_pembayaran', 'payments.total_harga', 'payments.paid')
                ->get();              
            return view('orderList', compact('order'));
        }
        else{
            return redirect('/');
        }
    }

    public function editOrder($id){
        if(Session::get('tipe') == 2){
            $order = Order::select('*')->where('id','=', $id)->first();         
            $services = Service::all();                                           
            return view('editOrder', compact('services', 'order'));
        }
        else{
            return redirect('/');
        }
    }

    public function update(Request $request){
        $this->validate($request,[
            'id' => 'required|numeric',
            'nama' => 'required|min:1|max:20',
            'jenislaundry' => 'required|numeric',
            'alamat' => 'required|min:8',
            'berat' => 'required|numeric',
            'proses' => 'required|numeric',
            'parfum' => 'required|max:1'            
        ],[
            'id.required' => ' ID harus diisi.',
            'id.numeric' => 'ID harus numerik.',
            'jenislaundry.required' => ' Pilih salah satu Jenis Laundry.',
            'jenislaundry.numeric' => 'Jenis Laundry harus numerik.',
            'nama.required' => ' Nama harus diisi.',
            'nama.max' => 'Nama tidak lebih dari 20 karakter',
            'nama.min' => 'Nama harus lebih dari 1 karakter',
            'alamat.required' => ' Alamat harus diisi.',
            'alamat.min' => 'Alamat harus lebih dari 8 karakter',
            'parfum.required' => ' Pilih salah satu parfum',
            'parfum.max' => 'Parfum tidak lebih dari 1 karakter',
            'berat.required' => ' Berat harus diisi.',
            'berat.numeric' => 'Berat harus numerik.',
            'proses.required' => ' Proses harus diisi'
        ]);
        $jenislaundry = Service::select('jenis_laundry')->where('id', '=', $request->jenislaundry)->first()->jenis_laundry;  
        $price = Service::select('price')->where('id', '=', $request->jenislaundry)->first()->price;                
        DB::table('orders')->where('id',$request->id)->update([
            'nama' => $request->nama,
            'service_id' => $request->jenislaundry,
            'alamat' => $request->alamat,
            'jenis_laundry' => $jenislaundry,
            'parfum' => $request->parfum,
            'price' => $price,
            'berat' => $request->berat,
            'proses' => $request->proses,           
        ]);

        return redirect('/orderList')->with('alert-success','Pesanan Berhasil Diedit');
    }

    public function deleteOrder($id){
        if(Session::get('tipe') == 2){
            DB::table('payments')->where('order_id','=', $id)->delete();
            DB::table('orders')->where('id','=', $id)->delete();
            return redirect('/orderList')->with('alert-success','Pesanan Berhasil Dihapus');
        }
        else{
            return redirect('/');
        }
    }

    public function paidOrder($id){
        if(Session::get('tipe') == 2){
            DB::table('payments')->where('order_id','=', $id)->update([
                'paid' => '1'
            ]);
            return redirect('/orderList')->with('alert-success','Pesanan Berhasil diset Lunas!');
        }
        else{
            return redirect('/');
        }
    }

    public function deactivate($id){
        if(Session::get('tipe') == 2){            
            DB::table('orders')->where('id','=', $id)->update(['active' => "0"]);
            return redirect('/orderList')->with('alert-success','Pesanan Berhasil di set Selesai');
        }
        else{
            return redirect('/');
        }
    }
}