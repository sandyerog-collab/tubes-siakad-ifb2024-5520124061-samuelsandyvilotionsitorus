@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">MAHASISWA</p>

            <h1>Dashboard Mahasiswa</h1>

            <p>
                Selamat datang, {{ auth()->user()->name }}.
            </p>
        </div>

        <div class="student-identity">
            <span>NPM</span>

            <strong>
                {{ auth()->user()->npm ?? '-' }}
            </strong>
        </div>
    </section>

    <section class="statistic-grid student-statistic-grid">
        <article class="statistic-card">
            <div class="statistic-icon">
                KR
            </div>

            <div>
                <p>Mata Kuliah Diambil</p>

                <h2>
                    {{ $jumlahMatakuliahDiambil }}
                </h2>
            </div>
        </article>

        <article class="statistic-card">
            <div class="statistic-icon">
                SK
            </div>

            <div>
                <p>Total SKS</p>

                <h2>
                    {{ $totalSks }}
                </h2>
            </div>
        </article>
    </section>

    <section class="content-card">
        <div class="section-heading">
            <h2>Menu Mahasiswa</h2>

            <p>
                Pilih layanan akademik yang dibutuhkan.
            </p>
        </div>

        <div class="menu-grid">
            <article class="menu-card">
                <span class="menu-number">01</span>

                <h3>Jadwal Perkuliahan</h3>

                <p>
                    Melihat daftar jadwal perkuliahan yang tersedia.
                </p>

                <a
                    href="{{ route('mahasiswa.jadwal.index') }}"
                    class="button button-primary"
                >
                    Lihat Jadwal
                </a>
            </article>

            <article class="menu-card">
                <span class="menu-number">02</span>

                <h3>Ambil KRS</h3>

                <p>
                    Memilih mata kuliah yang akan diambil.
                </p>

                <a
                    href="{{ route('mahasiswa.krs.index') }}"
                    class="button button-primary"
                >
                    Ambil KRS
                </a>
            </article>

            <article class="menu-card">
                <span class="menu-number">03</span>

                <h3>KRS Saya</h3>

                <p>
                    Melihat mata kuliah yang sudah diambil.
                </p>

                <a
                    href="{{ route('mahasiswa.krs.index') }}"
                    class="button button-primary"
                >
                    Lihat KRS
                </a>
            </article>
        </div>
    </section>
@endsection