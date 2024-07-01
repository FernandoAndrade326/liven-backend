<div style="margin: 0 auto"><h1 style="text-align:center">API Rest PHP - Liven</h1></center></div>
<hr>
<p><b>API desenvolvida em PHP com funcionalidades CRUD e autenticação JWT.</b></p>
<h3>Tecnologias</h3>

<h3>Introdução</h3>
API desenvolvida para fornecer um conjunto robusto de funcionalidades para gerenciamento de usuários e endereços. Essa API utiliza autenticação JWT para garantir a segurança das operações e gerenciar os níveis de permissão do usuário para com relação às informações pertinentes a ele.

<h3>Pré-requisitos</h3>
Antes de começar, certifique-se de ter os seguintes requisitos instalados e configurados:
- <b>PHP 8.0+</b>
- <b>MySQL 5.7+</b>
- <b>Composer</b> (para gerenciamento de dependências)
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

- <b>Obter Token JWT:</b>
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
- <b>Descrição:</b> Retorna uma lista de todos os usuários.
- <b>Parâmetros de consulta:</b> Nenhum.
- <b>Exemplo de resposta (JSON):</b>
  ```json
  [
    {
      "id": 1,
      "name": "RenataLiven",
      "email": "renata@liven.tech"
    },
    ...
  ]
  ```

<h5> `GET /api/users/{id}`</h5>
- <b>Descrição:</b> Retorna os detalhes de um usuário específico.
- <b>Parâmetros de caminho:</b>
  - `id` (inteiro): ID do usuário.
- <b>Exemplo de resposta (JSON):</b>
  ```json
  {
    "id": 1,
    "name": "RenataLiven",
    "email": "renata@liven.tech"
  }
  ```

<h5> `POST /api/users` </h5>
- <b>Descrição:</b> Cria um novo usuário.
- <b>Corpo da requisição (JSON):</b>
  ```json
  {
    "name": "Fernando Andrade",
    "email": "fernandoteste@gmail.com",
    "password": "suaSenha"
  }
  ```
- <b>Exemplo de resposta (JSON):</b>
  ```json
  {
    "id": 2,
    "name": "Fernando Andrade",
    "email": "fernandoteste@gmail.com"
  }
  ```

</h4>Endereços</h4>

<h5> `GET /api/addresses`</h5>
- <b>Descrição:</b> Retorna uma lista de todos os endereços.
- <b>Parâmetros de consulta:</b> Nenhum.
- <b>Exemplo de resposta (JSON):</b>
  ```json
  [
    {
      "id": 1,
      "user_id": 1,
      "country": "BR",
      "state": "SP",
      "city": "Campinas",
      "street": "Rua Anhanguera",
      "complement": ""
    },
    ...
  ]
  ```

<h5> `GET /api/addresses/{id}`</h5>
- <b>Descrição:</b> Retorna os detalhes de um endereço específico.
- <b>Parâmetros de caminho:</b>
  - `id` (inteiro): ID do endereço.
- <b>Exemplo de resposta (JSON):</b>
  ```json
  {
    "id": 1,
    "user_id": 1,
    "country": "BR",
    "state": "SP",
    "city": "Campinas",
    "street": "Rua Anhanguera",
    "complement": ""
  }
  ```

<h5>`POST /api/addresses` </h5>
- <b>Descrição:</b> Cria um novo endereço.
- <b>Corpo da requisição (JSON):</b>
  ```json
  {
    "user_id": 1,
    "country": "BR",
    "state": "SP",
    "city": "Campinas",
    "street": "Rua Anhanguera",
    "complement": ""
  }
  ```
- <b>Exemplo de resposta (JSON):</b>
  ```json
  {
    "id": 2,
    "user_id": 1,
    "country": "BR",
    "state": "SP",
    "city": "Campinas",
    "street": "Rua Anhanguera",
    "complement": ""
  }
  ```

## Exemplos de Uso
### Requisição com `curl`:
```sh
curl -X GET "https://seu-dominio.com/api/users" -H "Authorization: Bearer seuTokenJWT"
```

<h5>Requisição com Postman:</h5>
<u1> 
<li>1. Selecione o método HTTP e insira a URL.</li>
<li>2. Vá para a aba "Headers" e adicione:<br>
   ```
   Key: Authorization
   Value: Bearer seuTokenJWT
   ```</li>
<li>3. Clique em "Send".</li>
</u1>
<h5>Ferramentas Recomendadas</h5>
- <b>Postman</b>: Para testar os endpoints e interagir com o backend.

<h5> Histórico de Versões</h5>
- <b>v1.0.0</b> - Lançamento inicial da API.

## Referências
- [Documentação do PHP](https://www.php.net/docs.php)
- [Documentação e teste de uso JWT](https://jwt.io)
- [Criação e documentação de API Swagger](https://editor.swagger.io)
- [Documentação para consulta de funções](https://www.php.net/manual/pt_BR/)
- [Documentação do MySQL](https://dev.mysql.com/doc/)
