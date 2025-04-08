<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) : 'MedCarePro' ?></title>
    <link rel="stylesheet" href="../assets/css/stile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    </head>
<body>

<header>
<a href="index.php" class="logo">
    📋 MedCarePro
</a>

    <?php if (isset($_SESSION["username"])): ?>
    <div class="utente">
        👤 <?= htmlspecialchars($_SESSION["username"]) ?> (<?= $_SESSION["ruolo"] ?>)
    </div>
    <?php endif; ?>
</header>

<main>
