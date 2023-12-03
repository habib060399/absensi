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
        url: "http://127.0.0.1:8000/api/absensi",
        type: "GET",
        dataType: "json",
        success: (res) => show(res.message),
        error: (err) => console.log(err),
    });
}
function show(data) {
    $("tbody").empty();
    $.each(data.user, function () {
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
