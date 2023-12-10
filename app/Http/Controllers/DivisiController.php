<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DivisiController extends Controller
{
    public function index(Request $request) {

        $nama_divisi = $request->nama_divisi;
        $query = Divisi::query();
        $query->select('*');
        if (!empty($request->nama_divisi)) {
            $query->where('nama_divisi', 'like', '%' . $nama_divisi . '%');
        }
        $divisi = $query->get();
        // $divisi = DB::table('divisi')->orderBy('kode_divisi')->get();
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
            'kode_divisi' => $kode_divisi,
            'nama_divisi' => $nama_divisi
        ];


        $simpan = DB::table('divisi')->insert($data);
        if($simpan) {
            return Redirect::back()->with(['success' => 'Yey.. Data karyawan berhasil diubah ^_^']);
        }else {
            return Redirect::back()->with(['warning' => 'Yah.. Update datanya gagal ^_^!']);
        }
    }

    public function edit(Request $request){
        $kode_divisi =$request->kode_divisi;
        $divisi = DB::table('divisi')->where('kode_divisi', $kode_divisi)->first();
        return view('divisi.edit', compact('divisi'));
    }

    public function update($kode_divisi, Request $request){
        $nama_divisi = $request->nama_divisi;
        $data = [
            'nama_divisi' => $nama_divisi
        ];

        $update = DB::table('divisi')->where('kode_divisi', $kode_divisi)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'data berhasil diupdate']);
        }else{
            return Redirect::back()->with(['warning' => 'data gagal diupdate']);
        }
    }

    public function delete($kode_divisi) {
        $delete = DB::table('divisi')->where('kode_divisi', $kode_divisi)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'data berhasil dihapus']);
        }else{
            return Redirect::back()->with(['success' => 'data gagal diupdate']);
        }
    }
}
