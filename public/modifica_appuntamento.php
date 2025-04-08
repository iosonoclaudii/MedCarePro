<?php
session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_SESSION["loggato"]) || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"]);
$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST["data"];
    $ora = $_POST["ora"];
    $stato = $_POST["stato"];
    $motivo = htmlspecialchars(trim($_POST["motivo"]));

    $stmt = $conn->prepare("UPDATE appuntamenti SET data_appuntamento = ?, ora_appuntamento = ?, motivo = ?, stato = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $data, $ora, $motivo, $stato, $id);
    $stmt->execute();
    $messaggio = "✅ Appuntamento aggiornato!";
}

$stmt = $conn->prepare("SELECT a.*, u.username FROM appuntamenti a JOIN utenti u ON a.id_cliente = u.id WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dati = $stmt->get_result()->fetch_assoc();

if (!$dati) {
    echo "Appuntamento non trovato.";
    exit;
}

$page_title = "Modifica Appuntamento";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>✏️ Modifica Appuntamento</h1>
<p><a href="dashboard.php">⬅️ Torna alla dashboard</a></p>

<?php if ($messaggio): ?>
    <div class="messaggio-successo"><?= $messaggio ?></div>
<?php endif; ?>

<form method="POST">
    <p><strong>Cliente:</strong> <?= htmlspecialchars($dati["username"]) ?></p>

    <label>Data:</label>
    <input type="date" name="data" value="<?= $dati['data_appuntamento'] ?>" required>

    <label>Ora:</label>
    <input type="time" name="ora" value="<?= $dati['ora_appuntamento'] ?>" required>

    <label>Motivo:</label>
    <textarea name="motivo" required><?= htmlspecialchars($dati["motivo"]) ?></textarea>

    <label>Stato:</label>
    <select name="stato" required>
        <option value="in attesa" <?= $dati["stato"] === "in attesa" ? "selected" : "" ?>>In attesa</option>
        <option value="confermato" <?= $dati["stato"] === "confermato" ? "selected" : "" ?>>Confermato</option>
        <option value="rifiutato" <?= $dati["stato"] === "rifiutato" ? "selected" : "" ?>>Rifiutato</option>
    </select>

    <button type="submit">Salva modifiche</button>
</form>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
