<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee</title>
</head>

<body>
    <h2>Employee List</h2>
    <table border="1">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Alamat</th>
                <th scope="col">Telp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawan as $index=>$k)
            <tr>
                <th scope="row">{{ $index+1 }}</th>
                <td>{{ $k->nama }}</td>
                <td>{{ $k->email }}</td>
                <td>{{ $k->alamat }}</td>
                <td>{{ $k->telp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>