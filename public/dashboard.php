<?php
session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_SESSION["loggato"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit;
}

// Statistiche
$totali     = $conn->query("SELECT COUNT(*) AS tot FROM appuntamenti")->fetch_assoc()['tot'];
$attesa     = $conn->query("SELECT COUNT(*) AS tot FROM appuntamenti WHERE stato = 'in attesa'")->fetch_assoc()['tot'];
$confermati = $conn->query("SELECT COUNT(*) AS tot FROM appuntamenti WHERE stato = 'confermato'")->fetch_assoc()['tot'];
$rifiutati  = $conn->query("SELECT COUNT(*) AS tot FROM appuntamenti WHERE stato = 'rifiutato'")->fetch_assoc()['tot'];

// Appuntamenti dettagliati
$query = "SELECT a.*, u.username FROM appuntamenti a
          JOIN utenti u ON a.id_cliente = u.id
          ORDER BY data_appuntamento, ora_appuntamento";
$result = $conn->query($query);

$page_title = "Dashboard Admin";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>📊 Dashboard Amministratore</h1>
<p>
    <a href="calendario.php">🗓️ Visualizza Calendario</a> |
    <a href="logout.php">Esci</a>
</p>

<h2>📌 Statistiche Appuntamenti</h2>
<ul>
    <li>Totale appuntamenti: <strong><?= $totali ?></strong></li>
    <li>In attesa: <strong><?= $attesa ?></strong></li>
    <li>Confermati: <strong><?= $confermati ?></strong></li>
    <li>Rifiutati: <strong><?= $rifiutati ?></strong></li>
</ul>

<h2>📅 Elenco completo</h2>
<table>
    <tr>
        <th>Cliente</th>
        <th>Data</th>
        <th>Ora</th>
        <th>Motivo</th>
        <th>Stato</th>
        <th>Azioni</th>
    </tr>
    <?php while ($app = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($app['username']) ?></td>
        <td><?= $app['data_appuntamento'] ?></td>
        <td><?= $app['ora_appuntamento'] ?></td>
        <td><?= htmlspecialchars($app['motivo']) ?></td>
        <td><?= $app['stato'] ?></td>
        <td>
            <?php if ($app['stato'] === 'in attesa'): ?>
                <a href="gestione_appuntamento.php?id=<?= $app['id'] ?>&azione=conferma">✅</a> |
                <a href="gestione_appuntamento.php?id=<?= $app['id'] ?>&azione=rifiuta">❌</a>
            <?php endif; ?>
            <a href="modifica_appuntamento.php?id=<?= $app['id'] ?>">✏️ Modifica</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
