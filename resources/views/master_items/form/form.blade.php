<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
        </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if($selected == 'Umum') selected @endif>Umum</option>
            <option @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <div class="form-group mt-3"> <label for="foto">Foto</label>
        @if($method == 'edit' && $item->foto)
            <div class="mb-2"> <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" width="150"
                    height="150" style="object-fit: cover; border-radius: 8px;"> </div>
        @endif

        <input type="file" class="form-control" id="foto" name="foto"
            accept="image/jpeg,image/png,image/jpg,image/webp">
        <small class="text-muted"> Format: JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB. </small>
    </div> @error('foto')
        <div class="text-danger mt-2"> {{ $message }} </div>
    @enderror

    {{-- Kategori --}}
    <div class="form-group mt-3">
        <label class="mb-2">Kategori</label>

        @if($categories->count() > 0)

            @php
                $selectedCategories = old(
                    'category_ids',
                    $item->exists
                    ? $item->categories->pluck('id')->toArray()
                    : []
                );
            @endphp

            @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                        id="category_{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>

                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                        ({{ $category->code }})
                    </label>
                </div>
            @endforeach

        @else

            <div class="alert alert-warning">
                Belum ada kategori item.
                <a href="{{ route('kategori-items.create') }}">
                    Tambahkan kategori terlebih dahulu.
                </a>
            </div>

        @endif

        @error('category_ids')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
        @enderror

        @error('category_ids.*')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>