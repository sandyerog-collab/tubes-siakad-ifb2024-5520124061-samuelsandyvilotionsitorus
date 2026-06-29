<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $pencarian = trim((string) $request->query('q'));

        $mahasiswa = Mahasiswa::query()
            ->when($pencarian !== '', function ($query) use ($pencarian) {
                $query->where(function ($subQuery) use ($pencarian) {
                    $subQuery
                        ->where('npm', 'like', '%' . $pencarian . '%')
                        ->orWhere('nama', 'like', '%' . $pencarian . '%');
                });
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
            'pencarian' => $pencarian,
        ]);
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'npm' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                    'unique:mahasiswa,npm',
                ],
                'nama' => [
                    'required',
                    'string',
                    'max:50',
                ],
            ],
            [
                'npm.required' => 'NPM wajib diisi.',
                'npm.regex' => 'NPM harus terdiri dari tepat 10 angka.',
                'npm.unique' => 'NPM tersebut sudah digunakan.',

                'nama.required' => 'Nama mahasiswa wajib diisi.',
                'nama.string' => 'Nama mahasiswa harus berupa teks.',
                'nama.max' => 'Nama mahasiswa maksimal 50 karakter.',
            ]
        );

        Mahasiswa::create($validated);

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('admin.mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function update(
        Request $request,
        Mahasiswa $mahasiswa
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'npm' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                    Rule::unique('mahasiswa', 'npm')
                        ->ignore($mahasiswa->npm, 'npm'),
                ],
                'nama' => [
                    'required',
                    'string',
                    'max:50',
                ],
            ],
            [
                'npm.required' => 'NPM wajib diisi.',
                'npm.regex' => 'NPM harus terdiri dari tepat 10 angka.',
                'npm.unique' => 'NPM tersebut sudah digunakan.',

                'nama.required' => 'Nama mahasiswa wajib diisi.',
                'nama.string' => 'Nama mahasiswa harus berupa teks.',
                'nama.max' => 'Nama mahasiswa maksimal 50 karakter.',
            ]
        );

        $mahasiswa->update($validated);

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->delete();

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}