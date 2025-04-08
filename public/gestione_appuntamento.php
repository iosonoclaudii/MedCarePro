<?php
session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_SESSION["loggato"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"]);
$azione = $_GET["azione"];

if (in_array($azione, ["conferma", "rifiuta"])) {
    $nuovoStato = ($azione === "conferma") ? "confermato" : "rifiutato";
    $stmt = $conn->prepare("UPDATE appuntamenti SET stato = ? WHERE id = ?");
    $stmt->bind_param("si", $nuovoStato, $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit;
