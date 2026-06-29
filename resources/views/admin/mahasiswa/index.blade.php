@extends('layouts.app')

@section('title', 'Data Mahasiswa - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Data Mahasiswa</h1>

            <p>
                Kelola seluruh data mahasiswa yang tersedia.
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
                href="{{ route('admin.mahasiswa.create') }}"
                class="button button-primary"
            >
                Tambah Mahasiswa
            </a>
        </div>
    </section>

    <section class="content-card">
        <div class="table-header">
            <div>
                <h2>Daftar Mahasiswa</h2>

                <p>
                    Total data: {{ $mahasiswa->total() }} mahasiswa
                </p>
            </div>

            <form
                action="{{ route('admin.mahasiswa.index') }}"
                method="GET"
                class="search-form"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ $pencarian }}"
                    placeholder="Cari NPM atau nama..."
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
                        href="{{ route('admin.mahasiswa.index') }}"
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
                        <th class="table-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($mahasiswa as $item)
                        <tr>
                            <td>
                                {{ $mahasiswa->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->npm }}
                            </td>

                            <td>
                                {{ $item->nama }}
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route('admin.mahasiswa.edit', $item) }}"
                                        class="button button-warning button-small"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.mahasiswa.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')"
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
                                colspan="4"
                                class="empty-table"
                            >
                                @if ($pencarian !== '')
                                    Data mahasiswa dengan kata kunci
                                    “{{ $pencarian }}” tidak ditemukan.
                                @else
                                    Belum ada data mahasiswa.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mahasiswa->hasPages())
            <div class="pagination-wrapper">
                @if ($mahasiswa->onFirstPage())
                    <span class="pagination-button disabled">
                        Sebelumnya
                    </span>
                @else
                    <a
                        href="{{ $mahasiswa->previousPageUrl() }}"
                        class="pagination-button"
                    >
                        Sebelumnya
                    </a>
                @endif

                <span class="pagination-information">
                    Halaman {{ $mahasiswa->currentPage() }}
                    dari {{ $mahasiswa->lastPage() }}
                </span>

                @if ($mahasiswa->hasMorePages())
                    <a
                        href="{{ $mahasiswa->nextPageUrl() }}"
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