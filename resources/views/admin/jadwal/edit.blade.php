@extends('layouts.app')

@section('title', 'Edit Jadwal - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Edit Jadwal</h1>

            <p>
                Perbarui data jadwal perkuliahan.
            </p>
        </div>

        <a
            href="{{ route('admin.jadwal.index') }}"
            class="button button-secondary"
        >
            Kembali
        </a>
    </section>

    <section class="content-card form-card">
        <div class="section-heading">
            <h2>Form Edit Jadwal</h2>

            <p>
                Pastikan seluruh data jadwal sudah benar.
            </p>
        </div>

        <form
            action="{{ route('admin.jadwal.update', $jadwal) }}"
            method="POST"
            class="data-form"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kode_matakuliah">
                    Mata Kuliah
                    <span class="required-mark">*</span>
                </label>

                <select
                    id="kode_matakuliah"
                    name="kode_matakuliah"
                    class="form-control @error('kode_matakuliah') input-error @enderror"
                    required
                >
                    <option value="">Pilih mata kuliah</option>

                    @foreach ($matakuliah as $item)
                        <option
                            value="{{ $item->kode_matakuliah }}"
                            @selected(
                                old(
                                    'kode_matakuliah',
                                    $jadwal->kode_matakuliah
                                ) === $item->kode_matakuliah
                            )
                        >
                            {{ $item->kode_matakuliah }}
                            — {{ $item->nama_matakuliah }}
                            ({{ $item->sks }} SKS)
                        </option>
                    @endforeach
                </select>

                @error('kode_matakuliah')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nidn">
                    Dosen Pengajar
                    <span class="required-mark">*</span>
                </label>

                <select
                    id="nidn"
                    name="nidn"
                    class="form-control @error('nidn') input-error @enderror"
                    required
                >
                    <option value="">Pilih dosen pengajar</option>

                    @foreach ($dosen as $item)
                        <option
                            value="{{ $item->nidn }}"
                            @selected(
                                old('nidn', $jadwal->nidn) === $item->nidn
                            )
                        >
                            {{ $item->nidn }} — {{ $item->nama }}
                        </option>
                    @endforeach
                </select>

                @error('nidn')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kelas">
                    Kelas
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    value="{{ old('kelas', $jadwal->kelas) }}"
                    class="form-control @error('kelas') input-error @enderror"
                    maxlength="10"
                    required
                >

                @error('kelas')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="hari">
                    Hari
                    <span class="required-mark">*</span>
                </label>

                <select
                    id="hari"
                    name="hari"
                    class="form-control @error('hari') input-error @enderror"
                    required
                >
                    <option value="">Pilih hari</option>

                    @foreach ($daftarHari as $hari)
                        <option
                            value="{{ $hari }}"
                            @selected(
                                old('hari', $jadwal->hari) === $hari
                            )
                        >
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>

                @error('hari')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="jam">
                    Jam
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="time"
                    id="jam"
                    name="jam"
                    value="{{ old('jam', substr((string) $jadwal->jam, 0, 5)) }}"
                    class="form-control @error('jam') input-error @enderror"
                    required
                >

                @error('jam')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('admin.jadwal.index') }}"
                    class="button button-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
@endsection