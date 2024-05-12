var calendarEl = document.getElementById("fullcalendar");
var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: "prev,today,next",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
    },
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
        events: data,
    });

    calendar.render();
}
