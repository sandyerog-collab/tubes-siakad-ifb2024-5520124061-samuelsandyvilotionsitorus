<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $pencarian = trim((string) $request->query('q'));

        $dosen = Dosen::query()
            ->when($pencarian !== '', function ($query) use ($pencarian) {
                $query->where(function ($subQuery) use ($pencarian) {
                    $subQuery
                        ->where('nidn', 'like', '%' . $pencarian . '%')
                        ->orWhere('nama', 'like', '%' . $pencarian . '%');
                });
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dosen.index', [
            'dosen' => $dosen,
            'pencarian' => $pencarian,
        ]);
    }

    public function create(): View
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'nidn' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                    'unique:dosen,nidn',
                ],
                'nama' => [
                    'required',
                    'string',
                    'max:50',
                ],
            ],
            [
                'nidn.required' => 'NIDN wajib diisi.',
                'nidn.regex' => 'NIDN harus terdiri dari tepat 10 angka.',
                'nidn.unique' => 'NIDN tersebut sudah digunakan.',
                'nama.required' => 'Nama dosen wajib diisi.',
                'nama.string' => 'Nama dosen harus berupa teks.',
                'nama.max' => 'Nama dosen maksimal 50 karakter.',
            ]
        );

        Dosen::create($validated);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen): View
    {
        return view('admin.dosen.edit', [
            'dosen' => $dosen,
        ]);
    }

    public function update(
        Request $request,
        Dosen $dosen
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'nidn' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                    Rule::unique('dosen', 'nidn')
                        ->ignore($dosen->nidn, 'nidn'),
                ],
                'nama' => [
                    'required',
                    'string',
                    'max:50',
                ],
            ],
            [
                'nidn.required' => 'NIDN wajib diisi.',
                'nidn.regex' => 'NIDN harus terdiri dari tepat 10 angka.',
                'nidn.unique' => 'NIDN tersebut sudah digunakan.',
                'nama.required' => 'Nama dosen wajib diisi.',
                'nama.string' => 'Nama dosen harus berupa teks.',
                'nama.max' => 'Nama dosen maksimal 50 karakter.',
            ]
        );

        $dosen->update($validated);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $dosen->delete();

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}