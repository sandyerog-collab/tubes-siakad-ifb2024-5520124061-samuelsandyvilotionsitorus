@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Tambah Mata Kuliah</h1>

            <p>
                Masukkan data mata kuliah dengan benar.
            </p>
        </div>

        <a
            href="{{ route('admin.matakuliah.index') }}"
            class="button button-secondary"
        >
            Kembali
        </a>
    </section>

    <section class="content-card form-card">
        <div class="section-heading">
            <h2>Form Tambah Mata Kuliah</h2>

            <p>
                Semua kolom wajib diisi.
            </p>
        </div>

        <form
            action="{{ route('admin.matakuliah.store') }}"
            method="POST"
            class="data-form"
        >
            @csrf

            <div class="form-group">
                <label for="kode_matakuliah">
                    Kode Mata Kuliah
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="kode_matakuliah"
                    name="kode_matakuliah"
                    value="{{ old('kode_matakuliah') }}"
                    placeholder="Contoh: IF53413"
                    class="form-control @error('kode_matakuliah') input-error @enderror"
                    maxlength="8"
                    required
                >

                @error('kode_matakuliah')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_matakuliah">
                    Nama Mata Kuliah
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="nama_matakuliah"
                    name="nama_matakuliah"
                    value="{{ old('nama_matakuliah') }}"
                    placeholder="Masukkan nama mata kuliah"
                    class="form-control @error('nama_matakuliah') input-error @enderror"
                    maxlength="50"
                    required
                >

                @error('nama_matakuliah')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="sks">
                    Jumlah SKS
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="number"
                    id="sks"
                    name="sks"
                    value="{{ old('sks') }}"
                    placeholder="Contoh: 3"
                    class="form-control @error('sks') input-error @enderror"
                    min="1"
                    max="6"
                    required
                >

                <small class="form-help">
                    Jumlah SKS antara 1 sampai 6.
                </small>

                @error('sks')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('admin.matakuliah.index') }}"
                    class="button button-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Simpan Data
                </button>
            </div>
        </form>
    </section>
@endsection