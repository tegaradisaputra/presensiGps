<?php

namespace App\Http\Controllers;

// use App\Models\Presensi;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cek = DB::table('attendances');
        return view('presensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $nik = Auth::guard('employee')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lokasi = $request->lokasi;
        $image = $request->image;

        $folderPath = "uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi;

        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        $data = [
            'nik' => $nik,
            'attendance_date' => $tgl_presensi,
            'time_in' => $jam,
            'photo_in' => $fileName,
            'location' => $lokasi
        ];
        $simpan = DB::table('attendances')->insert($data);

        if($simpan){
            echo '0';
            Storage::disk('public')->put($file, $image_base64);
        }else{
            echo '1';
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }
}
