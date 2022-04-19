<!DOCTYPE html>
<html>

<head>
    <title>Laporan Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Data Stok Barang
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead class="text-center">
            <th>No</th>
            <th>Kode Barang</th>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Stok Awal</th>
            <th>Barang Masuk</th>
            <th>Barang Keluar</th>
            <th>Sisa Stok</th>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($datas as $data)
            <tr>
                <td>{{ $i++ }}</td>
                @php
                if($data->id > 9){
                $kode_barang = 'P00'.$data->id;
                }else{
                $kode_barang = 'P000'.$data->id;
                }
                @endphp
                <td>{{$kode_barang }}</td>
                <td>{{ $data->kategori->kategori }}</td>
                <td>{{ $data->nama_barang }}</td>
                <td>{{ $data->stok_awal }}</td>
                <td>{{ $data->masuk_sum_jumlah }}</td>
                <td>{{ $data->permintaan_sum_jumlah }}</td>
                <td>{{ $data->stok_akhir }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>