<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-shield-lock-fill text-warning me-1"></i> Admin - Academia Corpo em Foco
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Gerenciar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pgbanner.php"><i class="bi bi-megaphone me-1"></i>Avisos/Banners</a></li>
                        <li><a class="dropdown-item" href="pggrupos.php"><i class="bi bi-grid me-1"></i>Grupos Musculares</a></li>
                        <li><a class="dropdown-item" href="pgeexercicios.php"><i class="bi bi-activity me-1"></i>Exercícios</a></li>
                        <li><a class="dropdown-item" href="pginstitucional.php"><i class="bi bi-info-circle me-1"></i>Informações Institucionais</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="bi bi-eye me-1"></i>Ver Site (Aluno)</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-warning" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-gear me-1"></i><?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Admin') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted small">
                            <i class="bi bi-shield-fill text-warning"></i> Administrador
                        </span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../index.php"><i class="bi bi-eye me-1"></i>Ver como Aluno</a></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
