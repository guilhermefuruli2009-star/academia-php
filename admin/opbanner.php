<?php
require_once 'auth_admin.php';
require 'config.php';
header('Content-Type: application/json');

$acao = $_GET['acao'] ?? '';

function responder($sucesso, $msg = '') {
    echo json_encode(['sucesso' => $sucesso, 'msg' => $msg]);
    exit;
}

if ($acao == 'cadastrar') {
    $titulo    = trim($_POST['txt_titulo']    ?? '');
    $subtitulo = trim($_POST['txt_subtitulo'] ?? '');
    $badge     = trim($_POST['txt_badge']     ?? '');
    $cor       = $_POST['txt_cor']   ?? 'primary';
    $ordem     = intval($_POST['txt_ordem']   ?? 0);
    $ativo     = 1;

    if ($titulo === '' || $badge === '') responder(false, 'Título e Badge são obrigatórios.');

    try {
        $stmt = $db->prepare("INSERT INTO avisos (titulo, subtitulo, badge, cor, ordem, ativo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $subtitulo, $badge, $cor, $ordem, $ativo]);
        responder(true);
    } catch (Exception $e) { responder(false, $e->getMessage()); }
}

if ($acao == 'editar') {
    $id        = intval($_GET['id'] ?? 0);
    $titulo    = trim($_POST['txt_titulo']    ?? '');
    $subtitulo = trim($_POST['txt_subtitulo'] ?? '');
    $badge     = trim($_POST['txt_badge']     ?? '');
    $cor       = $_POST['txt_cor']   ?? 'primary';
    $ordem     = intval($_POST['txt_ordem']   ?? 0);

    if ($id <= 0 || $titulo === '') responder(false, 'Dados inválidos.');

    try {
        $stmt = $db->prepare("UPDATE avisos SET titulo = ?, subtitulo = ?, badge = ?, cor = ?, ordem = ? WHERE id = ?");
        $stmt->execute([$titulo, $subtitulo, $badge, $cor, $ordem, $id]);
        responder(true);
    } catch (Exception $e) { responder(false, $e->getMessage()); }
}

if ($acao == 'excluir') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) responder(false, 'ID inválido.');

    try {
        $stmt = $db->prepare("DELETE FROM avisos WHERE id = ?");
        $stmt->execute([$id]);
        responder(true);
    } catch (Exception $e) { responder(false, $e->getMessage()); }
}

responder(false, 'Ação inválida.');
