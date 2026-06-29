@extends('layouts.app')

@section('title', 'Tambah Mahasiswa - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Tambah Data Mahasiswa</h1>

            <p>
                Masukkan NPM dan nama mahasiswa dengan benar.
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
            <h2>Form Tambah Mahasiswa</h2>

            <p>
                Kolom yang memiliki tanda bintang wajib diisi.
            </p>
        </div>

        <form
            action="{{ route('admin.mahasiswa.store') }}"
            method="POST"
            class="data-form"
        >
            @csrf

            <div class="form-group">
                <label for="npm">
                    NPM <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    id="npm"
                    name="npm"
                    value="{{ old('npm') }}"
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
                    value="{{ old('nama') }}"
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
                    Simpan Data
                </button>
            </div>
        </form>
    </section>
@endsection