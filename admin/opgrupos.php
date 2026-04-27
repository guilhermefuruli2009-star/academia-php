<?php
require_once 'auth_admin.php';
require 'config.php';

$acao = $_GET['acao'] ?? '';

if ($acao == 'cadastrar') {
    $nome = $_POST['txt_nome'] ?? '';
    $descricao = $_POST['txt_descricao'] ?? '';
    $icone = $_POST['txt_icone'] ?? 'bi-lightning-charge-fill';
    $cor = $_POST['txt_cor'] ?? 'primary';

    try {
        $sql = "INSERT INTO grupos_musculares (nome, descricao, icone, cor) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nome, $descricao, $icone, $cor]);
        header('Location: pggrupos.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pggrupos.php?erro=1');
    }
}

if ($acao == 'editar') {
    $id = $_GET['id'] ?? 0;
    $nome = $_POST['txt_nome'] ?? '';
    $descricao = $_POST['txt_descricao'] ?? '';
    $icone = $_POST['txt_icone'] ?? 'bi-lightning-charge-fill';
    $cor = $_POST['txt_cor'] ?? 'primary';

    try {
        $sql = "UPDATE grupos_musculares SET nome = ?, descricao = ?, icone = ?, cor = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nome, $descricao, $icone, $cor, $id]);
        header('Location: pggrupos.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pggrupos.php?erro=1');
    }
}

if ($acao == 'excluir') {
    $id = $_GET['id'] ?? 0;

    try {
        $sql = "DELETE FROM grupos_musculares WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        header('Location: pggrupos.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pggrupos.php?erro=1');
    }
}
