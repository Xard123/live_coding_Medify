@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mb-3">
            <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <a href="{{ route('kategori-items.pdf', $kategoriItem->id) }}" target="_blank" class="btn btn-danger">
                Cetak PDF
            </a>
            <a href="{{ route('kategori-items.edit', $kategoriItem) }}" class="btn btn-warning">
                Edit
            </a>
        </div>

        {{-- Detail Kategori --}}
        <div class="card mb-4">

            <div class="card-header">
                Detail Kategori Item
            </div>

            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-md-3 fw-bold">
                        Nama
                    </div>

                    <div class="col-md-9">
                        {{ $kategoriItem->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 fw-bold">
                        Kode
                    </div>

                    <div class="col-md-9">
                        {{ $kategoriItem->code }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Master Items --}}
        <div class="card">

            <div class="card-header">
                Master Items
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga Beli</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($kategoriItem->masterItems as $item)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->kode }}
                                    </td>

                                    <td>
                                        {{ $item->nama }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Belum ada Master Item dalam kategori ini.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection