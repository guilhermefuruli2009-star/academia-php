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
</head>
<body class="admin-body">

    <div class="container py-4">

        <div class="admin-page-header">
            <h1><i class="bi bi-grid-fill me-2" style="color:var(--orange)"></i>Grupos Musculares</h1>
            <p>Cadastre e gerencie os grupos musculares disponíveis</p>
        </div>

        <!-- BOTÃO CADASTRAR -->
        <button class="admin-btn-add" data-bs-toggle="modal" data-bs-target="#ModalCadastrar">
            <i class="bi bi-plus-circle-fill"></i> Adicionar Grupo
        </button>

        <!-- MODAL CADASTRAR -->
        <div class="modal fade admin-modal" id="ModalCadastrar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="opgrupos.php?acao=cadastrar" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus-circle me-2" style="color:var(--orange)"></i>Novo Grupo Muscular</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Nome do Grupo</label>
                                    <input type="text" class="form-control" name="txt_nome" placeholder="Ex: Peito, Costas, Pernas..." required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Descrição</label>
                                    <textarea class="form-control" name="txt_descricao" placeholder="Descreva o grupo muscular..." rows="3"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Ícone Bootstrap</label>
                                    <input type="text" class="form-control" name="txt_icone" placeholder="Ex: bi-lightning-charge-fill" value="bi-lightning-charge-fill">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Cor do Badge</label>
                                    <select class="form-control" name="txt_cor" required>
                                        <option value="">Selecione uma cor</option>
                                        <option value="primary">Azul</option>
                                        <option value="success">Verde</option>
                                        <option value="danger">Vermelho</option>
                                        <option value="warning">Amarelo</option>
                                        <option value="info">Ciano</option>
                                    </select>
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
                            $cor_map = [
                                'primary' => ['bg:rgba(10,132,255,0.15)', 'color:var(--blue-light)', 'border:1px solid rgba(10,132,255,0.3)', 'Azul'],
                                'success' => ['bg:rgba(48,209,88,0.15)', 'color:var(--green)', 'border:1px solid rgba(48,209,88,0.3)', 'Verde'],
                                'danger'  => ['bg:rgba(255,69,58,0.15)', 'color:var(--red)', 'border:1px solid rgba(255,69,58,0.3)', 'Vermelho'],
                                'warning' => ['bg:rgba(255,214,10,0.15)', 'color:var(--yellow)', 'border:1px solid rgba(255,214,10,0.3)', 'Amarelo'],
                                'info'    => ['bg:rgba(100,210,255,0.15)', 'color:#64D2FF', 'border:1px solid rgba(100,210,255,0.3)', 'Ciano'],
                            ];
                            $c = $cor_map[$linha['cor']] ?? $cor_map['primary'];
                            ?>
                            <tr>
                                <td style="color:var(--text-muted)">#<?= $linha['id']; ?></td>
                                <td><strong><?= htmlspecialchars($linha['nome']); ?></strong></td>
                                <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars(substr($linha['descricao'], 0, 60)); ?><?= strlen($linha['descricao']) > 60 ? '…' : '' ?></td>
                                <td>
                                    <span class="nivel-badge" style="background:<?= str_replace('bg:', '', $c[0]) ?>;<?= $c[1] ?>;<?= $c[2] ?>">
                                        <?= $c[3] ?>
                                    </span>
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
                                            Excluir o grupo <strong style="color:var(--text-primary)"><?= htmlspecialchars($linha['nome']); ?></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">Não</button>
                                            <a href="opgrupos.php?acao=excluir&id=<?= $linha['id']; ?>" class="admin-btn-delete" style="text-decoration:none">
                                                <i class="bi bi-trash"></i> Excluir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL EDITAR -->
                            <div class="modal fade admin-modal" id="ModalEditar<?= $linha['id']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="opgrupos.php?acao=editar&id=<?= $linha['id']; ?>" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="bi bi-pencil me-2" style="color:var(--orange)"></i>Editar Grupo</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="form-label">Nome do Grupo</label>
                                                        <input type="text" class="form-control" name="txt_nome" value="<?= htmlspecialchars($linha['nome']); ?>" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Descrição</label>
                                                        <textarea class="form-control" name="txt_descricao" rows="3"><?= htmlspecialchars($linha['descricao']); ?></textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Ícone Bootstrap</label>
                                                        <input type="text" class="form-control" name="txt_icone" value="<?= htmlspecialchars($linha['icone']); ?>">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Cor do Badge</label>
                                                        <select class="form-control" name="txt_cor" required>
                                                            <option value="<?= $linha['cor']; ?>" selected><?= $linha['cor']; ?></option>
                                                            <option value="primary">Azul</option>
                                                            <option value="success">Verde</option>
                                                            <option value="danger">Vermelho</option>
                                                            <option value="warning">Amarelo</option>
                                                            <option value="info">Ciano</option>
                                                        </select>
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
                        echo '<tr><td colspan="5" style="color:var(--red);padding:20px">Erro ao carregar grupos: ' . $e->getMessage() . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
