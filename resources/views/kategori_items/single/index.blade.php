@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2">
                <a href="{{url('kategori-items')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
                <a href="{{url('kategori-items/pdf')}}/{{$data->id}}" class="btn btn-success">Print PDF</a>
                <a href="{{url('kategori-items/form/edit')}}/{{$data->id}}" class="btn btn-primary">Edit</a>
                <a href="{{url('kategori-items/delete')}}/{{$data->id}}" class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
            </div>

            <div class="card">
                <div class="card-header">Detail Kategori</div>
                <div class="card-body">
                    <table class="mb-4">
                        <tr><th>Nama</th><td class="px-2">:</td><td>{{$data->name}}</td></tr>
                        <tr><th>Code</th><td class="px-2">:</td><td>{{$data->code}}</td></tr>
                    </table>

                    <h5>Master Items</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Supplier</th>
                                <th>Harga</th>
                                <th>Laba</th>
                                <th>Harga Jual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->masterItems as $index => $item)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->supplier}}</td>
                                <td>{{$item->harga_beli}}</td>
                                <td>{{$item->laba}}%</td>
                                <td>{{round($item->harga_beli + ($item->harga_beli * $item->laba / 100))}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
