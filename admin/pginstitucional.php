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
</head>
<body class="admin-body">

    <div class="container py-4">

        <div class="admin-page-header">
            <h1><i class="bi bi-info-circle-fill me-2" style="color:var(--orange)"></i>Informações Institucionais</h1>
            <p>Dados de contato, horários e informações gerais da academia</p>
        </div>

        <!-- FEEDBACK -->
        <?php if (isset($_GET['status'])): ?>
        <div id="feedbackMsg" style="
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 28px;
            border: 1px solid;
            <?= $_GET['status'] === 'ok'
                ? 'background:rgba(48,209,88,0.12);color:var(--green);border-color:rgba(48,209,88,0.3);'
                : 'background:rgba(255,69,58,0.12);color:var(--red);border-color:rgba(255,69,58,0.3);' ?>
        ">
            <i class="bi <?= $_GET['status'] === 'ok' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?> me-2"></i>
            <?= $_GET['status'] === 'ok' ? 'Informações salvas com sucesso!' : 'Erro ao salvar. Tente novamente.' ?>
        </div>
        <?php endif; ?>

        <?php
        try {
            $info = $db->query("SELECT * FROM informacoes_institucionais LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $info = null;
        }
        ?>

        <form action="opinstitucional.php?acao=editar" method="post">

            <!-- CONTATO -->
            <div class="ae-info-card mb-4">
                <h4><i class="bi bi-telephone-fill me-2" style="color:var(--orange)"></i>Dados de Contato</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                            Endereço
                        </label>
                        <input type="text" class="form-control" name="txt_endereco"
                            value="<?= htmlspecialchars($info['endereco'] ?? ''); ?>"
                            placeholder="Rua, número, bairro...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                            Telefone
                        </label>
                        <input type="text" class="form-control" name="txt_telefone"
                            value="<?= htmlspecialchars($info['telefone'] ?? ''); ?>"
                            placeholder="(XX) XXXXX-XXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                            WhatsApp
                        </label>
                        <div style="position:relative">
                            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--green);font-size:16px">
                                <i class="bi bi-whatsapp"></i>
                            </span>
                            <input type="text" class="form-control" name="txt_whatsapp"
                                value="<?= htmlspecialchars($info['whatsapp'] ?? ''); ?>"
                                placeholder="5511999999999"
                                style="padding-left:40px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                            E-mail
                        </label>
                        <input type="email" class="form-control" name="txt_email"
                            value="<?= htmlspecialchars($info['email'] ?? ''); ?>"
                            placeholder="contato@academia.com.br">
                    </div>
                </div>
            </div>

            <!-- HORÁRIOS -->
            <div class="ae-info-card mb-4">
                <h4><i class="bi bi-clock-fill me-2" style="color:var(--orange)"></i>Horários de Funcionamento</h4>

                <!-- Seg-Sex -->
                <div style="margin-bottom:20px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                        <span class="nivel-badge nivel-iniciante">Seg – Sex</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                                Abertura
                            </label>
                            <input type="time" class="form-control" name="txt_seg_sex_abertura"
                                value="<?= htmlspecialchars($info['seg_sex_abertura'] ?? '06:00'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                                Fechamento
                            </label>
                            <input type="time" class="form-control" name="txt_seg_sex_fechamento"
                                value="<?= htmlspecialchars($info['seg_sex_fechamento'] ?? '22:00'); ?>">
                        </div>
                    </div>
                </div>

                <!-- Sábado -->
                <div style="margin-bottom:20px;border-top:1px solid rgba(255,255,255,0.05);padding-top:20px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                        <span class="nivel-badge nivel-intermediario">Sábado</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                                Abertura
                            </label>
                            <input type="time" class="form-control" name="txt_sabado_abertura"
                                value="<?= htmlspecialchars($info['sabado_abertura'] ?? '08:00'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                                Fechamento
                            </label>
                            <input type="time" class="form-control" name="txt_sabado_fechamento"
                                value="<?= htmlspecialchars($info['sabado_fechamento'] ?? '18:00'); ?>">
                        </div>
                    </div>
                </div>

                <!-- Domingo -->
                <div style="border-top:1px solid rgba(255,255,255,0.05);padding-top:20px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                        <span class="nivel-badge nivel-avancado">Domingo</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                                Abertura
                            </label>
                            <input type="time" class="form-control" name="txt_domingo_abertura"
                                value="<?= htmlspecialchars($info['domingo_abertura'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                                Fechamento
                            </label>
                            <input type="time" class="form-control" name="txt_domingo_fechamento"
                                value="<?= htmlspecialchars($info['domingo_fechamento'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PARCEIROS -->
            <div class="ae-info-card mb-4">
                <h4><i class="bi bi-stars me-2" style="color:var(--orange)"></i>Marcas Parceiras</h4>
                <div>
                    <label class="form-label" style="color:var(--text-muted);font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">
                        Marcas de Equipamentos Parceiras
                    </label>
                    <textarea class="form-control" name="txt_marcas" rows="3"
                        placeholder="Ex: Marca 1, Marca 2, Marca 3"><?= htmlspecialchars($info['marcas'] ?? ''); ?></textarea>
                    <small style="color:var(--text-muted);font-size:12px;margin-top:6px;display:block">
                        Separe as marcas por vírgula.
                    </small>
                </div>
            </div>

            <!-- SALVAR -->
            <div style="display:flex;justify-content:flex-end">
                <button type="submit" class="admin-btn-add" style="font-size:15px;padding:12px 32px">
                    <i class="bi bi-floppy-fill"></i> Salvar Informações
                </button>
            </div>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Auto-dismiss feedback
    const fb = document.getElementById('feedbackMsg');
    if (fb) setTimeout(() => fb.style.opacity = '0', 4000);
    </script>

</body>
</html>
