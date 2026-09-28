@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('kategori-items')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">
                    {{$method === 'new' ? 'Buat Kategori Baru' : 'Edit Kategori'}}
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" required value="{{old('name', $item->name)}}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Code</label>
                            <input type="text" class="form-control" name="code" required value="{{old('code', $item->code)}}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Master Items</label>
                            <select class="form-control" name="master_item_ids[]" multiple size="8">
                                @foreach(\App\Models\MasterItem::orderBy('nama')->get() as $masterItem)
                                    <option value="{{$masterItem->id}}"
                                        @if($item->masterItems->contains('id', $masterItem->id)) selected @endif>
                                        {{$masterItem->kode}} - {{$masterItem->nama}}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Gunakan Ctrl/Cmd untuk memilih beberapa item.</small>
                        </div>
                        <button class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
