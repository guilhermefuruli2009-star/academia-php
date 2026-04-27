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
    <title>Admin - Avisos/Banners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">

    <!-- ALERTA DE FEEDBACK -->
    <div id="alerta" class="alert d-none" role="alert"></div>

    <!-- BOTÃO CADASTRAR -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#ModalCadastrar">
        + Adicionar Aviso
    </button>

    <!-- MODAL CADASTRAR -->
    <div class="modal fade" id="ModalCadastrar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCadastrar">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastro de Aviso/Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control mb-2" name="txt_titulo" placeholder="Título do Aviso" required>
                        <textarea class="form-control mb-2" name="txt_subtitulo" placeholder="Subtítulo/Descrição" rows="2"></textarea>
                        <input type="text" class="form-control mb-2" name="txt_badge" placeholder="Badge (ex: Motivação)" required>
                        <select class="form-control mb-2" name="txt_cor" required>
                            <option value="">Selecione a cor</option>
                            <option value="primary">Azul</option>
                            <option value="success">Verde</option>
                            <option value="danger">Vermelho</option>
                            <option value="warning">Amarelo</option>
                            <option value="info">Ciano</option>
                            <option value="dark">Escuro</option>
                        </select>
                        <input type="number" class="form-control mb-2" name="txt_ordem" placeholder="Ordem de exibição" value="0" required>
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
                <th>Título</th>
                <th>Badge</th>
                <th>Cor</th>
                <th>Ordem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tabelaAvisos">
            <?php
            try {
                $lista = $db->query("SELECT * FROM avisos ORDER BY ordem ASC");
                while ($linha = $lista->fetch(PDO::FETCH_ASSOC)) {
                    echo renderLinha($linha);
                }
            } catch (Exception $e) {
                echo '<tr><td colspan="6" class="text-danger">Erro: ' . $e->getMessage() . '</td></tr>';
            }

            function renderLinha($l) {
                $id      = $l['id'];
                $titulo  = htmlspecialchars($l['titulo']);
                $badge   = htmlspecialchars($l['badge']);
                $sub     = htmlspecialchars($l['subtitulo'] ?? '');
                $cor     = htmlspecialchars($l['cor']);
                $ordem   = intval($l['ordem']);
                return "
                <tr id='linha-{$id}'>
                    <td>{$id}</td>
                    <td>{$titulo}</td>
                    <td>{$badge}</td>
                    <td><span class='badge bg-{$cor}'>{$cor}</span></td>
                    <td>{$ordem}</td>
                    <td>
                        <button class='btn btn-sm btn-primary'
                            onclick='abrirEditar({$id}, \"{$titulo}\", \"{$sub}\", \"{$badge}\", \"{$cor}\", {$ordem})'>
                            Editar
                        </button>
                        <button class='btn btn-sm btn-danger'
                            onclick='confirmarExcluir({$id}, \"{$titulo}\")'>
                            Excluir
                        </button>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="ModalEditar">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditar">
                <input type="hidden" name="id" id="editId">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" name="txt_titulo" id="editTitulo" required>
                    <textarea class="form-control mb-2" name="txt_subtitulo" id="editSubtitulo" rows="2"></textarea>
                    <input type="text" class="form-control mb-2" name="txt_badge" id="editBadge" required>
                    <select class="form-control mb-2" name="txt_cor" id="editCor" required>
                        <option value="primary">Azul</option>
                        <option value="success">Verde</option>
                        <option value="danger">Vermelho</option>
                        <option value="warning">Amarelo</option>
                        <option value="info">Ciano</option>
                        <option value="dark">Escuro</option>
                    </select>
                    <input type="number" class="form-control mb-2" name="txt_ordem" id="editOrdem" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EXCLUIR -->
<div class="modal fade" id="ModalExcluir">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deseja excluir?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Aviso: <strong id="excluirNome"></strong>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                <button class="btn btn-danger" id="btnConfirmarExcluir">Sim, excluir</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const modalCadastrar = new bootstrap.Modal(document.getElementById('ModalCadastrar'));
const modalEditar    = new bootstrap.Modal(document.getElementById('ModalEditar'));
const modalExcluir   = new bootstrap.Modal(document.getElementById('ModalExcluir'));

// ── Utilitários ──────────────────────────────────────────────
function mostrarAlerta(tipo, msg) {
    const el = document.getElementById('alerta');
    el.className = `alert alert-${tipo}`;
    el.textContent = msg;
    el.classList.remove('d-none');
    clearTimeout(el._timer);
    el._timer = setTimeout(() => el.classList.add('d-none'), 4000);
}

async function enviarForm(url, formData) {
    const r = await fetch(url, { method: 'POST', body: formData });
    return r.json();
}

function recarregarTabela() {
    // Recarrega apenas o tbody via fetch na própria página
    fetch('pgbanner.php?parcial=1')
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const novoTbody = doc.getElementById('tabelaAvisos');
            if (novoTbody) {
                document.getElementById('tabelaAvisos').innerHTML = novoTbody.innerHTML;
            }
        });
}

// ── Cadastrar ────────────────────────────────────────────────
document.getElementById('formCadastrar').addEventListener('submit', async function(e) {
    e.preventDefault();
    const data = await enviarForm('opbanner.php?acao=cadastrar', new FormData(this));
    if (data.sucesso) {
        modalCadastrar.hide();
        this.reset();
        recarregarTabela();
        mostrarAlerta('success', 'Aviso cadastrado com sucesso!');
    } else {
        mostrarAlerta('danger', 'Erro: ' + (data.msg || 'Falha ao cadastrar.'));
    }
});

// ── Editar ───────────────────────────────────────────────────
function abrirEditar(id, titulo, subtitulo, badge, cor, ordem) {
    document.getElementById('editId').value       = id;
    document.getElementById('editTitulo').value   = titulo;
    document.getElementById('editSubtitulo').value = subtitulo;
    document.getElementById('editBadge').value    = badge;
    document.getElementById('editCor').value      = cor;
    document.getElementById('editOrdem').value    = ordem;
    modalEditar.show();
}

document.getElementById('formEditar').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('editId').value;
    const data = await enviarForm('opbanner.php?acao=editar&id=' + id, new FormData(this));
    if (data.sucesso) {
        modalEditar.hide();
        recarregarTabela();
        mostrarAlerta('success', 'Aviso atualizado com sucesso!');
    } else {
        mostrarAlerta('danger', 'Erro: ' + (data.msg || 'Falha ao editar.'));
    }
});

// ── Excluir ──────────────────────────────────────────────────
let excluirId = null;

function confirmarExcluir(id, nome) {
    excluirId = id;
    document.getElementById('excluirNome').textContent = nome;
    modalExcluir.show();
}

document.getElementById('btnConfirmarExcluir').addEventListener('click', async function() {
    if (!excluirId) return;
    const r = await fetch('opbanner.php?acao=excluir&id=' + excluirId);
    const data = await r.json();
    if (data.sucesso) {
        modalExcluir.hide();
        recarregarTabela();
        mostrarAlerta('success', 'Aviso excluído com sucesso!');
    } else {
        mostrarAlerta('danger', 'Erro: ' + (data.msg || 'Falha ao excluir.'));
    }
    excluirId = null;
});
</script>

</body>
</html>
