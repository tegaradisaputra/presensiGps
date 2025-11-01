<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $hari_ini = date("Y-m-d");
        $bulan_ini = date("m") * 1;
        $tahun_ini = date("Y");
        $nik = Auth::guard('employee')->user()->nik;
        $presensi_hari_ini = DB::table("attendances")->where("nik", $nik)->where("attendance_date", $hari_ini)->first();
        $histori_bulan_ini = DB::table("attendances")
        ->where('nik', $nik)
        ->whereRaw('MONTH(attendance_date)="' .  $bulan_ini . '"')
        ->whereRaw('YEAR(attendance_date)="' .  $tahun_ini . '"')
        ->orderBy('attendance_date')
        ->get();
        $rekap_presensi = DB::table('attendances')
        ->selectRaw('COUNT(nik) as jml_hadir, SUM(IF(time_in > "07:00:00", 1, 0)) as jml_terlambat')
        ->where('nik', $nik)
        ->whereMonth('attendance_date', $bulan_ini)
        ->whereYear('attendance_date', $tahun_ini)
        ->first();
        $leaderboard = DB::table('attendances')
        ->join('employees', 'attendances.nik', 'employees.nik')
        ->where('attendance_date', $hari_ini)
        ->orderBy('time_in')
        ->get();
        $nama_bulan = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        return view('dashboard.dashboard', compact('presensi_hari_ini', 'histori_bulan_ini', 'nama_bulan', 'bulan_ini', 'tahun_ini', 'rekap_presensi', 'leaderboard'));
    }
}
