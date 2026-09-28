<form method="POST" enctype="multipart/form-data">
    @csrf

    @if($method == 'edit')
    <div class="form-group mb-3">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{old('nama', $item->nama ?? '')}}">
    </div>

    <div class="form-group mb-3">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required min="0" value="{{old('harga_beli', $item->harga_beli ?? '')}}">
    </div>

    <div class="form-group mb-3">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required min="0" step="0.01" value="{{old('laba', $item->laba ?? '')}}">
    </div>

    @php $selected = old('supplier', $item->supplier ?? ''); @endphp
    <div class="form-group mb-3">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option value="">--Pilih--</option>
            @foreach(['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'] as $supplier)
                <option value="{{$supplier}}" @selected($selected === $supplier)>{{$supplier}}</option>
            @endforeach
        </select>
    </div>

    @php $selected = old('jenis', $item->jenis ?? ''); @endphp
    <div class="form-group mb-3">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option value="">--Pilih--</option>
            @foreach(['Obat','Alkes','Matkes','Umum','ATK'] as $jenis)
                <option value="{{$jenis}}" @selected($selected === $jenis)>{{$jenis}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label>Kategori</label>
        <select class="form-control" name="category_ids[]" multiple size="6">
            @foreach($categories as $category)
                <option value="{{$category->id}}" @selected($item->categories->contains('id', $category->id))>
                    {{$category->name}} ({{$category->code}})
                </option>
            @endforeach
        </select>
        <small class="text-muted">Gunakan Ctrl/Cmd untuk memilih beberapa kategori.</small>
    </div>

    <div class="form-group mb-3">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
        @if(!empty($item->foto))
            <div class="mt-2">
                <img src="{{asset('storage/'.$item->foto)}}" alt="{{$item->nama}}" style="max-width:180px;max-height:180px;">
            </div>
        @endif
    </div>

    <button class="btn btn-primary mt-2">Submit</button>
</form>