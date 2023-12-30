$(document).ready(function () {
    selesai();
});

function selesai() {
    setTimeout(function () {
        update();
        selesai();
    }, 200);
}

function update() {
    $.ajax({
        url: apiUrl,
        // url: "http://192.168.43.58:8080/api/absensi",
        type: "GET",
        dataType: "json",
        success: (res) => show(res),
        error: (err) => console.log(err),
    });
}
function show(data) {
    $("tbody").empty();
    $.each(data.message, function () {
        $("tbody").append(
            "<tr><td>" +
                this["rfid_tag"] +
                "</td><td>" +
                this["name"] +
                "</td><td>" +
                this["tanggal"] +
                "</td><td>" +
                this["waktu"] +
                "</td></tr>"
        );
    });
}
