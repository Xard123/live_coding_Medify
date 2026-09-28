@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="mb-3">
                <a
                    href="{{ route('kategori-items.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>
            </div>

            <div class="card">

                <div class="card-header">
                    @if($method === 'new')
                        Tambah Kategori Item
                    @else
                        Edit Kategori Item
                    @endif
                </div>

                <div class="card-body">

                    @if($method === 'new')
                        <form
                            method="POST"
                            action="{{ route('kategori-items.store') }}"
                        >
                            @csrf
                    @else
                        <form
                            method="POST"
                            action="{{ route('kategori-items.update', $kategoriItem) }}"
                        >
                            @csrf
                            @method('PUT')
                    @endif

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $kategoriItem->name) }}"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Code --}}
                        <div class="mb-3">
                            <label for="code" class="form-label">
                                Kode
                            </label>

                            <input
                                type="text"
                                name="code"
                                id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $kategoriItem->code) }}"
                                required
                            >

                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Simpan
                        </button>

                        <a
                            href="{{ route('kategori-items.index') }}"
                            class="btn btn-secondary"
                        >
                            Batal
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection