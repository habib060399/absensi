var calendarEl = document.getElementById("fullcalendar");
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
            console.log(info);
        },
        eventClick: function (info) {
            var eventObj = info.event;
            console.log(info);
            $("#modalTitle1").html(eventObj.title);
            $("#modalBody1").html(eventObj._def.extendedProps.description);
            $("#eventUrl").attr("href", eventObj.url);
            $("#fullCalModal").modal("show");
        },
    });

    calendar.render();
}
