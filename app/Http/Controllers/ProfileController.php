<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(){
        return view('profile');
    }

    public function editProfile(){
        $User = User::where('id', Session::get('id'))->first();      
        return view('editprofile', compact('User'));
    }

    public function postEditProfile(Request $request){
        $User = User::where('id', Session::get('id'))->update([
            'name' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'notelp' => $request->notelp          
        ]);        
        if($request->password){
            $this->validate($request,[                
                'password' => 'min:8|max:20',
                'confirmpass' => 'same:password'
            ]);
            $User = User::where('id', Session::get('id'))->update([
                'password' => bcrypt($request->password)
            ]);
        }
        if($request->file){
            $this->validate($request,[ 
                'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'data_file';
            $file->move($tujuan_upload,$nama_file);
            $User = User::where('id', Session::get('id'))->update([
                'file' => $nama_file
            ]);
        }
        Session::put('name', $request->nama);
        Session::put('email',$request->email);
        Session::put('notelp',$request->notelp);
        Session::put('alamat',$request->alamat);
        return redirect('editprofile')->with('alert-success','Profil Berhasil Diubah');
    }

    public function proses_upload(Request $request){		
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');
 
		$nama_file = time()."_".$file->getClientOriginalName();
 
      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file';
		$file->move($tujuan_upload,$nama_file);
 
		Gambar::create([
			'file' => $nama_file,
			'keterangan' => $request->keterangan,
		]);
 
		return redirect()->back();
    }
}
