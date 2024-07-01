<div style="margin: 0 auto"><h1 style="text-align:center">API Rest PHP - Liven</h1></center></div>

<p><b>API desenvolvida em PHP com funcionalidades CRUD e autenticação JWT.</b></p>
<h3>Tecnologias</h3>
<ul>
   <li><b>PHP: O PHP compõe 100% da linguagem de programação da API. Responsável pela interação com o banco de dados, manipulação e exibição dos dados retornados conforme as requisições dos enpoints.</b></li>
   <li><b>JWT:</B> Uso do JSon Web Token para autenticação e permissões a nível de usuário. Utilizamos a bilbioteca JWT Firebase do PHP.</li>
   <li><b>MySQL:</B> Banco de dados relacional utilizado para armazenar os dados do projeto.</li>
   
</ul>
<h3>Introdução</h3>
API desenvolvida para fornecer um conjunto robusto de funcionalidades para gerenciamento de usuários e endereços. Essa API utiliza autenticação JWT para garantir a segurança das operações e gerenciar os níveis de permissão do usuário para com relação às informações pertinentes a ele.

<h3>Pré-requisitos</h3>
Para o funcionamento correto, certifique-se de ter os seguintes requisitos sejam atendidos:<br>
<ul>
<li><b>PHP 8.0+</b></li>
<li><b>MySQL 5.7+</b></li>
<li><b>Composer na última versão</b> (para gerenciamento de dependências)</li>
<li>Servidor web (Apache, Nginx, etc.) - para finalidade de testes locais utilizamos o xampp.</li>
</ul>

<h3>Instalação</h3>
<ul>
<li>1. Clone o repositório:

   git clone  (https://github.com/FernandoAndrade326/liven-backend)

   </li>
<li>2. Navegue até o diretório do projeto:

   cd nome-do-repositorio
   </li>
<li>3. Instale as dependências:

   composer install
   
   </li>
</ul>
<h3> Autenticação</h3>
A API utiliza JWT para autenticação. Para acessar os endpoints protegidos, você precisará incluir um token JWT no cabeçalho das suas requisições. <br>
**Toda a documentação com detalhes da API se encontra no arquivo "api-swagger.yaml".
<h4> Métodos Suportados: </h4>
 <ul>
    <li>POST</li>
    <li>GET</li>
    <li>PUT</li>
    <li>DEL</li>
 </ul>
- <b>Obter Token JWT:</b>
  - Endpoint: `POST /authServices`<br>
  - Corpo da requisição (JSON):<br>
  
 ```json
    {
      "username": "RenataLiven",
      "password": "123"
    }
 ```
    <br>
  - Resposta (JSON):<br>
  
    ```json
    {
      "access_token": "tokenJWTformatado"
    }
    ```

<h3> Endpoints da API</h3>

<h5> Usuários </h5>

<h5> `GET /users`</h5>
- <b>Descrição:</b> Retorna uma lista de todos os usuários.<br>
- <b>Parâmetros de consulta:</b> Nenhum.<br>
- <b>Exemplo de resposta (JSON):</b><br>
 
   ```json
    {
      "id": 1,
      "name": "RenataLiven",
      "email": "renata@liven.tech"
    }
   ```

<h5> `GET /users/{id}`</h5>
- <b>Descrição:</b> Retorna os detalhes de um usuário específico.<br>
- <b>Parâmetros de caminho:</b><br>
  - `id` (inteiro): ID do usuário.<br>
- <b>Exemplo de resposta (JSON):</b><br>

  ```json
    {
      "id": 1,
    "name": "RenataLiven",
    "email": "renata@liven.tech"
    }
   ```

<h5> `POST /users` </h5>
- <b>Descrição:</b> Cria um novo usuário.<br>
- <b>Corpo da requisição (JSON):</b><br>

  ```json
  {
    "username": "Fernando Andrade",
    "email": "fernandoteste@gmail.com",
    "password": "123"
  }
   ```
- <b>Exemplo de resposta (JSON):</b>

  ```json
  {
    "message": "Cadastro realizado com sucesso!",
    "0": {
        "id": null,
        "username": "FernandoTesteLiven",
        "password": "123",
        "email": "testeliven@gmail.com",
        "created_at": "2024-06-30 19:01:40",
        "updated_at": "2024-06-30 19:01:40",
        "is_active": 1
    }
  }
  ```

</h4>Endereços</h4>

<h5> `GET /api/addresses`</h5>
- <b>Descrição:</b> Retorna uma lista de todos os endereços.<br>
- <b>Parâmetros de consulta:</b> Nenhum.<br>
- <b>Exemplo de resposta (JSON):</b><br>

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
  ]
  ```

<h5> `GET /api/addresses/{id}`</h5>
- <b>Descrição:</b> Retorna os detalhes de um endereço específico.<br>
- <b>Parâmetros de caminho:</b> <br>
  - `id` (inteiro): ID do endereço.
- <b>Exemplo de resposta (JSON):</b><br>

  ```json
  {
    "id": 15,
    "user_id": 11,
    "street": "Rua Teste Liven",
    "number": "11111",
    "complement": null,
    "neighborhood": "Centro",
    "city": "Campinas",
    "state": "SP",
    "zip_code": "13840000",
    "country": "UK"
}
  ```

<h5>`POST /api/addresses` </h5>
- <b>Descrição:</b> Cria um novo endereço.<br>
- <b>Corpo da requisição (JSON):</b><br>

  ```json
  {
        "street": "Rua Teste da UK",
        "number": "9696",
        "complement": null,
        "neighborhood": "Centro",
        "city": "Campinas",
        "state": "SP",
        "zip_code": "13840000",
        "country": "BR"
    }
  ```
- <b>Exemplo de resposta (JSON):</b><br>
  ```json
  {
    "message": "Endereço inserido com sucesso!",
    "data": {
        "id": null,
        "user_id": 77,
        "street": "Rua Teste da UK",
        "number": "9696",
        "complement": null,
        "neighborhood": "Centro",
        "city": "Campinas",
        "state": "SP",
        "zip_code": "13840000",
        "country": "BR"
    }
}```
*Lembrando que estes são apenas alguns dos endpoints do sistema. Verifique toda a documentação no arquivo "api-swagger.yaml" na raiz do projeto.

<h4> Exemplos de Uso</h4>
<h5>Requisição com Postman:</h5>
<u1> 
<li>1. Selecione o método HTTP e insira a URL.</li>
<li>2. Inicie pelo endpoint de cadastro de usuário.</li>
<li>3. Em seguida, faça login no endpoint respectivo, e recupere os dados do token.</li>
<li>4. Com token já gerado pelo endpoint de login, vá para a aba "Headers", em todos os demais endpoints e adicione:<br>
   
   ```
   Key: Authorization
   Value: Bearer seuTokenJWT
   ```
</li>
<li>5. Clique em "Send".</li>
</u1>
<h5>Ferramentas Recomendadas</h5>
- <b>Postman</b>: Para testar os endpoints e interagir com o backend.

<h5> Testes automatizados</h5>
- <b>Na pasta "tests" encontram-se os arquivos para testes automatizados, que cobrem cada um dos endpoints listados. Lembre-se de que os dados nele contidos são "mockados".

<h5> Histórico de Versões</h5>
- <b>v1.0.0</b> - Lançamento inicial da API.

## Referências
- [Documentação do PHP](https://www.php.net/docs.php)
- [Documentação e teste de uso JWT](https://jwt.io)
- [Criação e documentação de API Swagger](https://editor.swagger.io)
- [Documentação para consulta de funções](https://www.php.net/manual/pt_BR/)
- [Documentação do MySQL](https://dev.mysql.com/doc/)
