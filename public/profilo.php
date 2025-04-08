<?php
session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_SESSION["loggato"]) || $_SESSION["ruolo"] !== "cliente") {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["id"];
$messaggio = "";

// Aggiornamento dati profilo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars(trim($_POST["email"]));
    $telefono = htmlspecialchars(trim($_POST["telefono"]));
    $password_corrente = $_POST["password_corrente"];
    $nuova_password = $_POST["nuova_password"];

    // Aggiorna email/telefono
    $stmt = $conn->prepare("UPDATE utenti SET email = ?, telefono = ? WHERE id = ?");
    $stmt->bind_param("ssi", $email, $telefono, $id);
    $stmt->execute();

    // Cambio password se richiesto
    if (!empty($password_corrente) && !empty($nuova_password)) {
        $stmt = $conn->prepare("SELECT id FROM utenti WHERE id = ? AND password = SHA2(?, 256)");
        $stmt->bind_param("is", $id, $password_corrente);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE utenti SET password = SHA2(?, 256) WHERE id = ?");
            $stmt->bind_param("si", $nuova_password, $id);
            $stmt->execute();
            $messaggio = "✅ Profilo aggiornato e password cambiata!";
        } else {
            $messaggio = "❌ Password attuale errata. Profilo aggiornato senza cambiare password.";
        }
    } else {
        $messaggio = "✅ Profilo aggiornato!";
    }
}

// Recupera dati attuali
$stmt = $conn->prepare("SELECT username, email, telefono FROM utenti WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$utente = $stmt->get_result()->fetch_assoc();

$page_title = "Il mio Profilo";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>👤 Il mio Profilo</h1>
<p><a href="area_clienti.php">⬅️ Torna all'area cliente</a></p>

<?php if ($messaggio): ?>
    <div class="<?= str_starts_with($messaggio, '✅') ? 'messaggio-successo' : 'messaggio-errore' ?>">
        <?= $messaggio ?>
    </div>
<?php endif; ?>

<form method="POST">
    <label>Username:</label>
    <input type="text" value="<?= htmlspecialchars($utente['username']) ?>" disabled>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($utente['email']) ?>">

    <label>Telefono:</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($utente['telefono']) ?>">

    <hr>
    <h3>🔑 Cambia Password (opzionale)</h3>
    <label>Password attuale:</label>
    <input type="password" name="password_corrente">
    <label>Nuova password:</label>
    <input type="password" name="nuova_password">

    <button type="submit">Aggiorna Profilo</button>
</form>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
