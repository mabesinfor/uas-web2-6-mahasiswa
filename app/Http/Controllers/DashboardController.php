<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ProgramStudi;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;

class DashboardController extends Controller
{
    public function index()
    {
        $programStudiData = ProgramStudi::withCount('mahasiswa')->get();
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahMataKuliah = MataKuliah::count();
        $rataRataNilai = Nilai::avg('nilai');

        return Inertia::render('Dashboard', [
            'programStudiData' => $programStudiData,
            'jumlahMahasiswa' => $jumlahMahasiswa,
            'jumlahMataKuliah' => $jumlahMataKuliah,
            'rataRataNilai' => round($rataRataNilai, 2),
        ]);
    }
}