# SGA - Sistema de Gestão de Aprendizagem

Este projeto é um Sistema de Gestão de Aprendizagem desenvolvido em PHP com padrão MVC. Ele permite que professores criem cursos, adicionem materiais e gerenciem alunos, e que alunos se inscrevam em cursos e acessem o conteúdo.

## Configuração e Instalação

Siga os passos abaixo para configurar e rodar o projeto em seu ambiente local utilizando o XAMPP (ou similar):

### 1. Baixar o Projeto

Ao baixar ou clonar este repositório, **é obrigatório que a pasta raiz do projeto seja nomeada como `TrabalhoPHP`**.
Certifique-se de que a estrutura de pastas seja similar a:
```
C:\xampp\htdocs\TrabalhoPHP\
├── app\
├── config\
├── helpers\
├── public\
└── README.md
```

### 2. Acessar o Projeto

1.  Inicie os serviços Apache e MySQL no XAMPP.
2.  Abra seu navegador e acesse: `http://localhost/TrabalhoPHP/`

## Credenciais de Acesso (Professor)

Para testar o sistema como professor, você pode usar as seguintes credenciais (se já tiver um professor cadastrado com esses dados):

* **Email:** `prof@sga.com`
* **Senha:** `1234`

Se este usuário não existir, você pode criá-lo via registro e, em seguida, alterar manualmente o perfil para 'professor' no banco de dados (tabela `usuarios`).

## Funcionalidades Principais

* **Páginas Públicas:** Home, Sobre, Lista de Cursos.
* **Autenticação:** Login, Registro de Usuário, Recuperação de Senha.
* **Dashboard:** Visão geral dos cursos para professores (cursos criados) e alunos (cursos inscritos).
* **Cursos (Professor):** Criar, Editar, Excluir e Visualizar cursos. Gerenciar alunos e materiais.
* **Cursos (Aluno):** Entrar em turmas via código, ver materiais.
* **Materiais/Atividades:** Adicionar, Editar e Excluir materiais dentro de um curso. Atribuir atividades a alunos específicos.

## Estrutura do Projeto

* `app/controllers`: Contém a lógica de negócios e manipulação de requisições.
* `app/models`: Interage com o banco de dados, contendo a lógica para manipulação de dados.
* `app/view`: Contém os arquivos de interface do usuário (HTML/PHP).
* `config`: Arquivos de configuração, como a conexão com o banco de dados.
* `helpers`: Funções auxiliares, como CSRF token generation.
* `public`: O diretório acessível publicamente, contendo CSS, JavaScript e o `index.php` (ponto de entrada).

```