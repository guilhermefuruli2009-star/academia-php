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
                    <li class="nav-item"><a class="nav-link active" href="#">Grupos</a></li>
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

    <!-- Header do Grupo -->
    <div class="bg-primary text-white py-5 mb-4">
        <div class="container">
            <a href="index.php" class="text-white text-decoration-none mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
            <h1 class="fw-bold"><?= htmlspecialchars($grupo['nome']); ?></h1>
            <p class="lead mb-0"><?= htmlspecialchars($grupo['descricao']); ?></p>
        </div>
    </div>

    <!-- Filtro por Nível -->
    <div class="container mb-4">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-muted"><i class="bi bi-funnel"></i> Filtrar por nível:</span>
            <a href="grupos.php?id=<?= $grupo_id; ?>" class="btn btn-sm btn-<?= $nivel_filtro === null ? 'primary' : 'outline-primary'; ?>">Todos</a>
            <a href="grupos.php?id=<?= $grupo_id; ?>&nivel=Iniciante" class="btn btn-sm btn-<?= $nivel_filtro === 'Iniciante' ? 'success' : 'outline-success'; ?>">Iniciante</a>
            <a href="grupos.php?id=<?= $grupo_id; ?>&nivel=Intermediário" class="btn btn-sm btn-<?= $nivel_filtro === 'Intermediário' ? 'warning' : 'outline-warning'; ?>">Intermediário</a>
            <a href="grupos.php?id=<?= $grupo_id; ?>&nivel=Avançado" class="btn btn-sm btn-<?= $nivel_filtro === 'Avançado' ? 'danger' : 'outline-danger'; ?>">Avançado</a>
        </div>
    </div>

    <!-- Lista de Exercícios -->
    <div class="container mb-5">
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
                        $id          = $ex['id'];
                        $nome        = htmlspecialchars($ex['nome']);
                        $nivel       = $ex['nivel'];
                        $series      = $ex['series'];
                        $repeticoes  = htmlspecialchars($ex['repeticoes']);
                        $foto        = htmlspecialchars($ex['foto']);

                        $cor_nivel = 'info';
                        if ($nivel === 'Iniciante')     $cor_nivel = 'success';
                        elseif ($nivel === 'Intermediário') $cor_nivel = 'warning';
                        elseif ($nivel === 'Avançado')  $cor_nivel = 'danger';

                        echo '<div class="col-md-6 col-lg-4">';
                        echo '<a href="detalhe.php?id=' . $id . '" class="text-decoration-none">';
                        echo '<div class="card h-100 shadow-sm position-relative">';

                        if ($foto) {
                            echo '<div class="ratio ratio-16x9">';
                            echo '<img src="admin/img/' . $foto . '" class="card-img-top object-fit-cover" alt="' . $nome . '">';
                            echo '</div>';
                        } else {
                            echo '<div class="ratio ratio-16x9 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center">';
                            echo '<i class="bi bi-image fs-1 text-secondary"></i>';
                            echo '</div>';
                        }

                        echo '<span class="badge bg-' . $cor_nivel . ' position-absolute top-0 end-0 m-2">' . $nivel . '</span>';

                        echo '<div class="card-body">';
                        echo '<h5 class="card-title fw-bold">' . $nome . '</h5>';
                        echo '<div class="d-flex justify-content-between align-items-center">';
                        echo '<small class="text-muted"><i class="bi bi-repeat"></i> ' . $series . 'x' . $repeticoes . '</small>';
                        echo '<span class="badge bg-primary">Detalhes</span>';
                        echo '</div></div></div></a></div>';
                    }
                } else {
                    echo '<div class="col-12"><div class="alert alert-info text-center"><i class="bi bi-info-circle"></i> Nenhum exercício encontrado para este filtro.</div></div>';
                }
            } catch (Exception $e) {
                echo '<div class="col-12"><div class="alert alert-danger">Erro: ' . $e->getMessage() . '</div></div>';
            }
            ?>
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
