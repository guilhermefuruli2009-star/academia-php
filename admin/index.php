<?php
require_once 'auth_admin.php'; require 'menu.php'?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Academia Corpo em Foco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Bem-vindo ao Painel Administrativo</h1>
                <p class="lead">Selecione uma opção no menu para gerenciar o conteúdo da Academia Corpo em Foco.</p>
                
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Avisos/Banners</h5>
                                <p class="card-text">Gerencie os avisos e banners motivacionais</p>
                                <a href="pgbanner.php" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Grupos Musculares</h5>
                                <p class="card-text">Gerencie os grupos de exercícios</p>
                                <a href="pggrupos.php" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Exercícios</h5>
                                <p class="card-text">Gerencie os exercícios disponíveis</p>
                                <a href="pgeexercicios.php" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Informações</h5>
                                <p class="card-text">Dados da academia</p>
                                <a href="pginstitucional.php" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
