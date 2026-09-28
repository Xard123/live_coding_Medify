<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Kategori {{ $kategoriItem->name }}</title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 5px 0;
            font-size: 20px;
        }

        .header p {
            margin: 0;
            color: #666;
        }

        .category-info {
            margin-bottom: 20px;
        }

        .category-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .category-info td {
            padding: 5px;
        }

        .category-info .label {
            width: 120px;
            font-weight: bold;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.items th {
            background: #eeeeee;
            font-weight: bold;
            text-align: center;
        }

        table.items th,
        table.items td {
            border: 1px solid #999;
            padding: 7px 5px;
        }

        table.items td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .footer {
            margin-top: 25px;
            font-size: 9px;
            color: #777;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>DAFTAR MASTER ITEMS</h1>
        <p>Berdasarkan Kategori</p>
    </div>

    <div class="category-info">
        <table>
            <tr>
                <td class="label">Nama Kategori</td>
                <td>: {{ $kategoriItem->name }}</td>
            </tr>

            <tr>
                <td class="label">Kode Kategori</td>
                <td>: {{ $kategoriItem->code }}</td>
            </tr>

            <tr>
                <td class="label">Jumlah Items</td>
                <td>: {{ $kategoriItem->masterItems->count() }}</td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode</th>
                <th width="25%">Nama Items</th>
                <th width="20%">Supplier</th>
                <th width="15%">Harga Beli</th>
                <th width="10%">Laba</th>
                <th width="15%">Harga Jual</th>
            </tr>
        </thead>

        <tbody>
            @forelse($kategoriItem->masterItems as $index => $item)
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $item->kode }}
                    </td>

                    <td>
                        {{ $item->nama }}
                    </td>

                    <td>
                        {{ $item->supplier }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        {{ number_format($item->laba, 2, ',', '.') }}%
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">
                        Belum ada Master Items pada kategori ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada:
        {{ now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>