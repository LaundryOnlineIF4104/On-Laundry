@extends('layout.default')

@section('title', 'Order | On-Laundry')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/order.css')}}"> 
@endsection

@section('content')
<section>
    <div class="container">
        <h2 style="color: #2b3990;">Pesan Laundry</h2>
        <div class="row">
            <div class="col">
                <div class="card" style="width: auto;">
                    <div class="card-body form-order">
                        <form method="POST" action="/order">
                        <h4 class="card-title" style="color: #2b3990;">Pilih Jenis Laundry</h4>
                        <hr style="background-color: #2b3990;">
                        <section style="height: 40px;">
                            <div class="row">
                                <div class="col">
                                    <div class="custom-control custom-radio"><input class="custom-control-input" name="jenislaundry" type="radio" onclick="setprice('Rp. 20,000')" id="formCheck-1"><label class="custom-control-label" for="formCheck-1">Reguler</label></div>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-radio"><input class="custom-control-input" name="jenislaundry" type="radio" onclick="setprice('Rp. 30,000')" id="formCheck-2"><label class="custom-control-label" for="formCheck-2">Premium</label></div>
                                </div>
                            </div>
                        </section>
                        <h4 class="card-title" style="color: #2b3990;">Detail Pengambilan dan Pengantaran</h4>
                        <hr style="background-color: #2b3990;">
                        <h5 class="text-muted card-subtitle mb-2">Nama Lengkap</h5><input name="namalengkap" type="text" style="margin-bottom: 15px;width: 350px;" value="{{Session::get('name')}}">
                        <h5 class="text-muted card-subtitle mb-2">Nomor Telepon</h5><input name="notelp" type="text" style="margin-bottom: 15px;width: 350px;" value="{{Session::get('notelp')}}">
                        <h5 class="text-muted card-subtitle mb-2">Parfum</h5>
                        <div class="dropdown" style="margin-bottom: 15px;">
                            <button id="option" class="btn dropdown-toggle border rounded border-dark" data-toggle="dropdown" aria-expanded="false" type="button" style="width: 192px;">Pilih Parfum </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" role="presentation" href="javascript:return false;">Parfum X</a></li>
                                <li><a class="dropdown-item" role="presentation" href="javascript:return false;">Parfum Y</a></li>
                                <li><a class="dropdown-item" role="presentation" href="javascript:return false;">Parfum Z</a></li>
                            </ul>
                        </div>
                        <h5 class="text-muted card-subtitle mb-2">Alamat</h5><textarea name="alamat" cols="50" rows="5" required="" style="margin-bottom: 15px;"></textarea>
                        <h5 class="text-muted card-subtitle mb-2">Waktu Pengambilan</h5><input id="waktupengambilan" name="pengambilan" type="date" required="" style="margin-bottom: 15px;">
                        <h5 class="text-muted card-subtitle mb-2">Waktu Pengantaran</h5><input id="waktupengantaran" name="pengantaran" type="date" readonly="">
                        <hr style="background-color: #2b3990;">
                        <div class="d-block">
                            <h4 class="d-inline-flex"  style="color: #2b3990;">Harga</h4>
                            <h4 class="d-inline-flex float-right" id="price" style="color: #2b3990;">Rp.&nbsp;</h4>
                        </div><button class="btn float-right" id="btn-lanjut" type="submit" style="margin-top: 15px;">Lanjut</button>
                    </form>
                    </div>                    
                    </div>
            </div>
            <div class="col-xl-4">
                <div class="card" style="width: auto;">
                    <div class="card-body">
                        <h4 class="card-title" style="color: #2b3990;">Detail Jasa Laundry</h4>
                        <h5 class="text-muted card-subtitle mb-2">Jenis Laundry</h5>
                        <hr style="background-color: #2b3990;">
                        <h5 class="text-muted card-subtitle mb-2">Laundry Reguler</h5>
                        <p>Durasi pengerjaan 3-4 hari</p>
                        <p>Harga Rp. 20,000/kg</p>
                        <h5 class="text-muted card-subtitle mb-2">Laundry Premium</h5>
                        <p>Durasi pengerjaan 2 hari</p>
                        <p>Harga Rp. 30,000/kg</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{  asset('js/order.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".dropdown-menu li a").click(function(){
            $("#option").text($(this).text());
            });
        });
    </script>
@endsection