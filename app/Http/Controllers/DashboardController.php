<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isMahasiswa()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        abort(403, 'Role pengguna tidak dikenali.');
    }

    public function admin(): View
    {
        return view('admin.dashboard', [
            'jumlahDosen' => Dosen::count(),
            'jumlahMahasiswa' => Mahasiswa::count(),
            'jumlahMatakuliah' => Matakuliah::count(),
            'jumlahJadwal' => Jadwal::count(),
        ]);
    }

    public function mahasiswa(Request $request): View
    {
        $npm = $request->user()->npm;

        $krs = Krs::query()
            ->with('matakuliah')
            ->where('npm', $npm)
            ->get();

        $jumlahMatakuliahDiambil = $krs->count();

        $totalSks = $krs->sum(function (Krs $item) {
            return $item->matakuliah?->sks ?? 0;
        });

        return view('mahasiswa.dashboard', [
            'jumlahMatakuliahDiambil' => $jumlahMatakuliahDiambil,
            'totalSks' => $totalSks,
        ]);
    }
}