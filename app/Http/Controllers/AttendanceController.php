<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;;

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

        $latitude_kantor = -7.923125627065127;
        $longitude_kantor = 110.2965900461825;
        $lokasi = $request->lokasi;
        $lokasi_user = explode(",", $lokasi);
        $latitude_user = $lokasi_user[0];
        $longitude_user = $lokasi_user[1];

        $jarak = $this->distance($latitude_kantor, $longitude_kantor, $latitude_user, $longitude_user);
        $radius = round($jarak["meters"]);

        $cek = DB::table('attendances')->where('attendance_date', $tgl_presensi)->where('nik', $nik)->count();

        if($cek > 0){
            $ket = 'out';
        }else{
            $ket = 'in';
        }
        $image = $request->image;

        $folderPath = "uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;

        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        
        if($radius > 35){
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

    public function editProfil()
    {
        //
        $nik = Auth::guard('employee')->user()->nik;
        $employee = DB::table('employees')->where('nik', $nik)->first();

        return view('attendance.edit', compact('employee'));
    }

    public function updateProfil(Request $request)
    {
        //
        $nik = Auth::guard('employee')->user()->nik;
        $full_name = $request->full_name;
        $phone_number = $request->phone_number;
        $password = Hash::make($request->password);
        $employee = DB::table('employees')->where('nik', $nik)->first();
        if($request->hasFile('picture')){
            $picture = $nik . "." . $request->file('picture')->getClientOriginalextension();
        }else{
            $picture = $employee->picture;
        }

        if(empty($request->password)){
            $data = [
            'full_name' => $full_name,
            'phone_number' => $phone_number,
            'picture' => $picture
        ];
        }else{
            $data = [
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'password' => $password,
                'picture' => $picture
            ];
        }

        $update = DB::table('employees')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('picture')){
                $folderPath = "public/uploads/employees/";
                Storage::disk('public')->putFileAs('uploads/employees', $request->file('picture'), $picture);
            }
            return Redirect::back()->with(['success' => 'data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'data gagal Di Update']);
        }
    }

    public function histori()
    {
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

        return view('attendance.histori', compact('nama_bulan'));
    }

    public function getHistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('employee')->user()->nik;

        $histori = DB::table('attendances')
        ->whereRaw('MONTH(attendance_date)="' . $bulan . '"')
        ->whereRaw('YEAR(attendance_date)="' . $tahun . '"')
        ->where('nik', $nik)
        ->orderBy('attendance_date')
        ->get();

        return view('attendance.getHistori', compact('histori'));
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
