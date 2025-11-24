<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/customizacao.css" rel="stelysheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.css' rel='stylesheet' />
    <title>tutorial calendario</title>

    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: "pt-br"
        });
        calendar.render();
      });

    </script>
</head>
<body>
    <div id='calendar'></div>

    <script src="js/index.global.min.js"></script>
    <script src="js/locale/pt-br.js"></script>
    <script src="js/customizacao.js"></script>
</body>
</html>