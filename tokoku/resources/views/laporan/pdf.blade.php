<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    h1 {
        text-align: center;
    }
</style>

<body>
    <h1>KIOS ASOY</h1>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Sub Total</th>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->harga_jual }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
            @if ($data)
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="3">{{ $data->sum('total') }}</td>
                </tr>
            @endif

            @foreach ($data as $row)
                $row->bayar;
                $row->kembalian;
            @endforeach
            <tr>
                <td colspan="2">Bayar</td>
                <td colspan="3">{{ $row->bayar }}</td>
            </tr>
            <tr>
                <td colspan="2">Kembalian</td>
                <td colspan="3">{{ $row->kembalian }}</td>
            </tr>
        </tbody>
    </table>


</body>

</html>
