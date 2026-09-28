@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Kategori Items</h4>

        <a href="{{ route('kategori-items.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-header">
            Filter Kategori
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('kategori-items.index') }}">
                <div class="row">

                    <div class="col-md-5">
                        <label for="name">Nama</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ request('name') }}"
                            placeholder="Cari nama kategori"
                        >
                    </div>

                    <div class="col-md-5">
                        <label for="code">Kode</label>
                        <input
                            type="text"
                            name="code"
                            id="code"
                            class="form-control"
                            value="{{ request('code') }}"
                            placeholder="Cari kode kategori"
                        >
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            Cari
                        </button>

                        <a
                            href="{{ route('kategori-items.index') }}"
                            class="btn btn-secondary"
                        >
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($kategoriItems as $kategoriItem)
                            <tr>
                                <td>
                                    {{ $kategoriItems->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $kategoriItem->name }}
                                </td>

                                <td>
                                    {{ $kategoriItem->code }}
                                </td>

                                <td>
                                    <a
                                        href="{{ route('kategori-items.show', $kategoriItem) }}"
                                        class="btn btn-sm btn-info"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('kategori-items.edit', $kategoriItem) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('kategori-items.destroy', $kategoriItem) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum ada data kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $kategoriItems->links() }}
            </div>

        </div>
    </div>

</div>
@endsection