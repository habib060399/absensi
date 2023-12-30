<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{url('NotReload.js')}}"></script>
    <script>
        var apiUrl = '{{env('APP_URL_API')}}'
    </script>
    @livewireStyles
</head>
<body>    
    <table>
        <thead>
            <tr>
                <th>RFID</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    @livewireScripts    
</body>
</html>