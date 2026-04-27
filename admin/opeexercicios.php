<?php
require_once 'auth_admin.php';
require 'config.php';

$acao = $_GET['acao'] ?? '';

function salvarFoto($file) {
    if (!isset($file['tmp_name']) || $file['size'] == 0) return null;

    $pasta = __DIR__ . '/img/';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }

    $timestamp = time();
    $nome_arquivo = $timestamp . '_' . basename($file['name']);
    $caminho = $pasta . $nome_arquivo;

    if (move_uploaded_file($file['tmp_name'], $caminho)) {
        return $nome_arquivo;
    }

    return null;
}

if ($acao == 'cadastrar') {
    $grupo_id = $_POST['txt_grupo'] ?? 0;
    $nome = $_POST['txt_nome'] ?? '';
    $descricao = $_POST['txt_descricao'] ?? '';
    $series = $_POST['txt_series'] ?? 3;
    $repeticoes = $_POST['txt_repeticoes'] ?? '12';
    $nivel = $_POST['txt_nivel'] ?? 'Iniciante';
    
    $foto = salvarFoto($_FILES['file_foto'] ?? []);

    try {
        $sql = "INSERT INTO exercicios (grupo_id, nome, descricao, series, repeticoes, nivel, foto) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$grupo_id, $nome, $descricao, $series, $repeticoes, $nivel, $foto]);
        header('Location: pgeexercicios.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pgeexercicios.php?erro=1');
    }
}

if ($acao == 'editar') {
    $id = $_GET['id'] ?? 0;
    $grupo_id = $_POST['txt_grupo'] ?? 0;
    $nome = $_POST['txt_nome'] ?? '';
    $descricao = $_POST['txt_descricao'] ?? '';
    $series = $_POST['txt_series'] ?? 3;
    $repeticoes = $_POST['txt_repeticoes'] ?? '12';
    $nivel = $_POST['txt_nivel'] ?? 'Iniciante';
    
    $foto = salvarFoto($_FILES['file_foto'] ?? []);

    try {
        if ($foto) {
            $sql = "UPDATE exercicios SET grupo_id = ?, nome = ?, descricao = ?, series = ?, repeticoes = ?, nivel = ?, foto = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$grupo_id, $nome, $descricao, $series, $repeticoes, $nivel, $foto, $id]);
        } else {
            $sql = "UPDATE exercicios SET grupo_id = ?, nome = ?, descricao = ?, series = ?, repeticoes = ?, nivel = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$grupo_id, $nome, $descricao, $series, $repeticoes, $nivel, $id]);
        }
        header('Location: pgeexercicios.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pgeexercicios.php?erro=1');
    }
}

if ($acao == 'excluir') {
    $id = $_GET['id'] ?? 0;

    try {
        $sql = "DELETE FROM exercicios WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        header('Location: pgeexercicios.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pgeexercicios.php?erro=1');
    }
}
