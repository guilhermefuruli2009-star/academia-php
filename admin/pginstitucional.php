<?php
require_once 'auth_admin.php';
require 'menu.php';
require 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Informações Institucionais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-3">

        <h2 class="mb-4">Informações Institucionais</h2>

        <?php
        try {
            $info = $db->query("SELECT * FROM informacoes_institucionais LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $info = null;
        }
        ?>

        <form action="opinstitucional.php?acao=editar" method="post">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="txt_endereco" 
                            value="<?= htmlspecialchars($info['endereco'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="txt_telefone" 
                            value="<?= htmlspecialchars($info['telefone'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" name="txt_whatsapp" 
                            value="<?= htmlspecialchars($info['whatsapp'] ?? ''); ?>" placeholder="Ex: 5511999999999">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="txt_email" 
                            value="<?= htmlspecialchars($info['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <h4 class="mt-4 mb-3">Horários de Funcionamento</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Segunda a Sexta - Abertura</label>
                        <input type="time" class="form-control" name="txt_seg_sex_abertura" 
                            value="<?= htmlspecialchars($info['seg_sex_abertura'] ?? '06:00'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Segunda a Sexta - Fechamento</label>
                        <input type="time" class="form-control" name="txt_seg_sex_fechamento" 
                            value="<?= htmlspecialchars($info['seg_sex_fechamento'] ?? '22:00'); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sábado - Abertura</label>
                        <input type="time" class="form-control" name="txt_sabado_abertura" 
                            value="<?= htmlspecialchars($info['sabado_abertura'] ?? '08:00'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sábado - Fechamento</label>
                        <input type="time" class="form-control" name="txt_sabado_fechamento" 
                            value="<?= htmlspecialchars($info['sabado_fechamento'] ?? '18:00'); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Domingo - Abertura</label>
                        <input type="time" class="form-control" name="txt_domingo_abertura" 
                            value="<?= htmlspecialchars($info['domingo_abertura'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Domingo - Fechamento</label>
                        <input type="time" class="form-control" name="txt_domingo_fechamento" 
                            value="<?= htmlspecialchars($info['domingo_fechamento'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Marcas de Equipamentos Parceiras</label>
                <textarea class="form-control" name="txt_marcas" rows="3" placeholder="Ex: Marca 1, Marca 2, Marca 3"><?= htmlspecialchars($info['marcas'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Salvar Informações</button>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
