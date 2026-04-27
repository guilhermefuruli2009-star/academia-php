-- =====================================================
-- SQL EXCLUSIVO PARA ADMINISTRADORES
-- Academia Corpo em Foco
-- Execute no banco: academia_corpo_em_foco
-- =====================================================

-- Garante que a tabela existe (caso ainda não tenha rodado
-- o arquivo migracao_login.sql completo)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id`        INT AUTO_INCREMENT PRIMARY KEY,
  `nome`      VARCHAR(100) NOT NULL,
  `usuario`   VARCHAR(50)  NOT NULL UNIQUE,
  `senha`     VARCHAR(255) NOT NULL,
  `tipo`      ENUM('admin','aluno') NOT NULL DEFAULT 'aluno',
  `ativo`     TINYINT(1) NOT NULL DEFAULT 1,
  `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERIR NOVO ADMINISTRADOR MANUALMENTE
-- Substitua os valores abaixo antes de executar
-- =====================================================

-- Passo 1: gere o hash da senha no terminal:
--   php -r "echo password_hash('SUA_SENHA_AQUI', PASSWORD_DEFAULT);"
--
-- Passo 2: cole o hash no campo `senha` abaixo e execute

INSERT INTO `usuarios` (`nome`, `usuario`, `senha`, `tipo`, `ativo`)
VALUES (
    'Nome do Administrador',          -- troque pelo nome real
    'usuario_admin',                  -- troque pelo login desejado
    '$2y$10$COLE_O_HASH_GERADO_AQUI', -- troque pelo hash gerado
    'admin',
    1
);

-- =====================================================
-- ADMINISTRADOR PADRÃO (senha: admin123)
-- Use apenas para testes. Troque a senha após o login!
-- =====================================================

-- INSERT INTO `usuarios` (`nome`, `usuario`, `senha`, `tipo`, `ativo`)
-- VALUES (
--     'Administrador',
--     'admin',
--     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
--     'admin',
--     1
-- );

-- =====================================================
-- CONSULTAR ADMINISTRADORES CADASTRADOS
-- =====================================================

SELECT id, nome, usuario, ativo, criado_em
FROM usuarios
WHERE tipo = 'admin'
ORDER BY criado_em DESC;

-- =====================================================
-- GERENCIAR ADMINISTRADORES
-- =====================================================

-- Bloquear um admin (sem deletar):
-- UPDATE usuarios SET ativo = 0 WHERE usuario = 'usuario_admin' AND tipo = 'admin';

-- Reativar:
-- UPDATE usuarios SET ativo = 1 WHERE usuario = 'usuario_admin' AND tipo = 'admin';

-- Trocar senha (gere o hash antes com php -r):
-- UPDATE usuarios SET senha = 'NOVO_HASH' WHERE usuario = 'usuario_admin' AND tipo = 'admin';

-- Remover permanentemente:
-- DELETE FROM usuarios WHERE usuario = 'usuario_admin' AND tipo = 'admin';
