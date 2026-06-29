@extends('layouts.app')

@section('title', 'Dashboard Admin - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Dashboard Admin</h1>

            <p>
                Selamat datang, {{ auth()->user()->name }}.
                Kelola data akademik melalui halaman ini.
            </p>
        </div>
    </section>

    <section class="statistic-grid">
        <article class="statistic-card">
            <div class="statistic-icon">
                DS
            </div>

            <div>
                <p>Jumlah Dosen</p>

                <h2>
                    {{ $jumlahDosen }}
                </h2>
            </div>
        </article>

        <article class="statistic-card">
            <div class="statistic-icon">
                MS
            </div>

            <div>
                <p>Jumlah Mahasiswa</p>

                <h2>
                    {{ $jumlahMahasiswa }}
                </h2>
            </div>
        </article>

        <article class="statistic-card">
            <div class="statistic-icon">
                MK
            </div>

            <div>
                <p>Mata Kuliah</p>

                <h2>
                    {{ $jumlahMatakuliah }}
                </h2>
            </div>
        </article>

        <article class="statistic-card">
            <div class="statistic-icon">
                JD
            </div>

            <div>
                <p>Jumlah Jadwal</p>

                <h2>
                    {{ $jumlahJadwal }}
                </h2>
            </div>
        </article>
    </section>

    <section class="content-card">
        <div class="section-heading">
            <h2>Menu Pengelolaan</h2>

            <p>
                Pilih data akademik yang ingin dikelola.
            </p>
        </div>

        <div class="menu-grid">
            <article class="menu-card">
                <span class="menu-number">01</span>

                <h3>Data Dosen</h3>

                <p>
                    Menambah, melihat, mengubah, dan menghapus data dosen.
                </p>

                <a
                    href="{{ route('admin.dosen.index') }}"
                    class="button button-primary"
                >
                    Kelola Dosen
                </a>
            </article>

            <article class="menu-card">
                <span class="menu-number">02</span>

                <h3>Data Mahasiswa</h3>

                <p>
                    Menambah, melihat, mengubah, dan menghapus data mahasiswa.
                </p>

                <a
                    href="{{ route('admin.mahasiswa.index') }}"
                    class="button button-primary"
                >
                    Kelola Mahasiswa
                </a>
            </article>

            <article class="menu-card">
                <span class="menu-number">03</span>

                <h3>Mata Kuliah</h3>

                <p>
                    Mengelola kode, nama, dan jumlah SKS mata kuliah.
                </p>

                <a
                    href="{{ route('admin.matakuliah.index') }}"
                    class="button button-primary"
                >
                    Kelola Mata Kuliah
                </a>
            </article>

            <article class="menu-card">
                <span class="menu-number">04</span>

                <h3>Jadwal Kuliah</h3>

                <p>
                    Menentukan dosen, mata kuliah, kelas, hari, dan jam.
                </p>

                <a
                    href="{{ route('admin.jadwal.index') }}"
                    class="button button-primary"
                >
                    Kelola Jadwal
                </a>
            </article>

            <article class="menu-card">
            <span class="menu-number">05</span>

                <h3>Data KRS</h3>

                <p>
                    Melihat mata kuliah yang diambil oleh mahasiswa.
                </p>

                <a
                    href="{{ route('admin.krs.index') }}"
                    class="button button-primary"
                >
                    Lihat Data KRS
                </a>
</article>
        </div>
    </section>
@endsection