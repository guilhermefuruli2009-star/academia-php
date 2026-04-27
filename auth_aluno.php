<?php
// auth_aluno.php — inclua no início de cada página do aluno
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario_tipo'])) {
    header('Location: login.php');
    exit;
}
// Aluno e Admin podem ver as páginas do site
// (admin também tem acesso ao site como aluno)
