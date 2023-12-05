<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DivisiController extends Controller
{
    public function index() {

        $divisi = DB::table('divisi')->orderBy('kode_divisi')->get();
        $sapa = "";
        $time = date('H:i:s');
        if ($time >= '03:00:00' && $time <= '10:00:59') {
            $sapa = 'Selamat Pagi';
            // $time_kerja = 'Masuk';
        } elseif ($time >= '10:01:00' && $time <= '15:00:59') {
            $sapa = 'Selamat Siang';
            // $time_kerja = 'Pulang';
        } elseif ($time >= '15:01:00' && $time <= '18:00:59') {
            $sapa = 'Selamat Sore';
        } else {
            $sapa = 'Selamat Malam';
        }
        return view('divisi.index',compact('sapa', 'divisi'));
    }

    public function store(Request $request){
        $kode_divisi = $request->kode_divisi;
        $nama_divisi = $request->nama_divisi;
        $data = [
            $kode_divisi  => $kode_divisi,
            $nama_divisi  => $nama_divisi
        ];

        $simpan = DB::table('divisi')->insert($data);
        if($simpan) {
            return Redirect::back()->with(['success' => 'Yey.. Data karyawan berhasil diubah ^_^']);
        }else {
            return Redirect::back()->with(['error' => 'Yah.. Update datanya gagal ^_^!']);
        }
    }
}
