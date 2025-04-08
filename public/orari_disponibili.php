<?php
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_GET['data'])) {
    echo json_encode([]);
    exit;
}

$data = $_GET['data'];
$id_cliente = $_GET['cliente'] ?? null;

$orariTotali = [
    "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
    "14:00", "14:30", "15:00", "15:30", "16:00", "16:30",
    "17:00", "17:30", "18:00"
];

$stmt = $conn->prepare("SELECT ora_appuntamento FROM appuntamenti WHERE data_appuntamento = ? AND stato = 'confermato'");
$stmt->bind_param("s", $data);
$stmt->execute();
$res = $stmt->get_result();

$occupati = [];
while ($r = $res->fetch_assoc()) {
    $occupati[] = $r["ora_appuntamento"];
}

$disponibili = array_values(array_diff($orariTotali, $occupati));

header('Content-Type: application/json');
echo json_encode($disponibili);
?>