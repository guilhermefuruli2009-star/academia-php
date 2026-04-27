<?php
require_once 'auth_admin.php';
require 'config.php';

$acao = $_GET['acao'] ?? '';

if ($acao == 'editar') {
    $endereco = $_POST['txt_endereco'] ?? '';
    $telefone = $_POST['txt_telefone'] ?? '';
    $whatsapp = $_POST['txt_whatsapp'] ?? '';
    $email = $_POST['txt_email'] ?? '';
    $seg_sex_abertura = $_POST['txt_seg_sex_abertura'] ?? '06:00';
    $seg_sex_fechamento = $_POST['txt_seg_sex_fechamento'] ?? '22:00';
    $sabado_abertura = $_POST['txt_sabado_abertura'] ?? '08:00';
    $sabado_fechamento = $_POST['txt_sabado_fechamento'] ?? '18:00';
    $domingo_abertura = $_POST['txt_domingo_abertura'] ?? '';
    $domingo_fechamento = $_POST['txt_domingo_fechamento'] ?? '';
    $marcas = $_POST['txt_marcas'] ?? '';

    try {
        // Verificar se já existe registro
        $existe = $db->query("SELECT COUNT(*) as total FROM informacoes_institucionais")->fetch(PDO::FETCH_ASSOC);
        
        if ($existe['total'] > 0) {
            $sql = "UPDATE informacoes_institucionais SET 
                    endereco = ?, telefone = ?, whatsapp = ?, email = ?,
                    seg_sex_abertura = ?, seg_sex_fechamento = ?,
                    sabado_abertura = ?, sabado_fechamento = ?,
                    domingo_abertura = ?, domingo_fechamento = ?, marcas = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$endereco, $telefone, $whatsapp, $email, 
                           $seg_sex_abertura, $seg_sex_fechamento,
                           $sabado_abertura, $sabado_fechamento,
                           $domingo_abertura, $domingo_fechamento, $marcas]);
        } else {
            $sql = "INSERT INTO informacoes_institucionais 
                    (endereco, telefone, whatsapp, email, seg_sex_abertura, seg_sex_fechamento,
                     sabado_abertura, sabado_fechamento, domingo_abertura, domingo_fechamento, marcas)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$endereco, $telefone, $whatsapp, $email,
                           $seg_sex_abertura, $seg_sex_fechamento,
                           $sabado_abertura, $sabado_fechamento,
                           $domingo_abertura, $domingo_fechamento, $marcas]);
        }
        header('Location: pginstitucional.php?sucesso=1');
    } catch (Exception $e) {
        header('Location: pginstitucional.php?erro=1&msg=' . urlencode($e->getMessage()));
    }
}
