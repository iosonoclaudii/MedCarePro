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

$errore = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM utenti WHERE username = ? AND password = SHA2(?, 256)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($utente = $result->fetch_assoc()) {
        $_SESSION["loggato"] = true;
        $_SESSION["username"] = $utente["username"];
        $_SESSION["ruolo"] = $utente["ruolo"];
        $_SESSION["id"] = $utente["id"];
        header("Location: " . ($utente["ruolo"] === "admin" ? "dashboard.php" : "area_clienti.php"));
        exit;
    } else {
        $errore = "❌ Credenziali non valide.";
    }
}

$page_title = "Login MedCarePro";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>🔐 Login</h1>

<?php if ($errore): ?>
    <div class="messaggio-errore"><?= $errore ?></div>
<?php endif; ?>

<form method="POST">
    <label>Username:</label><input type="text" name="username" required>
    <label>Password:</label><input type="password" name="password" required>
    <button type="submit">Accedi</button>
</form>

<p>Non hai un account? <a href="registrazione.php">Registrati</a></p>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
