<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thai Public Holidays Calendar</title>
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction/main.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'dayGrid', 'interaction' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      events: [
        // Add Thai public holidays and important events here
        // Example: { title: 'New Year', start: '2024-01-01' }
      ]
    });
    calendar.render();
  });
</script>
</head>
<body>
<div id='calendar'></div>
</body>
</html>
