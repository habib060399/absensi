var calendarEl = document.getElementById("fullcalendar");
var id_siswa;
var tanggal_absen;

var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: "prev,today,next",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
    },
    editable: true,
});

calendar.render();

function calendarAbsen(data) {
    var calendarEl = document.getElementById("fullcalendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: "prev,today,next",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
        },
        dayMaxEventRows: true,
        views: {
            timeGrid: {
                dayMaxEventRows: 6,
            },
        },
        events: data,
        editable: true,
        dateClick: function (info) {
            $("#createEventModal").modal("show");
            $("#tanggal").val(info.dateStr);
        },
        eventClick: function (info) {
            var eventObj = info.event;
            var tanggal = eventObj._instance.range.start;
            console.log(tanggal);

            $("#modalTitle1").html(eventObj.title);
            $("#modalBody1").html(eventObj._def.extendedProps.description);
            // $("#hapus_absen").attr("href", eventObj.url);
            // $("#hapus_absen").attr("data-id", eventObj._def.publicId);
            // $("#hapus_absen").attr(
            //     "data-tanggal",
            //     eventObj._instance.range.start
            // );
            $(".hapus_absen").click(function () {
                hapus(eventObj._def.publicId, eventObj._instance.range.start);
            });
            $("#fullCalModal").modal("show");
            $("#edit_absen").click(function () {
                editAbsen(
                    eventObj._def.publicId,
                    eventObj._instance.range.start
                );
            });
        },
    });

    calendar.render();
}

function hapus(id, tanggal) {
    var get_tanggal = new Date(tanggal);
    var format_tanggal =
        get_tanggal.getFullYear() +
        "-" +
        ("0" + (get_tanggal.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + get_tanggal.getDate()).slice(-2);

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger me-2",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "me-2",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                window.location.href = `${url}/user/absen/hapus/${id}/${format_tanggal}`;
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                );
            }
        });
}

function editAbsen(id, tanggal) {
    id_siswa = id;
    var get_tanggal = new Date(tanggal);
    tanggal_absen =
        get_tanggal.getFullYear() +
        "-" +
        ("0" + (get_tanggal.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + get_tanggal.getDate()).slice(-2);

    $.ajax({
        url: url + "/user/absen/edit",
        type: "Get",
        data: { id_siswa: id, tanggal: tanggal_absen },
        beforeSend: function () {
            show_loading();
        },
        complete: function () {
            hide_loading();
        },
        success: function (res) {
            $("#get_status_absen").html(res);
        },
    });
}

function simpanEditAbsen() {
    var status_absen = $("#get_status_absen option:selected").val();

    $.ajax({
        url: url + "/user/absen/edit/simpan",
        type: "Post",
        data: { id: id_siswa, tanggal: tanggal_absen, status: status_absen },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            console.log(res);
            window.location.href = res.url;
        },
        error: function (xhr, status, error) {
            console.log(xhr, status, error);
        },
    });
}
