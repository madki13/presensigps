<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function create()
    {
        // Untuk Absensi
        $hari_ini = date("Y-m-d");
        $jam = NULL;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hari_ini)->where('nik', $nik)->count();
        return view('presensi.create', compact('cek'));

        // return view('presensi.create');
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $null = NULL;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $jam_image = date("H-i-s");
        $latitudekantor = -6.254615690350658;
        $longitudekantor =  107.01311119395025;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $keterangan = $request->keterangan;
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . ".jam" . $jam_image;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;


        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        // if ($cek > 0) {
        //     $ket = "out";
        // } else {
        //     $ket = "in";
        // }

        if ($radius > 20) {
            echo "error| Maaf anda berada diluar radius, jarak anda " . $radius . " meter dari kantor |";
        } else {

            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                    'keterangan_out' => $keterangan
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if ($update) {
                    echo "success|Terimakasih, Hati-Hati dijalan|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf gagal absen, Hubungi Tim IT|out";
                }
            } else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                    'keterangan_in' => $keterangan

                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Terimakasih, Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf gagal absen, Hubungi Tim IT|in";
                }
            }
        }



        // Untuk In Out
        // $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->where('jam_out', $null)->count();
        // if($cek == 0){
        //     $data = [
        //         'nik' => $nik,
        //         'tgl_presensi' => $tgl_presensi,
        //         'jam_in' => $jam,
        //         'foto_in' => $fileName,
        //         'lokasi_in' => $lokasi,
        //         'keterangan_in' => $keterangan
        //     ];
        //     $simpan = DB::table('presensi')->insert($data);
        //     if($simpan){
        //         echo "success|Terima Kasih, Silahkan dilanjut Guys ^_^|in";
        //         Storage::put($file, $image_base64);
        //     }else{
        //         echo "error|Waduh ada masalah nih, hubungi IT guys !|in" ;
        //         }
        //     }else{
        //     $data_out = [
        //         'jam_out' => $jam,
        //         'foto_out' => $fileName,
        //         'lokasi_out' => $lokasi,
        //         'keterangan_out' => $keterangan
        //     ];
        //     $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->orderBy('id', 'desc')->limit(1)->update($data_out);
        //     if($update){
        //         echo "success|Terima Kasih, Hati-hati dijalan Guys ^_^|out";
        //         Storage::put($file, $image_base64);
        //     }else{
        //         echo "error|Waduh ada masalah nih, hubungi IT guys !|out" ;
        //     }
        // }
    }

    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request){

        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto,
            ];
        }

        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Yey.. Data karyawan berhasil diubah ^_^']);
        } else {
            return Redirect::back()->with(['error' => 'Yah.. Update datanya gagal ^_^!']);
        }
    }

    public function monitoring()
    {
        $hari_ini = date("Y-m-d");
        $hari = date("d");
        $bulan_ini = date("m");
        $tahun_ini = date("Y");
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
        return view('presensi.monitoring', compact('sapa'));
    }

    public function getpresensi(Request $request)
    {
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
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'nama_lengkap', 'nama_divisi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->join('divisi', 'karyawan.kode_divisi', '=', 'divisi.kode_divisi')
            ->where('tgl_presensi', $tanggal)
            ->get();

        return view('presensi.getpresensi', compact('sapa', 'presensi'));
    }

    public function histori()
    {
        $hari_ini = date("Y-m-d");
        $hari = date("d");
        $bulan_ini = date("m");
        $tahun_ini = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensi_hari_ini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hari_ini)->latest();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $history_hari_ini = DB::table('presensi')->where('nik', $nik)
            ->whereRaw('DAY(tgl_presensi)= "' . $hari . '"')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan_ini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun_ini . '"')
            ->orderBy('tgl_presensi')
            ->get()
            ->sortBy('jam_in');
        return view('presensi.histori', compact('presensi_hari_ini', 'karyawan', 'history_hari_ini'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        echo $bulan . "dan" . $tahun;
    }
}
