@extends('layouts.app')

@section('title', 'Edit Mata Kuliah - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Edit Mata Kuliah</h1>

            <p>
                Perbarui data mata kuliah melalui form berikut.
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
            <h2>Form Edit Mata Kuliah</h2>

            <p>
                Pastikan seluruh data sudah benar.
            </p>
        </div>

        <form
            action="{{ route('admin.matakuliah.update', $matakuliah) }}"
            method="POST"
            class="data-form"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kode_matakuliah">
                    Kode Mata Kuliah
                    <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="kode_matakuliah"
                    name="kode_matakuliah"
                    value="{{ old('kode_matakuliah', $matakuliah->kode_matakuliah) }}"
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
                    value="{{ old('nama_matakuliah', $matakuliah->nama_matakuliah) }}"
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
                    value="{{ old('sks', $matakuliah->sks) }}"
                    placeholder="Contoh: 3"
                    class="form-control @error('sks') input-error @enderror"
                    min="1"
                    max="6"
                    required
                >

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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
@endsection