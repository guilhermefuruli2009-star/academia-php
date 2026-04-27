<?php
// auth_admin.php — inclua no início de cada página do admin
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../login.php?tipo=admin');
    exit;
}
