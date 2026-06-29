@extends('layouts.app')

@section('title', 'Data KRS - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Data KRS</h1>

            <p>
                Lihat seluruh mata kuliah yang diambil mahasiswa.
            </p>
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="button button-secondary"
        >
            Kembali ke Dashboard
        </a>
    </section>

    <section class="content-card">
        <div class="table-header">
            <div>
                <h2>Daftar KRS Mahasiswa</h2>

                <p>
                    Total data: {{ $krs->total() }} KRS
                </p>
            </div>

            <form
                action="{{ route('admin.krs.index') }}"
                method="GET"
                class="search-form"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ $pencarian }}"
                    placeholder="Cari NPM, mahasiswa, atau mata kuliah..."
                    class="form-control search-input"
                >

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Cari
                </button>

                @if ($pencarian !== '')
                    <a
                        href="{{ route('admin.krs.index') }}"
                        class="button button-secondary"
                    >
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kode</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th class="table-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($krs as $item)
                        <tr>
                            <td>
                                {{ $krs->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->npm }}
                            </td>

                            <td>
                                {{ $item->mahasiswa?->nama ?? '-' }}
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
                                    action="{{ route('admin.krs.destroy', $item) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus data KRS ini?')"
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="7"
                                class="empty-table"
                            >
                                @if ($pencarian !== '')
                                    Data KRS dengan kata kunci
                                    “{{ $pencarian }}” tidak ditemukan.
                                @else
                                    Belum ada mahasiswa yang mengambil KRS.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($krs->hasPages())
            <div class="pagination-wrapper">
                @if ($krs->onFirstPage())
                    <span class="pagination-button disabled">
                        Sebelumnya
                    </span>
                @else
                    <a
                        href="{{ $krs->previousPageUrl() }}"
                        class="pagination-button"
                    >
                        Sebelumnya
                    </a>
                @endif

                <span class="pagination-information">
                    Halaman {{ $krs->currentPage() }}
                    dari {{ $krs->lastPage() }}
                </span>

                @if ($krs->hasMorePages())
                    <a
                        href="{{ $krs->nextPageUrl() }}"
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