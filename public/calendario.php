<?php
session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_SESSION["loggato"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit;
}

$appuntamenti = [];
$result = $conn->query("SELECT a.*, u.username FROM appuntamenti a JOIN utenti u ON a.id_cliente = u.id");
while ($row = $result->fetch_assoc()) {
    $appuntamenti[] = [
        "title" => $row["username"] . " - " . $row["stato"],
        "start" => $row["data_appuntamento"] . "T" . $row["ora_appuntamento"],
        "description" => $row["motivo"]
    ];
}

$page_title = "Calendario Appuntamenti";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>🗓️ Calendario Appuntamenti</h1>
<p><a href="dashboard.php">🔙 Torna alla dashboard</a></p>

<div id="calendar" style="margin-top: 30px;"></div>

<!-- FullCalendar - CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Calendario FullCalendar -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        firstDay: 1, // Settimana parte da lunedì
        height: 'auto',
        events: <?= json_encode($appuntamenti) ?>,
        eventDidMount: function(info) {
            if (info.event.extendedProps.description) {
                info.el.title = info.event.extendedProps.description;
            }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        eventDisplay: 'block'
    });

    calendar.render();
});
</script>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
