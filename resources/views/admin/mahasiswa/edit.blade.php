@extends('layouts.app')

@section('title', 'Edit Mahasiswa - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Edit Data Mahasiswa</h1>

            <p>
                Perbarui NPM atau nama mahasiswa melalui form berikut.
            </p>
        </div>

        <a
            href="{{ route('admin.mahasiswa.index') }}"
            class="button button-secondary"
        >
            Kembali
        </a>
    </section>

    <section class="content-card form-card">
        <div class="section-heading">
            <h2>Form Edit Mahasiswa</h2>

            <p>
                Pastikan seluruh data mahasiswa sudah benar.
            </p>
        </div>

        <form
            action="{{ route('admin.mahasiswa.update', $mahasiswa) }}"
            method="POST"
            class="data-form"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="npm">
                    NPM <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="npm"
                    name="npm"
                    value="{{ old('npm', $mahasiswa->npm) }}"
                    placeholder="Contoh: 5520124001"
                    class="form-control @error('npm') input-error @enderror"
                    maxlength="10"
                    inputmode="numeric"
                    autocomplete="off"
                    required
                >

                <small class="form-help">
                    NPM harus terdiri dari tepat 10 angka.
                </small>

                @error('npm')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama">
                    Nama Mahasiswa <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $mahasiswa->nama) }}"
                    placeholder="Masukkan nama lengkap mahasiswa"
                    class="form-control @error('nama') input-error @enderror"
                    maxlength="50"
                    autocomplete="off"
                    required
                >

                <small class="form-help">
                    Nama mahasiswa maksimal 50 karakter.
                </small>

                @error('nama')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('admin.mahasiswa.index') }}"
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