<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        var apiUrl = '{{ env('APP_URL_API') }}'
    </script>
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
    {{-- @vite('resources/js/app.js')
    <script type="module">
        Echo.channel(`Presence`)
            .listen('SendPresence', (e) => {
                console.log('hallo ini event');
                console.log(e.welcome);
                document.write("<h1>" + e.welcome + "</h1>")
            });
    </script> --}}
</body>

</html>
