@extends('layouts.app')

@section('title', 'Data Dosen - SIAKAD')

@section('content')
    <section class="page-header">
        <div>
            <p class="page-label">ADMIN</p>

            <h1>Data Dosen</h1>

            <p>
                Kelola seluruh data dosen yang tersedia.
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
                href="{{ route('admin.dosen.create') }}"
                class="button button-primary"
            >
                Tambah Dosen
            </a>
        </div>
    </section>

    <section class="content-card">
        <div class="table-header">
            <div>
                <h2>Daftar Dosen</h2>

                <p>
                    Total data: {{ $dosen->total() }} dosen
                </p>
            </div>

            <form
                action="{{ route('admin.dosen.index') }}"
                method="GET"
                class="search-form"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ $pencarian }}"
                    placeholder="Cari NIDN atau nama..."
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
                        href="{{ route('admin.dosen.index') }}"
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
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th class="table-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dosen as $item)
                        <tr>
                            <td>
                                {{ $dosen->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->nidn }}
                            </td>

                            <td>
                                {{ $item->nama }}
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route('admin.dosen.edit', $item) }}"
                                        class="button button-warning button-small"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.dosen.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus dosen ini?')"
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
                                    Data dosen dengan kata kunci
                                    “{{ $pencarian }}” tidak ditemukan.
                                @else
                                    Belum ada data dosen.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dosen->hasPages())
            <div class="pagination-wrapper">
                @if ($dosen->onFirstPage())
                    <span class="pagination-button disabled">
                        Sebelumnya
                    </span>
                @else
                    <a
                        href="{{ $dosen->previousPageUrl() }}"
                        class="pagination-button"
                    >
                        Sebelumnya
                    </a>
                @endif

                <span class="pagination-information">
                    Halaman {{ $dosen->currentPage() }}
                    dari {{ $dosen->lastPage() }}
                </span>

                @if ($dosen->hasMorePages())
                    <a
                        href="{{ $dosen->nextPageUrl() }}"
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