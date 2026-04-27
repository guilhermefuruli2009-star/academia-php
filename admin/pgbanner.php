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
    <title>Admin - Avisos / Banners</title>
</head>
<body class="admin-body">

    <div class="container py-4">

        <div class="admin-page-header">
            <h1><i class="bi bi-megaphone-fill me-2" style="color:var(--orange)"></i>Avisos / Banners</h1>
            <p>Gerencie os avisos e banners motivacionais exibidos na plataforma</p>
        </div>

        <!-- ALERTA DE FEEDBACK -->
        <div id="alerta" class="d-none" role="alert"
             style="padding:14px 20px;border-radius:12px;font-size:14px;font-weight:600;margin-bottom:20px;border:1px solid transparent;transition:all .3s ease"></div>

        <!-- BOTÃO CADASTRAR -->
        <button class="admin-btn-add" data-bs-toggle="modal" data-bs-target="#ModalCadastrar">
            <i class="bi bi-plus-circle-fill"></i> Adicionar Aviso
        </button>

        <!-- MODAL CADASTRAR -->
        <div class="modal fade admin-modal" id="ModalCadastrar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formCadastrar">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-megaphone me-2" style="color:var(--orange)"></i>Novo Aviso / Banner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Título do Aviso</label>
                                    <input type="text" class="form-control" name="txt_titulo" placeholder="Ex: Promoção de Verão" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subtítulo / Descrição</label>
                                    <textarea class="form-control" name="txt_subtitulo" placeholder="Descrição do aviso..." rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Badge</label>
                                    <input type="text" class="form-control" name="txt_badge" placeholder="Ex: Motivação" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Cor do Banner</label>
                                    <select class="form-control" name="txt_cor" required>
                                        <option value="">Selecione a cor</option>
                                        <option value="primary">🔵 Azul</option>
                                        <option value="success">🟢 Verde</option>
                                        <option value="danger">🔴 Vermelho</option>
                                        <option value="warning">🟡 Amarelo</option>
                                        <option value="info">🩵 Ciano</option>
                                        <option value="dark">⚫ Escuro</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Ordem de Exibição</label>
                                    <input type="number" class="form-control" name="txt_ordem" placeholder="Ex: 1" value="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal"
                                style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">
                                Cancelar
                            </button>
                            <button type="submit" class="admin-btn-add" style="margin:0">
                                <i class="bi bi-check-lg"></i> Cadastrar
                            </button>
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
                        echo '<tr><td colspan="6" style="color:var(--red);padding:20px">Erro: ' . $e->getMessage() . '</td></tr>';
                    }

                    function renderLinha($l) {
                        $id     = $l['id'];
                        $titulo = htmlspecialchars($l['titulo']);
                        $badge  = htmlspecialchars($l['badge']);
                        $sub    = htmlspecialchars($l['subtitulo'] ?? '');
                        $cor    = htmlspecialchars($l['cor']);
                        $ordem  = intval($l['ordem']);
                        $cor_map = [
                            'primary' => ['rgba(10,132,255,0.15)',  'var(--blue-light)',    'rgba(10,132,255,0.3)',   'Azul'],
                            'success' => ['rgba(48,209,88,0.15)',   'var(--green)',          'rgba(48,209,88,0.3)',    'Verde'],
                            'danger'  => ['rgba(255,69,58,0.15)',   'var(--red)',            'rgba(255,69,58,0.3)',    'Vermelho'],
                            'warning' => ['rgba(255,214,10,0.15)',  'var(--yellow)',         'rgba(255,214,10,0.3)',   'Amarelo'],
                            'info'    => ['rgba(100,210,255,0.15)', '#64D2FF',               'rgba(100,210,255,0.3)', 'Ciano'],
                            'dark'    => ['rgba(255,255,255,0.06)', 'var(--text-secondary)', 'rgba(255,255,255,0.15)','Escuro'],
                        ];
                        $c = $cor_map[$cor] ?? $cor_map['primary'];
                        return "
                        <tr id='linha-{$id}'>
                            <td style='color:var(--text-muted)'>#$id</td>
                            <td><strong>$titulo</strong></td>
                            <td>$badge</td>
                            <td><span class='nivel-badge' style='background:{$c[0]};color:{$c[1]};border:1px solid {$c[2]}'>{$c[3]}</span></td>
                            <td>$ordem</td>
                            <td>
                                <div class='d-flex gap-2'>
                                    <button class='admin-btn-edit' onclick='abrirEditar($id, \"$titulo\", \"$sub\", \"$badge\", \"$cor\", $ordem)'>
                                        <i class='bi bi-pencil'></i> Editar
                                    </button>
                                    <button class='admin-btn-delete' onclick='confirmarExcluir($id, \"$titulo\")'>
                                        <i class='bi bi-trash'></i> Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div class="modal fade admin-modal" id="ModalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditar">
                    <input type="hidden" name="id" id="editId">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil me-2" style="color:var(--orange)"></i>Editar Aviso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Título do Aviso</label>
                                <input type="text" class="form-control" name="txt_titulo" id="editTitulo" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Subtítulo / Descrição</label>
                                <textarea class="form-control" name="txt_subtitulo" id="editSubtitulo" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Badge</label>
                                <input type="text" class="form-control" name="txt_badge" id="editBadge" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cor do Banner</label>
                                <select class="form-control" name="txt_cor" id="editCor" required>
                                    <option value="primary">🔵 Azul</option>
                                    <option value="success">🟢 Verde</option>
                                    <option value="danger">🔴 Vermelho</option>
                                    <option value="warning">🟡 Amarelo</option>
                                    <option value="info">🩵 Ciano</option>
                                    <option value="dark">⚫ Escuro</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Ordem de Exibição</label>
                                <input type="number" class="form-control" name="txt_ordem" id="editOrdem" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">
                            Cancelar
                        </button>
                        <button type="submit" class="admin-btn-add" style="margin:0">
                            <i class="bi bi-check-lg"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EXCLUIR -->
    <div class="modal fade admin-modal admin-modal-confirm" id="ModalExcluir">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:var(--red)"><i class="bi bi-trash me-2"></i>Excluir?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="color:var(--text-secondary)">
                    Excluir o aviso <strong id="excluirNome" style="color:var(--text-primary)"></strong>?
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:var(--text-secondary)">
                        Não
                    </button>
                    <button class="admin-btn-delete" id="btnConfirmarExcluir" style="border:none;cursor:pointer">
                        <i class="bi bi-trash"></i> Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const modalCadastrar = new bootstrap.Modal(document.getElementById('ModalCadastrar'));
    const modalEditar    = new bootstrap.Modal(document.getElementById('ModalEditar'));
    const modalExcluir   = new bootstrap.Modal(document.getElementById('ModalExcluir'));

    function mostrarAlerta(tipo, msg) {
        const el = document.getElementById('alerta');
        const s = tipo === 'success'
            ? { bg:'rgba(48,209,88,0.12)', color:'var(--green)', border:'rgba(48,209,88,0.3)' }
            : { bg:'rgba(255,69,58,0.12)', color:'var(--red)',   border:'rgba(255,69,58,0.3)' };
        el.style.background  = s.bg;
        el.style.color       = s.color;
        el.style.borderColor = s.border;
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
        fetch('pgbanner.php?parcial=1').then(r => r.text()).then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const novo = doc.getElementById('tabelaAvisos');
            if (novo) document.getElementById('tabelaAvisos').innerHTML = novo.innerHTML;
        });
    }

    document.getElementById('formCadastrar').addEventListener('submit', async function(e) {
        e.preventDefault();
        const data = await enviarForm('opbanner.php?acao=cadastrar', new FormData(this));
        if (data.sucesso) { modalCadastrar.hide(); this.reset(); recarregarTabela(); mostrarAlerta('success', 'Aviso cadastrado com sucesso!'); }
        else mostrarAlerta('danger', 'Erro: ' + (data.msg || 'Falha ao cadastrar.'));
    });

    function abrirEditar(id, titulo, subtitulo, badge, cor, ordem) {
        document.getElementById('editId').value        = id;
        document.getElementById('editTitulo').value    = titulo;
        document.getElementById('editSubtitulo').value = subtitulo;
        document.getElementById('editBadge').value     = badge;
        document.getElementById('editCor').value       = cor;
        document.getElementById('editOrdem').value     = ordem;
        modalEditar.show();
    }

    document.getElementById('formEditar').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('editId').value;
        const data = await enviarForm('opbanner.php?acao=editar&id=' + id, new FormData(this));
        if (data.sucesso) { modalEditar.hide(); recarregarTabela(); mostrarAlerta('success', 'Aviso atualizado!'); }
        else mostrarAlerta('danger', 'Erro: ' + (data.msg || 'Falha ao editar.'));
    });

    let excluirId = null;
    function confirmarExcluir(id, nome) {
        excluirId = id;
        document.getElementById('excluirNome').textContent = nome;
        modalExcluir.show();
    }

    document.getElementById('btnConfirmarExcluir').addEventListener('click', async function() {
        if (!excluirId) return;
        const data = await (await fetch('opbanner.php?acao=excluir&id=' + excluirId)).json();
        if (data.sucesso) { modalExcluir.hide(); recarregarTabela(); mostrarAlerta('success', 'Aviso excluído!'); }
        else mostrarAlerta('danger', 'Erro: ' + (data.msg || 'Falha ao excluir.'));
        excluirId = null;
    });
    </script>

</body>
</html>
