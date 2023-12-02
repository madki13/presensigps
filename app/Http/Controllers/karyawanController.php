<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class karyawanController extends Controller
{
    public function index()
    {
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')
        ->join('divisi', 'karyawan.kode_divisi', '=', 'divisi.kode_divisi')
        ->get();
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
        return view('karyawan.index', compact('sapa', 'karyawan'));
    }
}
