<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Produk</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #222; }
        .header { text-align: center; margin-bottom: 16px; }
        .product { display: flex; gap: 12px; margin-bottom: 12px; align-items: center; }
        .thumb { width: 90px; height: 90px; object-fit: cover; border: 1px solid #ddd; }
        .meta { flex: 1; }
        .price { font-weight: bold; }
        .small { color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { padding: 6px 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Daftar Produk Tersedia</h2>
        <div class="small">Generated: {{ now()->format('d M Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:100px">Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td style="text-align:center; vertical-align:middle;">
                        @if($p->image && file_exists(public_path('storage/' . $p->image)))
                            <img src="{{ public_path('storage/' . $p->image) }}" style="width:80px; height:80px; object-fit:cover;" />
                        @else
                            <div style="width:80px;height:80px;background:#f4f4f4;display:flex;align-items:center;justify-content:center;color:#999;">No Image</div>
                        @endif
                    </td>
                    <td>{{ $p->name }}</td>
                    <td>{{ optional($p->category)->name }}</td>
                    <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                    <td>{{ $p->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
