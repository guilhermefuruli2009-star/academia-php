<?php
require_once 'auth_aluno.php';
require 'admin/config.php';

try {
    $info = $db->query("SELECT * FROM informacoes_institucionais LIMIT 1")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $info = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações - Academia Corpo em Foco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-lightning-charge-fill"></i> Academia Corpo em Foco
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#grupos">Grupos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Informações</a></li>
                    <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link text-warning fw-semibold" href="admin/index.php"><i class="bi bi-shield-lock-fill me-1"></i>Painel Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted small">
                                <i class="bi bi-<?= $_SESSION['usuario_tipo'] === 'admin' ? 'shield-fill text-warning' : 'person-fill text-primary' ?>"></i>
                                <?= $_SESSION['usuario_tipo'] === 'admin' ? 'Administrador' : 'Aluno' ?>
                            </span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="admin/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-primary text-white py-5 mb-4">
        <div class="container">
            <a href="index.php" class="text-white text-decoration-none mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
            <h1 class="fw-bold">Informações da Academia</h1>
            <p class="lead mb-0">Conheça mais sobre a Academia Corpo em Foco</p>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="container mb-5">
        <div class="row">

            <!-- Contato -->
            <div class="col-lg-6">
                <div class="card mb-4 shadow-sm border-start border-primary border-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-semibold mb-4"><i class="bi bi-telephone"></i> Contato</h5>

                        <?php if ($info && $info['endereco']) { ?>
                            <div class="d-flex align-items-start mb-3">
                                <i class="bi bi-geo-alt-fill fs-4 text-primary me-3 mt-1"></i>
                                <div>
                                    <span class="fw-semibold d-block">Endereço</span>
                                    <span class="text-muted"><?= htmlspecialchars($info['endereco']); ?></span>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($info && $info['telefone']) { ?>
                            <div class="d-flex align-items-start mb-3">
                                <i class="bi bi-telephone-fill fs-4 text-primary me-3 mt-1"></i>
                                <div>
                                    <span class="fw-semibold d-block">Telefone</span>
                                    <a href="tel:<?= htmlspecialchars($info['telefone']); ?>" class="text-muted text-decoration-none">
                                        <?= htmlspecialchars($info['telefone']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($info && $info['email']) { ?>
                            <div class="d-flex align-items-start mb-3">
                                <i class="bi bi-envelope-fill fs-4 text-primary me-3 mt-1"></i>
                                <div>
                                    <span class="fw-semibold d-block">Email</span>
                                    <a href="mailto:<?= htmlspecialchars($info['email']); ?>" class="text-muted text-decoration-none">
                                        <?= htmlspecialchars($info['email']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($info && $info['whatsapp']) { ?>
                            <div class="d-flex align-items-start">
                                <i class="bi bi-whatsapp fs-4 text-success me-3 mt-1"></i>
                                <div>
                                    <span class="fw-semibold d-block mb-1">WhatsApp</span>
                                    <a href="https://wa.me/<?= htmlspecialchars($info['whatsapp']); ?>" target="_blank" class="btn btn-success btn-sm">
                                        <i class="bi bi-whatsapp"></i> Abrir WhatsApp
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Horários -->
            <div class="col-lg-6">
                <div class="card mb-4 shadow-sm border-start border-primary border-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-semibold mb-4"><i class="bi bi-clock"></i> Horários de Funcionamento</h5>

                        <?php if ($info) { ?>
                            <div class="d-flex justify-content-between py-3 border-bottom">
                                <span class="fw-semibold">Segunda a Sexta</span>
                                <span class="text-primary fw-medium">
                                    <?= htmlspecialchars($info['seg_sex_abertura'] ?? '06:00'); ?> - <?= htmlspecialchars($info['seg_sex_fechamento'] ?? '22:00'); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between py-3 border-bottom">
                                <span class="fw-semibold">Sábado</span>
                                <span class="text-primary fw-medium">
                                    <?= htmlspecialchars($info['sabado_abertura'] ?? '08:00'); ?> - <?= htmlspecialchars($info['sabado_fechamento'] ?? '18:00'); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between py-3">
                                <span class="fw-semibold">Domingo</span>
                                <?php if ($info['domingo_abertura'] && $info['domingo_fechamento']) { ?>
                                    <span class="text-primary fw-medium">
                                        <?= htmlspecialchars($info['domingo_abertura']); ?> - <?= htmlspecialchars($info['domingo_fechamento']); ?>
                                    </span>
                                <?php } else { ?>
                                    <span class="text-muted">Fechado</span>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <p class="text-muted">Informações de horário não disponíveis</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marcas -->
        <?php if ($info && $info['marcas']) { ?>
            <div class="card mb-4 shadow-sm border-start border-primary border-3">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-semibold mb-3"><i class="bi bi-box-seam"></i> Marcas de Equipamentos Parceiras</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $marcas = array_map('trim', explode(',', $info['marcas']));
                        foreach ($marcas as $marca) {
                            if (!empty($marca)) {
                                echo '<span class="badge bg-light text-dark border fs-6 fw-normal px-3 py-2">' . htmlspecialchars($marca) . '</span>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-left"></i> Voltar à Página Inicial
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Academia Corpo em Foco. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
