<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MatakuliahController extends Controller
{
    public function index(Request $request): View
    {
        $pencarian = trim((string) $request->query('q'));

        $matakuliah = Matakuliah::query()
            ->when($pencarian !== '', function ($query) use ($pencarian) {
                $query->where(function ($subQuery) use ($pencarian) {
                    $subQuery
                        ->where(
                            'kode_matakuliah',
                            'like',
                            '%' . $pencarian . '%'
                        )
                        ->orWhere(
                            'nama_matakuliah',
                            'like',
                            '%' . $pencarian . '%'
                        );
                });
            })
            ->orderBy('nama_matakuliah')
            ->paginate(10)
            ->withQueryString();

        return view('admin.matakuliah.index', [
            'matakuliah' => $matakuliah,
            'pencarian' => $pencarian,
        ]);
    }

    public function create(): View
    {
        return view('admin.matakuliah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'kode_matakuliah' => [
                    'required',
                    'string',
                    'max:8',
                    'unique:matakuliah,kode_matakuliah',
                ],
                'nama_matakuliah' => [
                    'required',
                    'string',
                    'max:50',
                ],
                'sks' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:6',
                ],
            ],
            [
                'kode_matakuliah.required' =>
                    'Kode mata kuliah wajib diisi.',

                'kode_matakuliah.max' =>
                    'Kode mata kuliah maksimal 8 karakter.',

                'kode_matakuliah.unique' =>
                    'Kode mata kuliah tersebut sudah digunakan.',

                'nama_matakuliah.required' =>
                    'Nama mata kuliah wajib diisi.',

                'nama_matakuliah.max' =>
                    'Nama mata kuliah maksimal 50 karakter.',

                'sks.required' =>
                    'Jumlah SKS wajib diisi.',

                'sks.integer' =>
                    'Jumlah SKS harus berupa angka.',

                'sks.min' =>
                    'Jumlah SKS minimal 1.',

                'sks.max' =>
                    'Jumlah SKS maksimal 6.',
            ]
        );

        Matakuliah::create($validated);

        return redirect()
            ->route('admin.matakuliah.index')
            ->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function edit(Matakuliah $matakuliah): View
    {
        return view('admin.matakuliah.edit', [
            'matakuliah' => $matakuliah,
        ]);
    }

    public function update(
        Request $request,
        Matakuliah $matakuliah
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'kode_matakuliah' => [
                    'required',
                    'string',
                    'max:8',
                    Rule::unique('matakuliah', 'kode_matakuliah')
                        ->ignore(
                            $matakuliah->kode_matakuliah,
                            'kode_matakuliah'
                        ),
                ],
                'nama_matakuliah' => [
                    'required',
                    'string',
                    'max:50',
                ],
                'sks' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:6',
                ],
            ],
            [
                'kode_matakuliah.required' =>
                    'Kode mata kuliah wajib diisi.',

                'kode_matakuliah.max' =>
                    'Kode mata kuliah maksimal 8 karakter.',

                'kode_matakuliah.unique' =>
                    'Kode mata kuliah tersebut sudah digunakan.',

                'nama_matakuliah.required' =>
                    'Nama mata kuliah wajib diisi.',

                'nama_matakuliah.max' =>
                    'Nama mata kuliah maksimal 50 karakter.',

                'sks.required' =>
                    'Jumlah SKS wajib diisi.',

                'sks.integer' =>
                    'Jumlah SKS harus berupa angka.',

                'sks.min' =>
                    'Jumlah SKS minimal 1.',

                'sks.max' =>
                    'Jumlah SKS maksimal 6.',
            ]
        );

        $matakuliah->update($validated);

        return redirect()
            ->route('admin.matakuliah.index')
            ->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy(
        Matakuliah $matakuliah
    ): RedirectResponse {
        $matakuliah->delete();

        return redirect()
            ->route('admin.matakuliah.index')
            ->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}