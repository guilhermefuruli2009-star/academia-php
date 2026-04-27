# Academia Corpo em Foco - Sistema de Painel de Treinos

Um sistema completo de gerenciamento de exercícios e treinos para academias, desenvolvido em PHP com Bootstrap 5.

## 📋 Funcionalidades

### Painel Público (Alunos)
- ✅ Página inicial com banner rotativo de avisos motivacionais
- ✅ Listagem de 5 grupos musculares (Peito, Costas, Pernas, Braços, Cardio)
- ✅ Catálogo de exercícios com filtro por nível (Iniciante, Intermediário, Avançado)
- ✅ Página de detalhe do exercício com imagem ampliada e instruções
- ✅ Informações institucionais (endereço, horários, WhatsApp, equipamentos)

### Painel Administrativo (Protegido)
- ✅ Gerenciamento de avisos/banners
- ✅ Gerenciamento de grupos musculares
- ✅ Gerenciamento de exercícios (CRUD completo)
- ✅ Gerenciamento de informações institucionais
- ✅ Upload de fotos para exercícios

## 🚀 Instalação

### Requisitos
- PHP 7.4+
- MySQL 5.7+
- Servidor web (Apache, Nginx, etc)

### Passos

1. **Clonar ou baixar o projeto**
   ```bash
   cd /var/www/html
   # ou seu diretório web
   ```

2. **Criar o banco de dados**
   - Abra seu gerenciador MySQL (phpMyAdmin, MySQL Workbench, etc)
   - Importe o arquivo `database.sql`
   - Ou execute manualmente:
   ```sql
   mysql -u root -p < database.sql
   ```

3. **Configurar a conexão**
   - Edite o arquivo `admin/config.php`
   - Atualize as credenciais do banco de dados:
   ```php
   $dbname = 'academia_corpo_em_foco';
   $host = 'localhost';
   $dbuser = 'seu_usuario';
   $dbpass = 'sua_senha';
   ```

4. **Criar diretório de uploads**
   ```bash
   mkdir -p admin/img
   chmod 755 admin/img
   ```

5. **Acessar a aplicação**
   - Página pública: `http://localhost/academia-php/`
   - Painel admin: `http://localhost/academia-php/admin/`

## 📁 Estrutura de Arquivos

```
academia-php/
├── index.php                 # Página inicial pública
├── grupos.php               # Listagem de exercícios por grupo
├── detalhe.php              # Detalhe do exercício
├── institucional.php        # Informações da academia
├── database.sql             # Script de criação do banco
├── admin/
│   ├── index.php            # Dashboard do admin
│   ├── config.php           # Configuração de banco de dados
│   ├── menu.php             # Menu de navegação
│   ├── pgbanner.php         # Gerenciar avisos
│   ├── opbanner.php         # Operações de avisos
│   ├── pggrupos.php         # Gerenciar grupos
│   ├── opgrupos.php         # Operações de grupos
│   ├── pgeexercicios.php    # Gerenciar exercícios
│   ├── opeexercicios.php    # Operações de exercícios
│   ├── pginstitucional.php  # Gerenciar informações
│   ├── opinstitucional.php  # Operações de informações
│   └── img/                 # Diretório de fotos dos exercícios
└── README.md                # Este arquivo
```

## 🎯 Grupos Musculares Padrão

O sistema vem com 5 grupos musculares pré-configurados:

1. **Peito** - Exercícios para fortalecer o peitoral
2. **Costas** - Exercícios para desenvolver as costas
3. **Pernas** - Exercícios para fortalecer as pernas
4. **Braços** - Exercícios para desenvolver braços e bíceps
5. **Cardio** - Exercícios aeróbicos e de resistência

## 📊 Níveis de Dificuldade

Todos os exercícios são classificados em 3 níveis:

- **Iniciante** - Para quem está começando
- **Intermediário** - Para quem já tem experiência
- **Avançado** - Para atletas experientes

## 🎨 Design

- Interface responsiva e mobile-first
- Bootstrap 5 para componentes e layout
- Bootstrap Icons para ícones
- Design elegante e sofisticado
- Paleta de cores moderna

## 🔒 Segurança

- Validação de entrada com `htmlspecialchars()`
- Prepared statements para prevenir SQL injection
- Tratamento de exceções
- Upload seguro de arquivos

## 📝 Notas Importantes

1. **Fotos de Exercícios**: As fotos são obrigatórias e devem ser enviadas em formato de imagem (JPG, PNG, etc)
2. **Backup**: Faça backup regular do banco de dados
3. **Permissões**: Certifique-se de que o diretório `admin/img/` tem permissão de escrita
4. **Horários**: Os horários de funcionamento podem incluir domingo como fechado (deixe os campos vazios)

## 🛠️ Manutenção

### Adicionar novo exercício
1. Acesse: `http://localhost/academia-php/admin/pgeexercicios.php`
2. Clique em "+ Adicionar Exercício"
3. Preencha os dados e faça upload da foto

### Editar avisos motivacionais
1. Acesse: `http://localhost/academia-php/admin/pgbanner.php`
2. Clique em "Editar" no aviso desejado
3. Atualize as informações

### Atualizar informações da academia
1. Acesse: `http://localhost/academia-php/admin/pginstitucional.php`
2. Preencha ou atualize os dados
3. Clique em "Salvar Informações"

## 📞 Suporte

Para dúvidas ou problemas, verifique:
- Se o banco de dados foi criado corretamente
- Se as credenciais em `admin/config.php` estão corretas
- Se o diretório `admin/img/` tem permissão de escrita
- Se o PHP está com extensão MySQLi habilitada

## 📄 Licença

Este projeto é fornecido como está para uso em academias.

---

**Desenvolvido com ❤️ para Academia Corpo em Foco**
