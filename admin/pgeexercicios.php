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
    <title>Admin - Exercícios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-3">

        <!-- BOTÃO CADASTRAR -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#ModalCadastrar">
            + Adicionar Exercício
        </button>

        <!-- MODAL CADASTRAR -->
        <div class="modal fade" id="ModalCadastrar">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="opeexercicios.php?acao=cadastrar" method="post" enctype="multipart/form-data">

                        <div class="modal-header">
                            <h5 class="modal-title">Cadastro de Exercício</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Grupo Muscular</label>
                                    <select class="form-control mb-2" name="txt_grupo" required>
                                        <option value="">Selecione um grupo</option>
                                        <?php
                                        $grupos = $db->query("SELECT * FROM grupos_musculares ORDER BY nome");
                                        while ($g = $grupos->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $g['id'] . '">' . htmlspecialchars($g['nome']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nível</label>
                                    <select class="form-control mb-2" name="txt_nivel" required>
                                        <option value="Iniciante">Iniciante</option>
                                        <option value="Intermediário">Intermediário</option>
                                        <option value="Avançado">Avançado</option>
                                    </select>
                                </div>
                            </div>

                            <input type="text" class="form-control mb-2" name="txt_nome" placeholder="Nome do Exercício" required>
                            <textarea class="form-control mb-2" name="txt_descricao" placeholder="Descrição/Instruções" rows="3"></textarea>

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" class="form-control mb-2" name="txt_series" placeholder="Séries" value="3" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control mb-2" name="txt_repeticoes" placeholder="Repetições" value="12" required>
                                </div>
                            </div>

                            <label class="form-label">Foto do Exercício</label>
                            <input type="file" class="form-control" name="file_foto" accept="image/*" required>
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
                    <th>Grupo</th>
                    <th>Nível</th>
                    <th>Série/Rep</th>
                    <th>Foto</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php
                try {
                    $lista = $db->query("SELECT e.*, g.nome as grupo_nome FROM exercicios e 
                                        LEFT JOIN grupos_musculares g ON e.grupo_id = g.id 
                                        ORDER BY e.id DESC");

                    while ($linha = $lista->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                        <tr>
                            <td><?= $linha['id']; ?></td>
                            <td><strong><?= htmlspecialchars($linha['nome']); ?></strong></td>
                            <td><?= htmlspecialchars($linha['grupo_nome']); ?></td>
                            <td><span class="badge bg-info"><?= $linha['nivel']; ?></span></td>
                            <td><?= $linha['series']; ?>x<?= $linha['repeticoes']; ?></td>
                            <td>
                                <?php if ($linha['foto']) { ?>
                                    <img src="img/<?= htmlspecialchars($linha['foto']); ?>" width="50" class="rounded">
                                <?php } ?>
                            </td>
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

                                        <a href="opeexercicios.php?acao=excluir&id=<?= $linha['id']; ?>"
                                            class="btn btn-danger">
                                            Sim, excluir
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="ModalEditar<?= $linha['id']; ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="opeexercicios.php?acao=editar&id=<?= $linha['id']; ?>" method="post" enctype="multipart/form-data">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Exercício</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Grupo Muscular</label>
                                                    <select class="form-control mb-2" name="txt_grupo" required>
                                                        <option value="<?= $linha['grupo_id']; ?>" selected><?= htmlspecialchars($linha['grupo_nome']); ?></option>
                                                        <?php
                                                        $grupos = $db->query("SELECT * FROM grupos_musculares ORDER BY nome");
                                                        while ($g = $grupos->fetch(PDO::FETCH_ASSOC)) {
                                                            echo '<option value="' . $g['id'] . '">' . htmlspecialchars($g['nome']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Nível</label>
                                                    <select class="form-control mb-2" name="txt_nivel" required>
                                                        <option value="<?= $linha['nivel']; ?>" selected><?= $linha['nivel']; ?></option>
                                                        <option value="Iniciante">Iniciante</option>
                                                        <option value="Intermediário">Intermediário</option>
                                                        <option value="Avançado">Avançado</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="text" class="form-control mb-2" name="txt_nome"
                                                value="<?= htmlspecialchars($linha['nome']); ?>" required>

                                            <textarea class="form-control mb-2" name="txt_descricao" rows="3"><?= htmlspecialchars($linha['descricao']); ?></textarea>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control mb-2" name="txt_series"
                                                        value="<?= $linha['series']; ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control mb-2" name="txt_repeticoes"
                                                        value="<?= $linha['repeticoes']; ?>" required>
                                                </div>
                                            </div>

                                            <label class="form-label">Foto do Exercício</label>
                                            <?php if ($linha['foto']) { ?>
                                                <div class="mb-2">
                                                    <img src="img/<?= htmlspecialchars($linha['foto']); ?>" width="100" class="rounded">
                                                </div>
                                            <?php } ?>
                                            <input type="file" class="form-control" name="file_foto" accept="image/*">
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
                    echo '<tr><td colspan="7" class="text-danger">Erro ao carregar exercícios: ' . $e->getMessage() . '</td></tr>';
                }
                ?>

            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
