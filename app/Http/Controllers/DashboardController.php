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
        $bulan_ini = date("m");
        $tahun_ini = date("Y");
        $nik = Auth::guard('employee')->user()->nik;
        $presensi_hari_ini = DB::table("attendances")->where("nik", $nik)->where("attendance_date", $hari_ini)->first();
        $histori_bulan_ini = DB::table("attendances")
        ->whereRaw('MONTH(attendance_date)="' .  $bulan_ini . '"')
        ->whereRaw('YEAR(attendance_date)="' .  $tahun_ini . '"')
        ->orderBy('attendance_date')
        ->get();
        return view('dashboard.dashboard', compact('presensi_hari_ini', 'histori_bulan_ini'));
    }
}
