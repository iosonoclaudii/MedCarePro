<?php
session_start();
require_once __DIR__ . '/../private/includes/connessione.php';

if (!isset($_SESSION["loggato"]) || $_SESSION["ruolo"] !== "cliente") {
    header("Location: login.php");
    exit;
}

$id_cliente = $_SESSION["id"];
$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST["data"];
    $ora = $_POST["ora"];
    $motivo = htmlspecialchars(trim($_POST["motivo"]));

    if ($data && $ora && $motivo) {
        // Verifica se la fascia oraria è già confermata
        $stmtCheck = $conn->prepare("SELECT id FROM appuntamenti WHERE data_appuntamento = ? AND ora_appuntamento = ? AND stato = 'confermato'");
        $stmtCheck->bind_param("ss", $data, $ora);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $messaggio = "⚠️ Fascia oraria già occupata! Scegli un altro orario.";
        } else {
            // Inserisci nuova richiesta
            $stmt = $conn->prepare("INSERT INTO appuntamenti (id_cliente, data_appuntamento, ora_appuntamento, motivo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $id_cliente, $data, $ora, $motivo);
            $stmt->execute();
            $messaggio = "✅ Richiesta inviata!";
        }
    } else {
        $messaggio = "⚠️ Compila tutti i campi.";
    }
}

$stmt = $conn->prepare("SELECT * FROM appuntamenti WHERE id_cliente = ? ORDER BY data_appuntamento, ora_appuntamento");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$appuntamenti = $stmt->get_result();

$page_title = "Area Cliente";
include __DIR__ . '/../private/includes/header.php';
?>

<h1>📆 Area Cliente</h1>
<p><a href="profilo.php">⚙️ Modifica Profilo</a> | <a href="logout.php">Esci</a></p>

<?php if ($messaggio): ?>
    <div class="<?= str_starts_with($messaggio, '✅') ? 'messaggio-successo' : 'messaggio-errore' ?>">
        <?= $messaggio ?>
    </div>
<?php endif; ?>

<h2>Richiedi un appuntamento</h2>
<form method="POST">
    <label>Data:</label>
    <input type="date" name="data" id="data" required>

    <label>Ora:</label>
    <select name="ora" id="ora" required>
        <option value="">-- Seleziona una data prima --</option>
    </select>

    <label>Motivo:</label>
    <textarea name="motivo" required></textarea>

    <button type="submit">Invia Richiesta</button>
</form>

<script>
    const inputData = document.querySelector("input[name='data']");
    const selectOra = document.getElementById("ora");

    inputData.addEventListener("change", () => {
        const giorno = new Date(inputData.value).getDay();
        if (giorno === 0 || giorno === 6) {
            alert("⚠️ Puoi prenotare solo dal lunedì al venerdì.");
            inputData.value = "";
            selectOra.innerHTML = '<option value="">-- Seleziona una data valida --</option>';
            return;
        }

        fetch(`orari_disponibili.php?data=${inputData.value}`)
            .then(res => res.json())
            .then(orari => {
                selectOra.innerHTML = "";
                if (orari.length === 0) {
                    selectOra.innerHTML = '<option value="">Nessuna fascia disponibile</option>';
                } else {
                    selectOra.innerHTML = '<option value="">-- Seleziona un orario --</option>';
                    orari.forEach(ora => {
                        const opzione = document.createElement("option");
                        opzione.value = ora;
                        opzione.textContent = ora;
                        selectOra.appendChild(opzione);
                    });
                }
            });
    });

    const oggi = new Date().toISOString().split("T")[0];
    inputData.setAttribute("min", oggi);
</script>

<h2>I tuoi appuntamenti</h2>
<ul>
    <?php while ($app = $appuntamenti->fetch_assoc()): ?>
        <li>
            <?= $app['data_appuntamento'] ?> alle <?= $app['ora_appuntamento'] ?> —
            <strong><?= $app['stato'] ?></strong><br>
            <em><?= htmlspecialchars($app['motivo']) ?></em>
        </li>
    <?php endwhile; ?>
</ul>

<?php include __DIR__ . '/../private/includes/footer.php'; ?>
