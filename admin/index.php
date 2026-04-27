<?php require_once 'auth_admin.php'; require 'menu.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Academia Corpo em Foco</title>
</head>
<body class="admin-body">

    <div class="container py-5">

        <div class="admin-page-header">
            <h1><i class="bi bi-shield-lock-fill me-2" style="color:var(--orange)"></i>Painel Administrativo</h1>
            <p>Gerencie o conteúdo da Academia Corpo em Foco</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="pgbanner.php" class="admin-dashboard-card">
                    <div class="dash-icon"><i class="bi bi-megaphone-fill"></i></div>
                    <h5>Avisos / Banners</h5>
                    <p>Gerencie os avisos e banners motivacionais</p>
                    <span class="dash-btn">Acessar <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="pggrupos.php" class="admin-dashboard-card">
                    <div class="dash-icon"><i class="bi bi-grid-fill"></i></div>
                    <h5>Grupos Musculares</h5>
                    <p>Gerencie os grupos de exercícios</p>
                    <span class="dash-btn">Acessar <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="pgeexercicios.php" class="admin-dashboard-card">
                    <div class="dash-icon"><i class="bi bi-activity"></i></div>
                    <h5>Exercícios</h5>
                    <p>Gerencie os exercícios disponíveis</p>
                    <span class="dash-btn">Acessar <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="pginstitucional.php" class="admin-dashboard-card">
                    <div class="dash-icon"><i class="bi bi-info-circle-fill"></i></div>
                    <h5>Informações</h5>
                    <p>Dados institucionais da academia</p>
                    <span class="dash-btn">Acessar <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
