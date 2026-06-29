<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JadwalController extends Controller
{
    /**
     * @var array<int, string>
     */
    private array $daftarHari = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
    ];

    public function index(Request $request): View
    {
        $pencarian = trim((string) $request->query('q'));
        $filterHari = trim((string) $request->query('hari'));

        $jadwal = $this->jadwalQuery($pencarian, $filterHari)
            ->paginate(10)
            ->withQueryString();

        return view('admin.jadwal.index', [
            'jadwal' => $jadwal,
            'pencarian' => $pencarian,
            'filterHari' => $filterHari,
            'daftarHari' => $this->daftarHari,
        ]);
    }

    public function mahasiswaIndex(Request $request): View
    {
        $pencarian = trim((string) $request->query('q'));
        $filterHari = trim((string) $request->query('hari'));

        $jadwal = $this->jadwalQuery($pencarian, $filterHari)
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.jadwal.index', [
            'jadwal' => $jadwal,
            'pencarian' => $pencarian,
            'filterHari' => $filterHari,
            'daftarHari' => $this->daftarHari,
        ]);
    }

    private function jadwalQuery(
        string $pencarian,
        string $filterHari
    ) {
        return Jadwal::query()
            ->with([
                'dosen',
                'matakuliah',
            ])
            ->when($pencarian !== '', function ($query) use ($pencarian) {
                $query->where(function ($subQuery) use ($pencarian) {
                    $subQuery
                        ->where('kelas', 'like', '%' . $pencarian . '%')
                        ->orWhere(
                            'kode_matakuliah',
                            'like',
                            '%' . $pencarian . '%'
                        )
                        ->orWhereHas(
                            'dosen',
                            function ($dosenQuery) use ($pencarian) {
                                $dosenQuery->where(
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
            ->when($filterHari !== '', function ($query) use ($filterHari) {
                $query->where('hari', $filterHari);
            })
            ->orderByRaw(
                "FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')"
            )
            ->orderBy('jam');
    }

    public function create(): View
    {
        return view('admin.jadwal.create', [
            'dosen' => Dosen::orderBy('nama')->get(),
            'matakuliah' => Matakuliah::orderBy('nama_matakuliah')->get(),
            'daftarHari' => $this->daftarHari,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateJadwal($request);

        Jadwal::create($validated);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal): View
    {
        return view('admin.jadwal.edit', [
            'jadwal' => $jadwal,
            'dosen' => Dosen::orderBy('nama')->get(),
            'matakuliah' => Matakuliah::orderBy('nama_matakuliah')->get(),
            'daftarHari' => $this->daftarHari,
        ]);
    }

    public function update(
        Request $request,
        Jadwal $jadwal
    ): RedirectResponse {
        $validated = $this->validateJadwal($request);

        $jadwal->update($validated);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateJadwal(Request $request): array
    {
        return $request->validate(
            [
                'kode_matakuliah' => [
                    'required',
                    'exists:matakuliah,kode_matakuliah',
                ],
                'nidn' => [
                    'required',
                    'exists:dosen,nidn',
                ],
                'kelas' => [
                    'required',
                    'string',
                    'max:10',
                ],
                'hari' => [
                    'required',
                    Rule::in($this->daftarHari),
                ],
                'jam' => [
                    'required',
                    'date_format:H:i',
                ],
            ],
            [
                'kode_matakuliah.required' =>
                    'Mata kuliah wajib dipilih.',

                'kode_matakuliah.exists' =>
                    'Mata kuliah tidak ditemukan.',

                'nidn.required' =>
                    'Dosen pengajar wajib dipilih.',

                'nidn.exists' =>
                    'Dosen tidak ditemukan.',

                'kelas.required' =>
                    'Kelas wajib diisi.',

                'kelas.max' =>
                    'Kelas maksimal 10 karakter.',

                'hari.required' =>
                    'Hari wajib dipilih.',

                'hari.in' =>
                    'Hari yang dipilih tidak valid.',

                'jam.required' =>
                    'Jam wajib diisi.',

                'jam.date_format' =>
                    'Format jam tidak valid.',
            ]
        );
    }
}