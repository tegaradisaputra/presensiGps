<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
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
        $hariini = date("Y-m-d");
        $nik = Auth::guard("employee")->user()->nik;
        $cek = DB::table('attendances')->where('attendance_date', $hariini)->where('nik', $nik)->count();
        return view('attendance.create', compact('cek'));

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

        $latitude_kantor = -7.923941033331527;
        $longitude_kantor = 110.29634040794271;
        $lokasi = $request->lokasi;
        $lokasi_user = explode(",", $lokasi);
        $latitude_user = $lokasi_user[0];
        $longitude_user = $lokasi_user[1];

        $jarak = $this->distance($latitude_kantor, $longitude_kantor, $latitude_user, $longitude_user);
        $radius = round($jarak["meters"]);

        $image = $request->image;

        $folderPath = "uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi;

        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        
        $cek = DB::table('attendances')->where('attendance_date', $tgl_presensi)->where('nik', $nik)->count();
        if($radius > 5){
            echo "error|Maaf Anda Berada Di Luar Radius, jarak anda " . $radius . " Meter Dari Kantor|radius";
        }else{
            if($cek > 0){
                $data_pulang = [
                'time_out' => $jam,
                'photo_out' => $fileName,
                'location' => $lokasi
            ];
                $update = DB::table("attendances")->where('attendance_date', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if($update){
                    echo 'success|Terimakasih, hati-hati di jalan|out';
                    Storage::disk('public')->put($file, $image_base64);
                }else{
                    echo 'error|Maaf data gagal absen, Hubungi Tim IT|out';
                }
            } else{
                $data = [
                'nik' => $nik,
                'attendance_date' => $tgl_presensi,
                'time_in' => $jam,
                'photo_in' => $fileName,
                'location' => $lokasi
                ];
                $simpan = DB::table('attendances')->insert($data);
                if($simpan){
                    echo 'success|Terimakasih, selamat bekerja|in';
                Storage::disk('public')->put($file, $image_base64);
                }else{
                    echo 'error|Maaf data gagal absen, Hubungi Tim IT|in';
                }
            }
        }
    }
    //Menghitung Jarak
    private function distance($lat1, $lon1, $lat2, $lon2)
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

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
