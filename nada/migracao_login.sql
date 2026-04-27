-- =====================================================
-- MIGRAÇÃO: Sistema de Login + Cadastro
-- Academia Corpo em Foco
-- Execute no seu banco: academia_corpo_em_foco
-- =====================================================

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `nome`       VARCHAR(100) NOT NULL COMMENT 'Nome completo do usuário',
  `usuario`    VARCHAR(50)  NOT NULL UNIQUE COMMENT 'Nome de login (único)',
  `senha`      VARCHAR(255) NOT NULL COMMENT 'Hash bcrypt da senha',
  `tipo`       ENUM('admin','aluno') NOT NULL DEFAULT 'aluno',
  `ativo`      TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=ativo, 0=bloqueado',
  `criado_em`  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- USUÁRIOS PADRÃO
-- Senha do admin : admin123
-- Senha do aluno : aluno123
-- TROQUE DEPOIS DO PRIMEIRO ACESSO!
-- =====================================================

INSERT INTO `usuarios` (`nome`, `usuario`, `senha`, `tipo`) VALUES
(
  'Administrador',
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'admin'
),
(
  'Aluno Padrão',
  'aluno',
  '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LPZsjzeQ9VC',
  'aluno'
);

-- =====================================================
-- COMO CADASTRAR UM ADMIN MANUALMENTE
-- (Alunos se cadastram pela tela de login)
-- =====================================================

-- 1. Gere o hash da senha no terminal ou em um arquivo PHP:
--    php -r "echo password_hash('SUA_SENHA', PASSWORD_DEFAULT);"

-- 2. Insira no banco:
-- INSERT INTO `usuarios` (nome, usuario, senha, tipo)
-- VALUES ('Nome do Admin', 'usuario_admin', 'HASH_GERADO', 'admin');

-- =====================================================
-- CONSULTAS ÚTEIS
-- =====================================================

-- Ver todos os usuários:
-- SELECT id, nome, usuario, tipo, ativo, criado_em FROM usuarios;

-- Bloquear um aluno (sem deletar):
-- UPDATE usuarios SET ativo = 0 WHERE usuario = 'nome_do_aluno';

-- Reativar:
-- UPDATE usuarios SET ativo = 1 WHERE usuario = 'nome_do_aluno';

-- Trocar senha de qualquer usuário (gere o hash antes):
-- UPDATE usuarios SET senha = 'NOVO_HASH' WHERE usuario = 'nome_do_usuario';
