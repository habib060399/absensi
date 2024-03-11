<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('create_device') }}" method="post">
        @csrf
        <div>
            <label for="">Nama Sekolah</label>
            <input type="text" id="nama_sekolah" name="nama_sekolah">
        </div>
        <br />
        <div>
            <label for="">Id Perangkat</label>
            <input type="text" id="id_perangkat" name="id_perangkat" value="{{ $uniqId }}">
            <label for=""><button>Generate ID</button></label>
        </div>
        <button type="submit">Simpan</button>
    </form>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</body>

</html>
