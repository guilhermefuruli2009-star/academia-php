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
</head>
<body class="admin-body">

    <div class="container py-4">

        <div class="admin-page-header">
            <h1><i class="bi bi-activity me-2" style="color:var(--orange)"></i>Exercícios</h1>
            <p>Cadastre e gerencie todos os exercícios disponíveis</p>
        </div>

        <!-- BOTÃO CADASTRAR -->
        <button class="admin-btn-add" data-bs-toggle="modal" data-bs-target="#ModalCadastrar">
            <i class="bi bi-plus-circle-fill"></i> Adicionar Exercício
        </button>

        <!-- MODAL CADASTRAR -->
        <div class="modal fade admin-modal" id="ModalCadastrar">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="opeexercicios.php?acao=cadastrar" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus-circle me-2" style="color:var(--orange)"></i>Cadastro de Exercício</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Grupo Muscular</label>
                                    <select class="form-control" name="txt_grupo" required>
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
                                    <select class="form-control" name="txt_nivel" required>
                                        <option value="Iniciante">Iniciante</option>
                                        <option value="Intermediário">Intermediário</option>
                                        <option value="Avançado">Avançado</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nome do Exercício</label>
                                    <input type="text" class="form-control" name="txt_nome" placeholder="Ex: Supino Reto" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Descrição / Instruções</label>
                                    <textarea class="form-control" name="txt_descricao" placeholder="Descreva como executar o exercício..." rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Séries</label>
                                    <input type="number" class="form-control" name="txt_series" placeholder="Ex: 3" value="3" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Repetições</label>
                                    <input type="text" class="form-control" name="txt_repeticoes" placeholder="Ex: 12" value="12" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Foto do Exercício</label>
                                    <input type="file" class="form-control" name="file_foto" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">Cancelar</button>
                            <button type="submit" class="admin-btn-add" style="margin:0"><i class="bi bi-check-lg"></i> Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABELA -->
        <div class="admin-table-card">
            <table class="table">
                <thead>
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
                            $nivel_class = 'nivel-badge nivel-iniciante';
                            if ($linha['nivel'] === 'Intermediário') $nivel_class = 'nivel-badge nivel-intermediario';
                            elseif ($linha['nivel'] === 'Avançado')  $nivel_class = 'nivel-badge nivel-avancado';
                            ?>
                            <tr>
                                <td style="color:var(--text-muted)">#<?= $linha['id']; ?></td>
                                <td><strong><?= htmlspecialchars($linha['nome']); ?></strong></td>
                                <td><?= htmlspecialchars($linha['grupo_nome']); ?></td>
                                <td><span class="<?= $nivel_class ?>"><?= $linha['nivel']; ?></span></td>
                                <td><?= $linha['series']; ?>x<?= $linha['repeticoes']; ?></td>
                                <td>
                                    <?php if ($linha['foto']) { ?>
                                        <img src="img/<?= htmlspecialchars($linha['foto']); ?>" width="48" height="48" style="border-radius:8px;object-fit:cover;border:1px solid rgba(255,255,255,0.08)">
                                    <?php } else { ?>
                                        <span style="color:var(--text-muted);font-size:12px">—</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="admin-btn-edit" data-bs-toggle="modal" data-bs-target="#ModalEditar<?= $linha['id']; ?>">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                        <button class="admin-btn-delete" data-bs-toggle="modal" data-bs-target="#ModalExcluir<?= $linha['id']; ?>">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL EXCLUIR -->
                            <div class="modal fade admin-modal admin-modal-confirm" id="ModalExcluir<?= $linha['id']; ?>">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color:var(--red)"><i class="bi bi-trash me-2"></i>Excluir?</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="color:var(--text-secondary)">
                                            Tem certeza que deseja excluir <strong style="color:var(--text-primary)"><?= htmlspecialchars($linha['nome']); ?></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">Não</button>
                                            <a href="opeexercicios.php?acao=excluir&id=<?= $linha['id']; ?>" class="admin-btn-delete" style="text-decoration:none">
                                                <i class="bi bi-trash"></i> Excluir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL EDITAR -->
                            <div class="modal fade admin-modal" id="ModalEditar<?= $linha['id']; ?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="opeexercicios.php?acao=editar&id=<?= $linha['id']; ?>" method="post" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="bi bi-pencil me-2" style="color:var(--orange)"></i>Editar Exercício</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Grupo Muscular</label>
                                                        <select class="form-control" name="txt_grupo" required>
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
                                                        <select class="form-control" name="txt_nivel" required>
                                                            <option value="<?= $linha['nivel']; ?>" selected><?= $linha['nivel']; ?></option>
                                                            <option value="Iniciante">Iniciante</option>
                                                            <option value="Intermediário">Intermediário</option>
                                                            <option value="Avançado">Avançado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Nome do Exercício</label>
                                                        <input type="text" class="form-control" name="txt_nome" value="<?= htmlspecialchars($linha['nome']); ?>" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Descrição / Instruções</label>
                                                        <textarea class="form-control" name="txt_descricao" rows="3"><?= htmlspecialchars($linha['descricao']); ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Séries</label>
                                                        <input type="number" class="form-control" name="txt_series" value="<?= $linha['series']; ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Repetições</label>
                                                        <input type="text" class="form-control" name="txt_repeticoes" value="<?= $linha['repeticoes']; ?>" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Nova Foto (opcional)</label>
                                                        <?php if ($linha['foto']) { ?>
                                                            <div class="mb-2">
                                                                <img src="img/<?= htmlspecialchars($linha['foto']); ?>" width="80" style="border-radius:10px;border:1px solid rgba(255,255,255,0.08)">
                                                            </div>
                                                        <?php } ?>
                                                        <input type="file" class="form-control" name="file_foto" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">Cancelar</button>
                                                <button type="submit" class="admin-btn-add" style="margin:0"><i class="bi bi-check-lg"></i> Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } catch (Exception $e) {
                        echo '<tr><td colspan="7" style="color:var(--red);padding:20px">Erro ao carregar exercícios: ' . $e->getMessage() . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
