@extends('layouts.app')

@section('title', 'KRS Saya - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">MAHASISWA</p>

            <h1>Kartu Rencana Studi</h1>

            <p>
                Ambil, lihat, dan hapus mata kuliah dari KRS.
            </p>
        </div>

        <div class="page-header-actions">
        <a
            href="{{ route('mahasiswa.dashboard') }}"
            class="button button-secondary"
        >
            Kembali ke Dashboard
        </a>

        <a
            href="{{ route('mahasiswa.krs.pdf') }}"
            class="button button-primary"
        >
            Unduh PDF
        </a>
    </div>
    </section>

    <section class="statistic-grid student-statistic-grid">
        <article class="statistic-card">
            <div class="statistic-icon">
                MK
            </div>

            <div>
                <p>Mata Kuliah Diambil</p>

                <h2>
                    {{ $krs->count() }}
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

    <section class="content-card form-card">
        <div class="section-heading">
            <h2>Ambil Mata Kuliah</h2>

            <p>
                Pilih mata kuliah yang ingin dimasukkan ke dalam KRS.
            </p>
        </div>

        <form
            action="{{ route('mahasiswa.krs.store') }}"
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
                    @disabled($matakuliahTersedia->isEmpty())
                >
                    <option value="">
                        Pilih mata kuliah
                    </option>

                    @foreach ($matakuliahTersedia as $item)
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

                @if ($matakuliahTersedia->isEmpty())
                    <small class="form-help">
                        Semua mata kuliah sudah diambil atau belum ada mata kuliah tersedia.
                    </small>
                @endif
            </div>

            <div class="form-actions">
                <button
                    type="submit"
                    class="button button-primary"
                    @disabled($matakuliahTersedia->isEmpty())
                >
                    Ambil Mata Kuliah
                </button>
            </div>
        </form>
    </section>

    <section
        class="content-card"
        style="margin-top: 25px;"
    >
        <div class="table-header">
            <div>
                <h2>KRS Saya</h2>

                <p>
                    Daftar mata kuliah yang telah diambil.
                </p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th class="table-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($krs as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->kode_matakuliah }}
                            </td>

                            <td>
                                {{ $item->matakuliah?->nama_matakuliah ?? '-' }}
                            </td>

                            <td>
                                {{ $item->matakuliah?->sks ?? 0 }} SKS
                            </td>

                            <td>
                                <form
                                    action="{{ route('mahasiswa.krs.destroy', $item) }}"
                                    method="POST"
                                    onsubmit="return confirm('Drop mata kuliah ini dari KRS?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="button button-danger button-small"
                                    >
                                        Drop
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="empty-table"
                            >
                                Belum ada mata kuliah yang diambil.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection