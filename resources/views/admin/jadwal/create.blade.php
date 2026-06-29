@extends('layouts.app')

@section('title', 'Tambah Jadwal - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Tambah Jadwal</h1>

            <p>
                Tentukan mata kuliah, dosen, kelas, hari, dan jam.
            </p>
        </div>

        <a
            href="{{ route('admin.jadwal.index') }}"
            class="button button-secondary"
        >
            Kembali
        </a>
    </section>

    @if ($dosen->isEmpty() || $matakuliah->isEmpty())
        <div class="alert alert-danger">
            Tambahkan data dosen dan mata kuliah terlebih dahulu sebelum membuat jadwal.
        </div>
    @endif

    <section class="content-card form-card">
        <div class="section-heading">
            <h2>Form Tambah Jadwal</h2>

            <p>
                Semua kolom wajib diisi.
            </p>
        </div>

        <form
            action="{{ route('admin.jadwal.store') }}"
            method="POST"
            class="data-form"
        >
            @csrf

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
                            @selected(old('kode_matakuliah') === $item->kode_matakuliah)
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
                            @selected(old('nidn') === $item->nidn)
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
                    value="{{ old('kelas') }}"
                    placeholder="Contoh: IF-A 2024"
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
                            @selected(old('hari') === $hari)
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
                    value="{{ old('jam') }}"
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
                    @disabled($dosen->isEmpty() || $matakuliah->isEmpty())
                >
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </section>
@endsection