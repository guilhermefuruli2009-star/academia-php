<?php
session_start();

if (isset($_SESSION['usuario_tipo'])) {
    header($_SESSION['usuario_tipo'] === 'admin' ? 'Location: admin/index.php' : 'Location: index.php');
    exit;
}

require 'admin/config.php';

define('CODIGO_ADM', 'academia2024adm');

$erro    = '';
$sucesso = '';
$aba     = $_GET['aba'] ?? 'login';
$tipo    = $_GET['tipo'] ?? 'aluno';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'login') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = trim($_POST['senha']   ?? '');
    $tipo    = $_POST['tipo'] ?? 'aluno';

    if ($usuario === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = ? AND tipo = ? AND ativo = 1 LIMIT 1");
            $stmt->execute([$usuario, $tipo]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['usuario_id']   = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_tipo'] = $user['tipo'];
                header($user['tipo'] === 'admin' ? 'Location: admin/index.php' : 'Location: index.php');
                exit;
            } else {
                $erro = 'Usuário ou senha inválidos.';
            }
        } catch (Exception $e) {
            $erro = 'Erro interno. Tente novamente.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastro_aluno') {
    $aba      = 'cadastro';
    $nome     = trim($_POST['nome']          ?? '');
    $usuario  = trim($_POST['novo_usuario']  ?? '');
    $senha    = trim($_POST['nova_senha']    ?? '');
    $confirma = trim($_POST['confirma']      ?? '');

    if ($nome === '' || $usuario === '' || $senha === '' || $confirma === '') {
        $erro = 'Preencha todos os campos.';
    } elseif (strlen($usuario) < 3) {
        $erro = 'O usuário deve ter pelo menos 3 caracteres.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirma) {
        $erro = 'As senhas não coincidem.';
    } else {
        try {
            $check = $db->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
            $check->execute([$usuario]);
            if ($check->fetch()) {
                $erro = 'Este nome de usuário já está em uso.';
            } else {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $ins  = $db->prepare("INSERT INTO usuarios (nome, usuario, senha, tipo, ativo) VALUES (?, ?, ?, 'aluno', 1)");
                $ins->execute([$nome, $usuario, $hash]);
                $sucesso = 'Conta de aluno criada! Faça o login.';
                $aba  = 'login';
                $tipo = 'aluno';
            }
        } catch (Exception $e) {
            $erro = 'Erro ao cadastrar. Tente novamente.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastro_adm') {
    $aba      = 'cadastro_adm';
    $nome     = trim($_POST['nome']          ?? '');
    $usuario  = trim($_POST['novo_usuario']  ?? '');
    $senha    = trim($_POST['nova_senha']    ?? '');
    $confirma = trim($_POST['confirma']      ?? '');
    $codigo   = trim($_POST['codigo_adm']    ?? '');

    if ($nome === '' || $usuario === '' || $senha === '' || $confirma === '' || $codigo === '') {
        $erro = 'Preencha todos os campos.';
    } elseif ($codigo !== CODIGO_ADM) {
        $erro = 'Código de autorização inválido.';
    } elseif (strlen($usuario) < 3) {
        $erro = 'O usuário deve ter pelo menos 3 caracteres.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirma) {
        $erro = 'As senhas não coincidem.';
    } else {
        try {
            $check = $db->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
            $check->execute([$usuario]);
            if ($check->fetch()) {
                $erro = 'Este nome de usuário já está em uso.';
            } else {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $ins  = $db->prepare("INSERT INTO usuarios (nome, usuario, senha, tipo, ativo) VALUES (?, ?, ?, 'admin', 1)");
                $ins->execute([$nome, $usuario, $hash]);
                $sucesso = 'Conta de administrador criada! Faça o login.';
                $aba  = 'login';
                $tipo = 'admin';
            }
        } catch (Exception $e) {
            $erro = 'Erro ao cadastrar. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Academia Corpo em Foco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: radial-gradient(circle at center, var(--bg-card), var(--bg-black));
        }
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        .login-card {
            background: var(--bg-card);
            border-radius: 24px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .nav-pills .nav-link {
            color: var(--text-secondary);
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            padding: 10px;
        }
        .nav-pills .nav-link.active {
            background: var(--bg-input);
            color: var(--orange);
        }
        .type-selector {
            background: var(--bg-input);
            padding: 5px;
            border-radius: 14px;
            display: flex;
            margin-bottom: 30px;
        }
        .type-btn {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-secondary);
        }
        .type-btn.active {
            background: var(--bg-card);
            color: var(--text-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="login-container animate-fade">
    <div class="text-center mb-5">
        <div class="logo justify-content-center mb-2" style="font-size: 32px;">
            <i class="bi bi-lightning-charge-fill"></i> CORPO EM FOCO
        </div>
        <p class="text-secondary">Sua jornada começa aqui.</p>
    </div>

    <div class="login-card">
        <!-- Abas -->
        <ul class="nav nav-pills nav-fill mb-4">
            <li class="nav-item">
                <a class="nav-link <?= $aba === 'login' ? 'active' : '' ?>" href="?aba=login&tipo=<?= $tipo ?>">Entrar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $aba === 'cadastro' ? 'active' : '' ?>" href="?aba=cadastro">Aluno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $aba === 'cadastro_adm' ? 'active' : '' ?>" href="?aba=cadastro_adm">Admin</a>
            </li>
        </ul>

        <?php if ($erro): ?>
            <div class="alert bg-danger-subtle text-danger border-0 small mb-4 py-2 px-3 rounded-3">
                <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($sucesso): ?>
            <div class="alert bg-success-subtle text-success border-0 small mb-4 py-2 px-3 rounded-3">
                <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($sucesso) ?>
            </div>
        <?php endif; ?>

        <?php if ($aba === 'login'): ?>
            <div class="type-selector">
                <a href="?aba=login&tipo=aluno" class="type-btn <?= $tipo !== 'admin' ? 'active' : '' ?>">Aluno</a>
                <a href="?aba=login&tipo=admin" class="type-btn <?= $tipo === 'admin' ? 'active' : '' ?>">Admin</a>
            </div>

            <form method="POST">
                <input type="hidden" name="acao" value="login">
                <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
                
                <div class="form-group">
                    <label class="small text-secondary fw-bold mb-2 ms-1">USUÁRIO</label>
                    <input type="text" name="usuario" class="form-control" placeholder="Seu login" required autofocus>
                </div>
                
                <div class="form-group mb-4">
                    <label class="small text-secondary fw-bold mb-2 ms-1">SENHA</label>
                    <input type="password" name="senha" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3">Acessar Painel</button>
            </form>

        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="acao" value="<?= $aba === 'cadastro' ? 'cadastro_aluno' : 'cadastro_adm' ?>">
                
                <div class="form-group">
                    <label class="small text-secondary fw-bold mb-2 ms-1">NOME COMPLETO</label>
                    <input type="text" name="nome" class="form-control" placeholder="Como quer ser chamado?" required>
                </div>

                <div class="form-group">
                    <label class="small text-secondary fw-bold mb-2 ms-1">USUÁRIO</label>
                    <input type="text" name="novo_usuario" class="form-control" placeholder="Escolha um login" required>
                </div>

                <div class="form-group">
                    <label class="small text-secondary fw-bold mb-2 ms-1">SENHA</label>
                    <input type="password" name="nova_senha" class="form-control" placeholder="Mínimo 6 caracteres" required>
                </div>

                <div class="form-group <?= $aba === 'cadastro_adm' ? '' : 'mb-4' ?>">
                    <label class="small text-secondary fw-bold mb-2 ms-1">CONFIRMAR SENHA</label>
                    <input type="password" name="confirma" class="form-control" placeholder="Repita a senha" required>
                </div>

                <?php if ($aba === 'cadastro_adm'): ?>
                <div class="form-group mb-4">
                    <label class="small text-secondary fw-bold mb-2 ms-1">CÓDIGO DE AUTORIZAÇÃO</label>
                    <input type="password" name="codigo_adm" class="form-control" placeholder="Código secreto" required>
                </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary w-100 py-3">Criar Conta</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
