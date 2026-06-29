@extends('layouts.app')

@section('title', 'Jadwal Perkuliahan - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">MAHASISWA</p>

            <h1>Jadwal Perkuliahan</h1>

            <p>
                Lihat jadwal mata kuliah yang tersedia.
            </p>
        </div>

        <a
            href="{{ route('mahasiswa.dashboard') }}"
            class="button button-secondary"
        >
            Kembali ke Dashboard
        </a>
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
                action="{{ route('mahasiswa.jadwal.index') }}"
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
                        href="{{ route('mahasiswa.jadwal.index') }}"
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
                        <th>SKS</th>
                        <th>Dosen Pengajar</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
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
                                {{ $item->matakuliah?->sks ?? 0 }} SKS
                            </td>

                            <td>
                                {{ $item->dosen?->nama ?? '-' }}
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
    </section>
@endsection