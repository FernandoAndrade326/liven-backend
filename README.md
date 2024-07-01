<div style="margin: 0 auto"><h1 style="text-align:center">API Rest PHP - Liven</h1></center></div>
<hr>
<p><b>API desenvolvida em PHP com funcionalidades CRUD e autenticação JWT.</b></p>
<h3>Tecnologias</h3>

<h3>Introdução</h3>
Bem-vindo à documentação da nossa API em PHP! Esta API foi desenvolvida para fornecer um conjunto robusto de funcionalidades para gerenciamento de usuários e endereços. Nossa API utiliza autenticação JWT para garantir a segurança das operações.

<h3>Pré-requisitos</h3>
Antes de começar, certifique-se de ter os seguintes requisitos instalados e configurados:
- **PHP 8.0+**
- **MySQL 5.7+**
- **Composer** (para gerenciamento de dependências)
- Servidor web (Apache, Nginx, etc.) - para finalidade de testes locais utilizamos o xampp.

<h3>Instalação</h3>
1. Clone o repositório:
   ```sh
   git clone https://github.com/seu-usuario/nome-do-repositorio.git
   ```
2. Navegue até o diretório do projeto:
   ```sh
   cd nome-do-repositorio
   ```
3. Instale as dependências:
   ```sh
   composer install
   ```
4. Configure seu banco de dados no arquivo `.env`.

5. Execute as migrações:
   ```sh
   php artisan migrate
   ```

<h3> Autenticação</h3>
A API utiliza JWT para autenticação. Para acessar os endpoints protegidos, você precisará incluir um token JWT no cabeçalho das suas requisições.

- **Obter Token JWT:**
  - Endpoint: `POST /api/auth/login`
  - Corpo da requisição (JSON):
    ```json
    {
      "email": "usuario@example.com",
      "password": "suaSenha"
    }
    ```
  - Resposta (JSON):
    ```json
    {
      "access_token": "seuTokenJWT"
    }
    ```

<h3> Endpoints da API</h3>

<h5> Usuários </h5>

<h5> `GET /api/users`</h5>
- **Descrição:** Retorna uma lista de todos os usuários.
- **Parâmetros de consulta:** Nenhum.
- **Exemplo de resposta (JSON):**
  ```json
  [
    {
      "id": 1,
      "name": "João Silva",
      "email": "joao.silva@example.com"
    },
    ...
  ]
  ```

<h5> `GET /api/users/{id}`</h5>
- **Descrição:** Retorna os detalhes de um usuário específico.
- **Parâmetros de caminho:**
  - `id` (inteiro): ID do usuário.
- **Exemplo de resposta (JSON):**
  ```json
  {
    "id": 1,
    "name": "João Silva",
    "email": "joao.silva@example.com"
  }
  ```

<h5> `POST /api/users` </h5>
- **Descrição:** Cria um novo usuário.
- **Corpo da requisição (JSON):**
  ```json
  {
    "name": "Maria Oliveira",
    "email": "maria.oliveira@example.com",
    "password": "suaSenha"
  }
  ```
- **Exemplo de resposta (JSON):**
  ```json
  {
    "id": 2,
    "name": "Maria Oliveira",
    "email": "maria.oliveira@example.com"
  }
  ```

</h4>Endereços</h4>

<h5> `GET /api/addresses`</h5>
- **Descrição:** Retorna uma lista de todos os endereços.
- **Parâmetros de consulta:** Nenhum.
- **Exemplo de resposta (JSON):**
  ```json
  [
    {
      "id": 1,
      "user_id": 1,
      "country": "Brasil",
      "state": "SP",
      "city": "São Paulo",
      "street": "Rua ABC",
      "complement": ""
    },
    ...
  ]
  ```

<h5> `GET /api/addresses/{id}`</h5>
- **Descrição:** Retorna os detalhes de um endereço específico.
- **Parâmetros de caminho:**
  - `id` (inteiro): ID do endereço.
- **Exemplo de resposta (JSON):**
  ```json
  {
    "id": 1,
    "user_id": 1,
    "country": "Brasil",
    "state": "SP",
    "city": "São Paulo",
    "street": "Rua ABC",
    "complement": ""
  }
  ```

#### `POST /api/addresses`
- **Descrição:** Cria um novo endereço.
- **Corpo da requisição (JSON):**
  ```json
  {
    "user_id": 1,
    "country": "Brasil",
    "state": "SP",
    "city": "São Paulo",
    "street": "Rua ABC",
    "complement": ""
  }
  ```
- **Exemplo de resposta (JSON):**
  ```json
  {
    "id": 2,
    "user_id": 1,
    "country": "Brasil",
    "state": "SP",
    "city": "São Paulo",
    "street": "Rua ABC",
    "complement": ""
  }
  ```

## Exemplos de Uso
### Requisição com `curl`:
```sh
curl -X GET "https://seu-dominio.com/api/users" -H "Authorization: Bearer seuTokenJWT"
```

<h5>Requisição com Postman:</h5>
1. Selecione o método HTTP e insira a URL.
2. Vá para a aba "Headers" e adicione:
   ```
   Key: Authorization
   Value: Bearer seuTokenJWT
   ```
3. Clique em "Send".

## Considerações de Segurança
- Valide todas as entradas do usuário para evitar injeções de SQL e outras vulnerabilidades.
- Use HTTPS para todas as requisições para proteger os dados em trânsito.
- Expire tokens JWT regularmente e implemente um sistema de refresh tokens.

<h5>Ferramentas Recomendadas</h5>
- <b>Postman</b>: Para testar os endpoints e interagir com o backend.


<h5> Histórico de Versões</h5>
- <b>v1.0.0</b> - Lançamento inicial da API.

## Referências
- [Documentação do PHP](https://www.php.net/docs.php)
- [Documentação do MySQL](https://dev.mysql.com/doc/)
