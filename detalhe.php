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

$cor_nivel = 'info';
if ($exercicio['nivel'] === 'Iniciante')      $cor_nivel = 'success';
elseif ($exercicio['nivel'] === 'Intermediário') $cor_nivel = 'warning';
elseif ($exercicio['nivel'] === 'Avançado')   $cor_nivel = 'danger';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($exercicio['nome']); ?> - Academia Corpo em Foco</title>
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
                    <li class="nav-item"><a class="nav-link" href="grupos.php?id=<?= $exercicio['grupo_id']; ?>">Grupos</a></li>
                    <li class="nav-item"><a class="nav-link" href="institucional.php">Informações</a></li>
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
    <div class="bg-primary text-white py-4 mb-4">
        <div class="container">
            <a href="grupos.php?id=<?= $exercicio['grupo_id']; ?>" class="text-white text-decoration-none mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Voltar para <?= htmlspecialchars($exercicio['grupo_nome']); ?>
            </a>
            <h1 class="fw-bold"><?= htmlspecialchars($exercicio['nome']); ?></h1>
            <span class="badge bg-<?= $cor_nivel; ?>"><?= $exercicio['nivel']; ?></span>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="container mb-5">
        <div class="row">

            <!-- Imagem + Instruções -->
            <div class="col-lg-8">
                <?php if ($exercicio['foto']) { ?>
                    <img src="admin/img/<?= htmlspecialchars($exercicio['foto']); ?>"
                         alt="<?= htmlspecialchars($exercicio['nome']); ?>"
                         class="img-fluid rounded mb-4 w-100 object-fit-cover"
                         style="max-height:400px">
                <?php } else { ?>
                    <div class="bg-secondary bg-opacity-10 rounded d-flex flex-column align-items-center justify-content-center mb-4 py-5">
                        <i class="bi bi-image fs-1 text-secondary"></i>
                        <p class="text-muted mt-2 mb-0">Imagem não disponível</p>
                    </div>
                <?php } ?>

                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><i class="bi bi-book text-primary"></i> Instruções de Execução</h4>
                        <p class="text-muted lh-lg mb-0">
                            <?= nl2br(htmlspecialchars($exercicio['descricao'])); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sidebar de informações -->
            <div class="col-lg-4">

                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="bi bi-info-circle text-primary"></i> Informações</h5>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-lightning-charge-fill fs-4 text-primary me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Grupo Muscular</span>
                                <span class="text-muted"><?= htmlspecialchars($exercicio['grupo_nome']); ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-bar-chart fs-4 text-primary me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Nível</span>
                                <span class="badge bg-<?= $cor_nivel; ?>"><?= $exercicio['nivel']; ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-repeat fs-4 text-primary me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Séries</span>
                                <span class="text-muted"><?= $exercicio['series']; ?> séries</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <i class="bi bi-hash fs-4 text-primary me-3"></i>
                            <div>
                                <span class="fw-semibold d-block">Repetições</span>
                                <span class="text-muted"><?= htmlspecialchars($exercicio['repeticoes']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="bi bi-lightbulb text-primary"></i> Dicas</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Mantenha a forma correta em todas as repetições</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Respire adequadamente durante o exercício</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Aumente a intensidade gradualmente</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Consulte um instrutor se tiver dúvidas</li>
                        </ul>
                    </div>
                </div>

                <a href="grupos.php?id=<?= $exercicio['grupo_id']; ?>" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-arrow-left"></i> Voltar aos Exercícios
                </a>
            </div>
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
