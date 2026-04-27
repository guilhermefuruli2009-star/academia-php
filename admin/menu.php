<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="../css/style.css">

<nav class="navbar navbar-expand-lg admin-navbar">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-shield-lock-fill"></i> ADMIN PANEL
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php"><i class="bi bi-house me-1"></i>Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-grid me-1"></i>Gerenciar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="pgbanner.php"><i class="bi bi-megaphone"></i>Avisos / Banners</a></li>
                        <li><a class="dropdown-item" href="pggrupos.php"><i class="bi bi-grid"></i>Grupos Musculares</a></li>
                        <li><a class="dropdown-item" href="pgeexercicios.php"><i class="bi bi-activity"></i>Exercícios</a></li>
                        <li><a class="dropdown-item" href="pginstitucional.php"><i class="bi bi-info-circle"></i>Informações Institucionais</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="bi bi-eye me-1"></i>Ver como Aluno</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle admin-user" href="#" data-bs-toggle="dropdown"
                       style="background:rgba(255,107,0,0.1);border:1px solid rgba(255,107,0,0.25);border-radius:20px;padding:7px 16px!important">
                        <i class="bi bi-person-gear me-1"></i><?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Admin') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text" style="color:var(--text-muted);font-size:12px;padding:6px 12px;">
                                <i class="bi bi-shield-fill me-1" style="color:var(--orange)"></i> Administrador
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../index.php"><i class="bi bi-eye"></i>Ver como Aluno</a></li>
                        <li><a class="dropdown-item" href="logout.php" style="color:var(--red)!important"><i class="bi bi-box-arrow-right"></i>Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
