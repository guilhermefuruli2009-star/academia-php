<?php
require_once 'auth_admin.php';
require 'menu.php';
require 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Grupos Musculares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-3">

        <!-- BOTÃO CADASTRAR -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#ModalCadastrar">
            + Adicionar Grupo
        </button>

        <!-- MODAL CADASTRAR -->
        <div class="modal fade" id="ModalCadastrar">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="opgrupos.php?acao=cadastrar" method="post">

                        <div class="modal-header">
                            <h5 class="modal-title">Cadastro de Grupo Muscular</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="text" class="form-control mb-2" name="txt_nome" placeholder="Nome do Grupo" required>
                            <textarea class="form-control mb-2" name="txt_descricao" placeholder="Descrição" rows="3"></textarea>
                            <input type="text" class="form-control mb-2" name="txt_icone" placeholder="Ícone (ex: bi-lightning-charge-fill)" value="bi-lightning-charge-fill">
                            <select class="form-control" name="txt_cor" required>
                                <option value="">Selecione a cor do badge</option>
                                <option value="primary">Azul</option>
                                <option value="success">Verde</option>
                                <option value="danger">Vermelho</option>
                                <option value="warning">Amarelo</option>
                                <option value="info">Ciano</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- TABELA -->
        <table class="table table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Cor</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php
                try {
                    $lista = $db->query("SELECT * FROM grupos_musculares ORDER BY id ASC");

                    while ($linha = $lista->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                        <tr>
                            <td><?= $linha['id']; ?></td>
                            <td><strong><?= htmlspecialchars($linha['nome']); ?></strong></td>
                            <td><?= htmlspecialchars(substr($linha['descricao'], 0, 50)); ?></td>
                            <td><span class="badge bg-<?= $linha['cor']; ?>"><?= $linha['cor']; ?></span></td>
                            <td>
                                <!-- EDITAR -->
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#ModalEditar<?= $linha['id']; ?>">
                                    Editar
                                </button>

                                <!-- EXCLUIR -->
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#ModalExcluir<?= $linha['id']; ?>">
                                    Excluir
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL EXCLUIR -->
                        <div class="modal fade" id="ModalExcluir<?= $linha['id']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Deseja excluir?</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <strong><?= htmlspecialchars($linha['nome']); ?></strong>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Não</button>

                                        <a href="opgrupos.php?acao=excluir&id=<?= $linha['id']; ?>"
                                            class="btn btn-danger">
                                            Sim, excluir
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="ModalEditar<?= $linha['id']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="opgrupos.php?acao=editar&id=<?= $linha['id']; ?>" method="post">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Grupo</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="text" class="form-control mb-2" name="txt_nome"
                                                value="<?= htmlspecialchars($linha['nome']); ?>" required>

                                            <textarea class="form-control mb-2" name="txt_descricao" rows="3"><?= htmlspecialchars($linha['descricao']); ?></textarea>

                                            <input type="text" class="form-control mb-2" name="txt_icone"
                                                value="<?= htmlspecialchars($linha['icone']); ?>">

                                            <select class="form-control" name="txt_cor" required>
                                                <option value="<?= $linha['cor']; ?>" selected><?= $linha['cor']; ?></option>
                                                <option value="primary">Azul</option>
                                                <option value="success">Verde</option>
                                                <option value="danger">Vermelho</option>
                                                <option value="warning">Amarelo</option>
                                                <option value="info">Ciano</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <?php 
                    }
                } catch (Exception $e) {
                    echo '<tr><td colspan="5" class="text-danger">Erro ao carregar grupos: ' . $e->getMessage() . '</td></tr>';
                }
                ?>

            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
