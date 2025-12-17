<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Pegawai;

class MainController extends Controller
{
    public function index() {
        $TotalPekerjaanberdasarkanPegawai = Pekerjaan::withCount('pegawai')->get();
        $TotalGenderPegawai = [
            'male' => Pegawai::where('gender', 'male')->count(),
            'female' => Pegawai::where('gender', 'female')->count(),
        ];

        return view('index', compact('TotalPekerjaanberdasarkanPegawai', 'TotalGenderPegawai'));
    }
}
