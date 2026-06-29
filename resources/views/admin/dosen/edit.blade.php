@extends('layouts.app')

@section('title', 'Edit Dosen - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Edit Data Dosen</h1>

            <p>
                Perbarui NIDN atau nama dosen melalui form berikut.
            </p>
        </div>

        <a
            href="{{ route('admin.dosen.index') }}"
            class="button button-secondary"
        >
            Kembali
        </a>
    </section>

    <section class="content-card form-card">
        <div class="section-heading">
            <h2>Form Edit Dosen</h2>

            <p>
                Pastikan data yang dimasukkan sudah benar.
            </p>
        </div>

        <form
            action="{{ route('admin.dosen.update', $dosen) }}"
            method="POST"
            class="data-form"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nidn">
                    NIDN <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="nidn"
                    name="nidn"
                    value="{{ old('nidn', $dosen->nidn) }}"
                    placeholder="Contoh: 1234567890"
                    class="form-control @error('nidn') input-error @enderror"
                    maxlength="10"
                    inputmode="numeric"
                    autocomplete="off"
                    required
                >

                <small class="form-help">
                    NIDN harus terdiri dari tepat 10 angka.
                </small>

                @error('nidn')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama">
                    Nama Dosen <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $dosen->nama) }}"
                    placeholder="Masukkan nama lengkap dosen"
                    class="form-control @error('nama') input-error @enderror"
                    maxlength="50"
                    autocomplete="off"
                    required
                >

                <small class="form-help">
                    Nama dosen maksimal 50 karakter.
                </small>

                @error('nama')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('admin.dosen.index') }}"
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