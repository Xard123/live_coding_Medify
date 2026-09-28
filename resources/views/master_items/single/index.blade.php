@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="form-group mb-2">
                <a href="{{ url('master-items') }}" class="btn btn-secondary">
                    Kembali ke Daftar Item
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    Master Item
                </div>

                <div class="card-body">

                    {{-- Foto --}}
                    <div class="text-center mb-4">
                        @if($data->foto)
                            <img
                                src="{{ asset('storage/' . $data->foto) }}"
                                alt="{{ $data->nama }}"
                                width="180"
                                height="180"
                                style="object-fit: cover; border-radius: 10px;"
                            >
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>

                    <table class="table">
                        <tr>
                            <th width="180">Kode</th>
                            <td>:</td>
                            <td>{{ $data->kode }}</td>
                        </tr>

                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $data->nama }}</td>
                        </tr>

                        <tr>
                            <th>Harga Beli</th>
                            <td>:</td>
                            <td>
                                Rp {{ number_format($data->harga_beli, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Laba</th>
                            <td>:</td>
                            <td>{{ $data->laba }}%</td>
                        </tr>

                        <tr>
                            <th>Harga Jual</th>
                            <td>:</td>
                            <td>
                                Rp {{ number_format($data->harga_jual, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Supplier</th>
                            <td>:</td>
                            <td>{{ $data->supplier }}</td>
                        </tr>

                        <tr>
                            <th>Jenis</th>
                            <td>:</td>
                            <td>{{ $data->jenis }}</td>
                        </tr>

                        <tr>
                            <th>Kategori</th>
                            <td>:</td>
                            <td>
                                @if($data->categories->count() > 0)
                                    @foreach($data->categories as $category)
                                        <span class="badge bg-secondary me-1">
                                            {{ $category->name }}
                                            ({{ $category->code }})
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted">
                                        Belum ada kategori
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a
                            class="btn btn-info"
                            href="{{ url('master-items/form/edit') }}/{{ $data->id }}"
                        >
                            Edit
                        </a>

                        <a
                            class="btn btn-danger"
                            href="{{ url('master-items/delete') }}/{{ $data->id }}"
                            onclick="return confirm('Are you sure you want to delete this item?');"
                        >
                            Delete
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
@endsection