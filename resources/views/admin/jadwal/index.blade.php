@extends('layouts.app')

@section('title', 'Data Jadwal - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Jadwal Perkuliahan</h1>

            <p>
                Kelola jadwal, dosen pengajar, kelas, hari, dan jam.
            </p>
        </div>

        <div class="page-header-actions">
            <a
                href="{{ route('admin.dashboard') }}"
                class="button button-secondary"
            >
                Kembali ke Dashboard
            </a>

            <a
                href="{{ route('admin.jadwal.create') }}"
                class="button button-primary"
            >
                Tambah Jadwal
            </a>
        </div>
    </section>

    <section class="content-card">
        <div class="table-header">
            <div>
                <h2>Daftar Jadwal</h2>

                <p>
                    Total data: {{ $jadwal->total() }} jadwal
                </p>
            </div>

            <form
                action="{{ route('admin.jadwal.index') }}"
                method="GET"
                class="search-form schedule-filter-form"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ $pencarian }}"
                    placeholder="Cari kelas, dosen, atau mata kuliah..."
                    class="form-control schedule-search-input"
                >

                <select
                    name="hari"
                    class="form-control schedule-day-select"
                >
                    <option value="">Semua Hari</option>

                    @foreach ($daftarHari as $hari)
                        <option
                            value="{{ $hari }}"
                            @selected($filterHari === $hari)
                        >
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Filter
                </button>

                @if ($pencarian !== '' || $filterHari !== '')
                    <a
                        href="{{ route('admin.jadwal.index') }}"
                        class="button button-secondary"
                    >
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="data-table schedule-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen Pengajar</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th class="table-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwal as $item)
                        <tr>
                            <td>
                                {{ $jadwal->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->matakuliah?->nama_matakuliah ?? '-' }}
                                </strong>

                                <small class="table-secondary-text">
                                    {{ $item->kode_matakuliah }}
                                </small>
                            </td>

                            <td>
                                <strong>
                                    {{ $item->dosen?->nama ?? '-' }}
                                </strong>

                                <small class="table-secondary-text">
                                    {{ $item->nidn }}
                                </small>
                            </td>

                            <td>
                                {{ $item->kelas }}
                            </td>

                            <td>
                                <span class="schedule-day-badge">
                                    {{ $item->hari }}
                                </span>
                            </td>

                            <td>
                                {{ substr((string) $item->jam, 0, 5) }}
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route('admin.jadwal.edit', $item) }}"
                                        class="button button-warning button-small"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.jadwal.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="button button-danger button-small"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="7"
                                class="empty-table"
                            >
                                Belum ada jadwal perkuliahan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jadwal->hasPages())
            <div class="pagination-wrapper">
                @if ($jadwal->onFirstPage())
                    <span class="pagination-button disabled">
                        Sebelumnya
                    </span>
                @else
                    <a
                        href="{{ $jadwal->previousPageUrl() }}"
                        class="pagination-button"
                    >
                        Sebelumnya
                    </a>
                @endif

                <span class="pagination-information">
                    Halaman {{ $jadwal->currentPage() }}
                    dari {{ $jadwal->lastPage() }}
                </span>

                @if ($jadwal->hasMorePages())
                    <a
                        href="{{ $jadwal->nextPageUrl() }}"
                        class="pagination-button"
                    >
                        Selanjutnya
                    </a>
                @else
                    <span class="pagination-button disabled">
                        Selanjutnya
                    </span>
                @endif
            </div>
        @endif
    </section>
@endsection 