<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class KrsController extends Controller
{
    public function adminIndex(Request $request): View
    {
        $pencarian = trim((string) $request->query('q'));

        $krs = Krs::query()
            ->with([
                'mahasiswa',
                'matakuliah',
            ])
            ->when($pencarian !== '', function ($query) use ($pencarian) {
                $query->where(function ($subQuery) use ($pencarian) {
                    $subQuery
                        ->where('npm', 'like', '%' . $pencarian . '%')
                        ->orWhere(
                            'kode_matakuliah',
                            'like',
                            '%' . $pencarian . '%'
                        )
                        ->orWhereHas(
                            'mahasiswa',
                            function ($mahasiswaQuery) use ($pencarian) {
                                $mahasiswaQuery->where(
                                    'nama',
                                    'like',
                                    '%' . $pencarian . '%'
                                );
                            }
                        )
                        ->orWhereHas(
                            'matakuliah',
                            function ($matakuliahQuery) use ($pencarian) {
                                $matakuliahQuery->where(
                                    'nama_matakuliah',
                                    'like',
                                    '%' . $pencarian . '%'
                                );
                            }
                        );
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.krs.index', [
            'krs' => $krs,
            'pencarian' => $pencarian,
        ]);
    }

    public function mahasiswaIndex(Request $request): View
    {
        $user = $request->user();
        $npm = $user->npm;

        if (empty($npm)) {
            abort(403, 'NPM akun mahasiswa belum tersedia.');
        }

        Mahasiswa::firstOrCreate(
            [
                'npm' => $npm,
            ],
            [
                'nama' => $user->name,
            ]
        );

        $krs = Krs::query()
            ->with('matakuliah')
            ->where('npm', $npm)
            ->latest()
            ->get();

        $matakuliahTersedia = Matakuliah::query()
            ->whereDoesntHave(
                'krs',
                function ($query) use ($npm) {
                    $query->where('npm', $npm);
                }
            )
            ->orderBy('nama_matakuliah')
            ->get();

        $totalSks = $krs->sum(function (Krs $item) {
            return $item->matakuliah?->sks ?? 0;
        });

        return view('mahasiswa.krs.index', [
            'krs' => $krs,
            'matakuliahTersedia' => $matakuliahTersedia,
            'totalSks' => $totalSks,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $npm = $user->npm;

        if (empty($npm)) {
            return back()->with(
                'error',
                'NPM akun mahasiswa belum tersedia.'
            );
        }

        $validated = $request->validate(
            [
                'kode_matakuliah' => [
                    'required',
                    'exists:matakuliah,kode_matakuliah',
                ],
            ],
            [
                'kode_matakuliah.required' =>
                    'Mata kuliah wajib dipilih.',

                'kode_matakuliah.exists' =>
                    'Mata kuliah tidak ditemukan.',
            ]
        );

        Mahasiswa::firstOrCreate(
            [
                'npm' => $npm,
            ],
            [
                'nama' => $user->name,
            ]
        );

        $sudahDiambil = Krs::query()
            ->where('npm', $npm)
            ->where(
                'kode_matakuliah',
                $validated['kode_matakuliah']
            )
            ->exists();

        if ($sudahDiambil) {
            return back()->with(
                'error',
                'Mata kuliah tersebut sudah diambil.'
            );
        }

        Krs::create([
            'npm' => $npm,
            'kode_matakuliah' => $validated['kode_matakuliah'],
        ]);

        return redirect()
            ->route('mahasiswa.krs.index')
            ->with('success', 'Mata kuliah berhasil diambil.');
    }

    public function exportPdf(Request $request)
    {
        $user = $request->user();
        $npm = $user->npm;

        if (empty($npm)) {
            abort(403, 'NPM akun mahasiswa belum tersedia.');
        }

        $mahasiswa = Mahasiswa::firstOrCreate(
            [
                'npm' => $npm,
            ],
            [
                'nama' => $user->name,
            ]
        );

        $krs = Krs::query()
            ->with('matakuliah')
            ->where('npm', $npm)
            ->orderBy('kode_matakuliah')
            ->get();

        $totalSks = $krs->sum(function (Krs $item) {
            return $item->matakuliah?->sks ?? 0;
        });

        $pdf = Pdf::loadView('mahasiswa.krs.pdf', [
            'mahasiswa' => $mahasiswa,
            'krs' => $krs,
            'totalSks' => $totalSks,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('krs-' . $npm . '.pdf');
    }

    public function destroy(
        Request $request,
        Krs $krs
    ): RedirectResponse {
        $user = $request->user();

        if (
            $user->role !== 'admin'
            && $krs->npm !== $user->npm
        ) {
            abort(403, 'Anda tidak dapat menghapus KRS mahasiswa lain.');
        }

        $krs->delete();

        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.krs.index')
                ->with('success', 'Data KRS berhasil dihapus.');
        }

        return redirect()
            ->route('mahasiswa.krs.index')
            ->with('success', 'Mata kuliah berhasil di-drop.');
    }
}