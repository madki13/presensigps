<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();

        // $rekappresensi = DB::table('presensi')
        //     ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00", 1, 0)) as jmlterlambat')
        //     ->where('nik', $nik)
        //     ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        //     ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
        //     ->first();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini'));
    }

    public function  dashboardadmin(){
        return view('dashboard.dashboardadmin');
    }
}
