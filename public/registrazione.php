<?php

session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (isset($_SESSION["loggato"]) && $_SESSION["loggato"] === true) {
    if ($_SESSION["ruolo"] === "admin") {
        header("Location: dashboard.php");
    } elseif ($_SESSION["ruolo"] === "cliente") {
        header("Location: area_clienti.php");
    }
    exit;
}

$messaggio = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = $_POST["password"];

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id FROM utenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $messaggio = "⚠️ Username già in uso.";
        } else {
            $ruolo = "cliente";
            $stmt = $conn->prepare("INSERT INTO utenti (username, password, ruolo) VALUES (?, SHA2(?, 256), ?)");
            $stmt->bind_param("sss", $username, $password, $ruolo);
            $stmt->execute();
            $messaggio = "✅ Registrazione completata! Ora puoi accedere.";
        }
    } else {
        $messaggio = "⚠️ Compila tutti i campi.";
    }
}

$page_title = "Registrazione Cliente";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>👤 Registrazione Cliente</h1>

<?php if ($messaggio): ?>
    <div class="<?= str_starts_with($messaggio, '✅') ? 'messaggio-successo' : 'messaggio-errore' ?>">
        <?= $messaggio ?>
    </div>
<?php endif; ?>

<form method="POST">
    <label>Username:</label><input type="text" name="username" required>
    <label>Password:</label><input type="password" name="password" required>
    <button type="submit">Registrati</button>
</form>
<p>Hai già un account? <a href="login.php">Accedi</a></p>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
