<?php
require_once 'auth_aluno.php';
require 'admin/config.php';

$grupo_id    = $_GET['id']    ?? 0;
$nivel_filtro = $_GET['nivel'] ?? null;

try {
    $grupo_stmt = $db->prepare("SELECT * FROM grupos_musculares WHERE id = ?");
    $grupo_stmt->execute([$grupo_id]);
    $grupo = $grupo_stmt->fetch(PDO::FETCH_ASSOC);
    if (!$grupo) { header('Location: index.php'); exit; }
} catch (Exception $e) {
    header('Location: index.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($grupo['nome']); ?> - Academia Corpo em Foco</title>
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
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-grid me-1"></i>Grupos</a></li>
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
            <a href="index.php" class="ae-hero-back">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
            <h1><?= htmlspecialchars($grupo['nome']); ?></h1>
            <p class="lead"><?= htmlspecialchars($grupo['descricao']); ?></p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="container">
        <div class="ae-filter-bar">
            <span class="ae-filter-label"><i class="bi bi-funnel me-1"></i>Filtrar:</span>
            <a href="grupos.php?id=<?= $grupo_id; ?>" class="ae-filter-btn <?= $nivel_filtro === null ? 'active-all' : '' ?>">Todos</a>
            <a href="grupos.php?id=<?= $grupo_id; ?>&nivel=Iniciante" class="ae-filter-btn <?= $nivel_filtro === 'Iniciante' ? 'active-iniciante' : '' ?>">
                <i class="bi bi-circle-fill" style="font-size:8px;color:var(--green)"></i> Iniciante
            </a>
            <a href="grupos.php?id=<?= $grupo_id; ?>&nivel=Intermediário" class="ae-filter-btn <?= $nivel_filtro === 'Intermediário' ? 'active-intermediario' : '' ?>">
                <i class="bi bi-circle-fill" style="font-size:8px;color:var(--yellow)"></i> Intermediário
            </a>
            <a href="grupos.php?id=<?= $grupo_id; ?>&nivel=Avançado" class="ae-filter-btn <?= $nivel_filtro === 'Avançado' ? 'active-avancado' : '' ?>">
                <i class="bi bi-circle-fill" style="font-size:8px;color:var(--red)"></i> Avançado
            </a>
        </div>
    </div>

    <!-- Lista de Exercícios -->
    <div class="container mb-5 mt-4">
        <div class="row g-4">
            <?php
            try {
                $query  = "SELECT * FROM exercicios WHERE grupo_id = ?";
                $params = [$grupo_id];
                if ($nivel_filtro) { $query .= " AND nivel = ?"; $params[] = $nivel_filtro; }
                $query .= " ORDER BY id ASC";
                $stmt = $db->prepare($query);
                $stmt->execute($params);
                $exercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($exercicios) > 0) {
                    foreach ($exercicios as $ex) {
                        $id         = $ex['id'];
                        $nome       = htmlspecialchars($ex['nome']);
                        $nivel      = $ex['nivel'];
                        $series     = $ex['series'];
                        $repeticoes = htmlspecialchars($ex['repeticoes']);
                        $foto       = htmlspecialchars($ex['foto']);

                        $badge_class = 'ae-badge-iniciante';
                        if ($nivel === 'Intermediário') $badge_class = 'ae-badge-intermediario';
                        elseif ($nivel === 'Avançado')  $badge_class = 'ae-badge-avancado';

                        echo '<div class="col-md-6 col-lg-4">';
                        echo '<a href="detalhe.php?id=' . $id . '" class="ae-exercise-card">';
                        echo '<div class="img-wrapper">';
                        if ($foto) {
                            echo '<img src="admin/img/' . $foto . '" alt="' . $nome . '">';
                        } else {
                            echo '</div><div class="img-placeholder"><i class="bi bi-image"></i></div><div style="display:none">';
                        }
                        echo '</div>';
                        echo '<span class="ae-badge ' . $badge_class . '">' . $nivel . '</span>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $nome . '</h5>';
                        echo '<div class="card-meta">';
                        echo '<span class="series-info"><i class="bi bi-repeat"></i> ' . $series . 'x' . $repeticoes . '</span>';
                        echo '<span class="ae-badge-ver">Ver mais <i class="bi bi-arrow-right"></i></span>';
                        echo '</div></div></a></div>';
                    }
                } else {
                    echo '<div class="col-12"><div class="ae-empty">';
                    echo '<i class="bi bi-search" style="font-size:40px;color:var(--text-muted);display:block;margin-bottom:12px"></i>';
                    echo '<p style="color:var(--text-muted);margin:0">Nenhum exercício encontrado para este filtro.</p>';
                    echo '</div></div>';
                }
            } catch (Exception $e) {
                echo '<div class="col-12"><p style="color:var(--red)">Erro: ' . $e->getMessage() . '</p></div>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="ae-footer">
        <p>&copy; 2024 Academia Corpo em Foco. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
