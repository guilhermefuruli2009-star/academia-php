<?php
require_once 'auth_aluno.php';
require 'admin/config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Corpo em Foco - Painel de Treinos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .hero-section {
            padding: 120px 0 60px;
            background: radial-gradient(circle at top right, var(--orange-subtle), transparent);
        }
        .carousel-item {
            border-radius: var(--border-radius);
            overflow: hidden;
            background: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .carousel-content {
            min-height: 350px;
            display: flex;
            flex-column: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
        }
        .group-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin: 0 auto 20px;
            font-size: 28px;
            background: rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }
        .card:hover .group-icon {
            background: var(--orange);
            color: white !important;
            transform: scale(1.1) rotate(5deg);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-content">
            <a class="logo" href="index.php">
                <i class="bi bi-lightning-charge-fill"></i> CORPO EM FOCO
            </a>
            
            <div class="d-flex align-items-center gap-4">
                <div class="d-none d-md-flex gap-4">
                    <a href="index.php" class="fw-medium">Home</a>
                    <a href="#grupos" class="fw-medium text-secondary">Grupos</a>
                    <a href="institucional.php" class="fw-medium text-secondary">Sobre</a>
                </div>
                
                <div class="dropdown">
                    <a href="#" class="btn btn-outline py-2 px-3" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i><?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark bg-card border-0 shadow-lg mt-2">
                        <li><span class="dropdown-item-text text-secondary small">
                            <i class="bi bi-<?= $_SESSION['usuario_tipo'] === 'admin' ? 'shield-fill text-warning' : 'person-fill text-primary' ?> me-1"></i>
                            <?= $_SESSION['usuario_tipo'] === 'admin' ? 'Administrador' : 'Aluno' ?>
                        </span></li>
                        <li><hr class="dropdown-divider opacity-10"></li>
                        <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                        <li><a class="dropdown-item" href="admin/index.php"><i class="bi bi-shield-lock-fill me-2 text-warning"></i>Painel Admin</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item text-danger" href="admin/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section animate-fade">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-3">Seu Treino, <span class="text-orange">Sua Evolução</span></h1>
            <p class="text-secondary fs-5 mx-auto" style="max-width: 600px;">
                Acesse seu programa de treinos personalizado com a melhor experiência visual e técnica.
            </p>
        </div>
    </section>

    <!-- Banner Carousel -->
    <div class="container mb-5">
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                try {
                    $banners = $db->query("SELECT * FROM avisos WHERE ativo = 1 ORDER BY ordem ASC")->fetchAll(PDO::FETCH_ASSOC);
                    if (count($banners) > 0) {
                        foreach ($banners as $index => $banner) {
                            $active = $index === 0 ? 'active' : '';
                            echo '<div class="carousel-item ' . $active . '">';
                            echo '<div class="carousel-content">';
                            echo '<span class="badge bg-dark border border-secondary text-white mb-3">' . htmlspecialchars($banner['badge']) . '</span>';
                            echo '<h2 class="display-5 fw-bold mb-3">' . htmlspecialchars($banner['titulo']) . '</h2>';
                            echo '<p class="text-secondary fs-5 mb-0">' . htmlspecialchars($banner['subtitulo']) . '</p>';
                            echo '</div></div>';
                        }
                    } else {
                        echo '<div class="carousel-item active">';
                        echo '<div class="carousel-content">';
                        echo '<span class="badge bg-dark border border-secondary text-white mb-3">Destaque</span>';
                        echo '<h2 class="display-5 fw-bold mb-3">Foco no Objetivo</h2>';
                        echo '<p class="text-secondary fs-5 mb-0">Explore os grupos musculares abaixo para começar.</p>';
                        echo '</div></div>';
                    }
                } catch (Exception $e) {}
                ?>
            </div>
            <div class="carousel-indicators" style="bottom: -40px;">
                <?php for($i=0; $i<count($banners); $i++): ?>
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i==0?'active':'' ?>" aria-current="true"></button>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Grupos Musculares -->
    <section class="container py-5" id="grupos">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="display-6 fw-bold mb-0">Grupos Musculares</h2>
                <p class="text-secondary mb-0">Selecione uma categoria para ver os exercícios</p>
            </div>
        </div>

        <div class="row g-4">
            <?php
            try {
                $grupos = $db->query("SELECT * FROM grupos_musculares ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($grupos as $grupo) {
                    $cor  = htmlspecialchars($grupo['cor']);
                    $nome = htmlspecialchars($grupo['nome']);
                    $desc = htmlspecialchars($grupo['descricao']);
                    $icone = htmlspecialchars($grupo['icone'] ?: 'bi-lightning-charge-fill');
                    $id   = $grupo['id'];

                    echo '<div class="col-md-6 col-lg-4 animate-fade">';
                    echo '<a href="grupos.php?id=' . $id . '" class="card h-100">';
                    echo '<div class="card-body text-center py-5">';
                    echo '<div class="group-icon text-' . $cor . '"><i class="bi ' . $icone . '"></i></div>';
                    echo '<h3 class="h4 fw-bold mb-3">' . $nome . '</h3>';
                    echo '<p class="text-secondary small mb-4">' . $desc . '</p>';
                    echo '<span class="btn btn-outline btn-sm px-4">Explorar</span>';
                    echo '</div></a></div>';
                }
            } catch (Exception $e) {
                echo '<div class="col-12"><div class="card bg-danger-subtle text-danger p-4">Erro ao carregar grupos.</div></div>';
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 mt-5 border-top border-secondary border-opacity-10">
        <div class="container text-center">
            <div class="logo mb-4 justify-content-center">
                <i class="bi bi-lightning-charge-fill"></i> CORPO EM FOCO
            </div>
            <p class="text-muted small mb-0">&copy; 2024 Academia Corpo em Foco. Crafted with Apple-energy aesthetic.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
