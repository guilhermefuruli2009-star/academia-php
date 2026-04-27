<?php
require_once 'auth_aluno.php';
require 'admin/config.php';

$exercicio_id = $_GET['id'] ?? 0;

try {
    $stmt = $db->prepare("SELECT e.*, g.nome as grupo_nome, g.id as grupo_id FROM exercicios e
                         LEFT JOIN grupos_musculares g ON e.grupo_id = g.id
                         WHERE e.id = ?");
    $stmt->execute([$exercicio_id]);
    $exercicio = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$exercicio) { header('Location: index.php'); exit; }
} catch (Exception $e) {
    header('Location: index.php'); exit;
}

$badge_class = 'ae-badge-detalhe ae-badge-iniciante';
$cor_nivel = 'success';
if ($exercicio['nivel'] === 'Intermediário') { $badge_class = 'ae-badge-detalhe ae-badge-intermediario'; $cor_nivel = 'warning'; }
elseif ($exercicio['nivel'] === 'Avançado')  { $badge_class = 'ae-badge-detalhe ae-badge-avancado'; $cor_nivel = 'danger'; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($exercicio['nome']); ?> - Academia Corpo em Foco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background:var(--bg-black);color:var(--text-primary);">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ae-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-lightning-charge-fill"></i> CORPO EM FOCO
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house me-1"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="grupos.php?id=<?= $exercicio['grupo_id']; ?>"><i class="bi bi-grid me-1"></i>Grupos</a></li>
                    <li class="nav-item"><a class="nav-link" href="institucional.php"><i class="bi bi-info-circle me-1"></i>Informações</a></li>
                    <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link admin-link" href="admin/index.php">
                            <i class="bi bi-shield-lock-fill me-1"></i>Admin
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                           style="color:var(--text-primary)!important;background:var(--bg-card);border-radius:20px;border:1px solid rgba(255,255,255,0.08);padding:7px 16px!important">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text" style="color:var(--text-muted);font-size:12px;padding:6px 12px;">
                                    <i class="bi bi-<?= $_SESSION['usuario_tipo'] === 'admin' ? 'shield-fill' : 'person-fill' ?> me-1"
                                       style="color:<?= $_SESSION['usuario_tipo'] === 'admin' ? 'var(--orange)' : 'var(--blue)' ?>"></i>
                                    <?= $_SESSION['usuario_tipo'] === 'admin' ? 'Administrador' : 'Aluno' ?>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="admin/logout.php" style="color:var(--red)!important"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Header -->
    <div class="ae-hero">
        <div class="container">
            <a href="grupos.php?id=<?= $exercicio['grupo_id']; ?>" class="ae-hero-back">
                <i class="bi bi-arrow-left"></i> Voltar para <?= htmlspecialchars($exercicio['grupo_nome']); ?>
            </a>
            <h1><?= htmlspecialchars($exercicio['nome']); ?></h1>
            <span class="<?= $badge_class ?>"><?= $exercicio['nivel']; ?></span>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="container mb-5 mt-4">
        <div class="row g-4">

            <!-- Imagem + Instruções -->
            <div class="col-lg-8">
                <?php if ($exercicio['foto']) { ?>
                    <img src="admin/img/<?= htmlspecialchars($exercicio['foto']); ?>"
                         alt="<?= htmlspecialchars($exercicio['nome']); ?>"
                         class="ae-detail-img mb-4">
                <?php } else { ?>
                    <div class="ae-detail-img-placeholder mb-4">
                        <i class="bi bi-image" style="font-size:48px;margin-bottom:8px"></i>
                        <p style="color:var(--text-muted);margin:0;font-size:14px">Imagem não disponível</p>
                    </div>
                <?php } ?>

                <div class="ae-info-card">
                    <h4><i class="bi bi-book me-2" style="color:var(--orange)"></i>Instruções de Execução</h4>
                    <p class="ae-instructions">
                        <?= nl2br(htmlspecialchars($exercicio['descricao'])); ?>
                    </p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <div class="ae-info-card">
                    <h5><i class="bi bi-info-circle me-2" style="color:var(--orange)"></i>Informações</h5>

                    <div class="ae-info-row">
                        <div class="ae-info-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                        <div>
                            <div class="ae-info-label">Grupo Muscular</div>
                            <div class="ae-info-value"><?= htmlspecialchars($exercicio['grupo_nome']); ?></div>
                        </div>
                    </div>

                    <div class="ae-info-row">
                        <div class="ae-info-icon"><i class="bi bi-bar-chart-fill"></i></div>
                        <div>
                            <div class="ae-info-label">Nível</div>
                            <div class="mt-1"><span class="<?= $badge_class ?>"><?= $exercicio['nivel']; ?></span></div>
                        </div>
                    </div>

                    <div class="ae-info-row">
                        <div class="ae-info-icon"><i class="bi bi-repeat"></i></div>
                        <div>
                            <div class="ae-info-label">Séries</div>
                            <div class="ae-info-value"><?= $exercicio['series']; ?> séries</div>
                        </div>
                    </div>

                    <div class="ae-info-row">
                        <div class="ae-info-icon"><i class="bi bi-hash"></i></div>
                        <div>
                            <div class="ae-info-label">Repetições</div>
                            <div class="ae-info-value"><?= htmlspecialchars($exercicio['repeticoes']); ?></div>
                        </div>
                    </div>
                </div>

                <div class="ae-info-card">
                    <h5><i class="bi bi-lightbulb me-2" style="color:var(--yellow)"></i>Dicas</h5>
                    <div class="ae-tips-item"><i class="bi bi-check-circle-fill"></i>Mantenha a forma correta em todas as repetições</div>
                    <div class="ae-tips-item"><i class="bi bi-check-circle-fill"></i>Respire adequadamente durante o exercício</div>
                    <div class="ae-tips-item"><i class="bi bi-check-circle-fill"></i>Aumente a intensidade gradualmente</div>
                    <div class="ae-tips-item"><i class="bi bi-check-circle-fill"></i>Consulte um instrutor se tiver dúvidas</div>
                </div>

                <a href="grupos.php?id=<?= $exercicio['grupo_id']; ?>" class="btn btn-primary w-100" style="background:var(--orange);border:none;border-radius:14px;padding:14px;font-weight:700;font-size:15px;margin-top:4px">
                    <i class="bi bi-arrow-left me-2"></i> Voltar aos Exercícios
                </a>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="ae-footer">
        <p>&copy; 2024 Academia Corpo em Foco. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
