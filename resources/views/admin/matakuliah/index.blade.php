@extends('layouts.app')

@section('title', 'Data Mata Kuliah - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Data Mata Kuliah</h1>

            <p>
                Kelola seluruh data mata kuliah yang tersedia.
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
                href="{{ route('admin.matakuliah.create') }}"
                class="button button-primary"
            >
                Tambah Mata Kuliah
            </a>
        </div>
    </section>

    <section class="content-card">
        <div class="table-header">
            <div>
                <h2>Daftar Mata Kuliah</h2>

                <p>
                    Total data: {{ $matakuliah->total() }} mata kuliah
                </p>
            </div>

            <form
                action="{{ route('admin.matakuliah.index') }}"
                method="GET"
                class="search-form"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ $pencarian }}"
                    placeholder="Cari kode atau nama..."
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
                        href="{{ route('admin.matakuliah.index') }}"
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
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th class="table-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($matakuliah as $item)
                        <tr>
                            <td>
                                {{ $matakuliah->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->kode_matakuliah }}
                            </td>

                            <td>
                                {{ $item->nama_matakuliah }}
                            </td>

                            <td>
                                {{ $item->sks }} SKS
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route('admin.matakuliah.edit', $item) }}"
                                        class="button button-warning button-small"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.matakuliah.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')"
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
                                colspan="5"
                                class="empty-table"
                            >
                                @if ($pencarian !== '')
                                    Data dengan kata kunci
                                    “{{ $pencarian }}” tidak ditemukan.
                                @else
                                    Belum ada data mata kuliah.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($matakuliah->hasPages())
            <div class="pagination-wrapper">
                @if ($matakuliah->onFirstPage())
                    <span class="pagination-button disabled">
                        Sebelumnya
                    </span>
                @else
                    <a
                        href="{{ $matakuliah->previousPageUrl() }}"
                        class="pagination-button"
                    >
                        Sebelumnya
                    </a>
                @endif

                <span class="pagination-information">
                    Halaman {{ $matakuliah->currentPage() }}
                    dari {{ $matakuliah->lastPage() }}
                </span>

                @if ($matakuliah->hasMorePages())
                    <a
                        href="{{ $matakuliah->nextPageUrl() }}"
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