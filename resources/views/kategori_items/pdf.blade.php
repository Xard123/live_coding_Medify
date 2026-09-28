<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kategori {{$data->name}}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { margin-bottom: 4px; }
        .meta { margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Daftar Item Kategori</h2>
    <div class="meta">
        <div><strong>Nama Kategori:</strong> {{$data->name}}</div>
        <div><strong>Code:</strong> {{$data->code}}</div>
        <div><strong>Tanggal/Waktu Cetak:</strong> {{$printedAt->format('d-m-Y H:i:s')}}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Item</th>
                <th>Supplier</th>
                <th>Harga</th>
                <th>Laba</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data->masterItems as $index => $item)
            <tr>
                <td>{{$index + 1}}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->supplier}}</td>
                <td>{{$item->harga_beli}}</td>
                <td>{{$item->laba}}%</td>
                <td>{{round($item->harga_beli + ($item->harga_beli * $item->laba / 100))}}</td>
            </tr>
            @empty
            <tr><td colspan="7">Belum ada item pada kategori ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
