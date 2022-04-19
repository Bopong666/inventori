<!DOCTYPE html>
<html>

<head>
    <title>Laporan Permintaan</title>
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
        <h5>Data Permintaan
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead class="text-center">
            <th>No</th>
            <th>User</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Puskesmas</th>
            <th>Permintaan dibuat</th>
            <th>Status</th>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($datas as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{$data->user->name }}</td>
                <td>{{ $data->barang->nama_barang }}</td>
                <td>{{ $data->barang->jumlah }}</td>
                <td>{{ $data->keterangan }}</td>
                <td>{{ $data->puskesmas->puskesmas }}</td>
                <td>{{ $data->created_at->toDateString() }}</td>
                <td>
                    @if ($data->status = 'terima')
                    DITERIMA
                    @elseif($data->status = 'tolak')
                    DITOLAK
                    @else
                    BELUM DIPUTUSKAN
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>