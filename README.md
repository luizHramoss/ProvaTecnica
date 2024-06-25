# Projeto CodeIgniter 4 com MySQL e JWT

Este é um projeto de exemplo utilizando CodeIgniter 4, MySQL como banco de dados e JWT para autenticação. Ele fornece uma API para gerenciar clientes, produtos e pedidos.

## Funcionalidades

- **Clientes**: CRUD de clientes com validação de CPF/CNPJ.
- **Produtos**: CRUD de produtos.
- **Pedidos**: CRUD de pedidos, incluindo itens de pedidos e cálculo automático do valor total.
- **Autenticação**: Utiliza JWT para autenticação.

## Pré-requisitos

- PHP 8.1 ou superior
- Composer
- MySQL

## Instalação

1. Entre na master
    ```
    git checkout master
    ```
2. Instale as dependências via Composer:
    ```
    composer install
    ```

3. Crie um arquivo `.env` a partir do arquivo de exemplo:
    ```
    cp env .env
    ```

4. Configure o arquivo `.env` com suas credenciais de banco de dados e JWT:
    ```env

    # app.baseURL = 'http://dev.api-prova-tecnica'

    #--------------------------------------------------------------------
    # DATABASE
    #--------------------------------------------------------------------

    database.default.hostname = localhost
    database.default.database = seu_banco_de_dados
    database.default.username = seu_usuario
    database.default.password = sua_senha
    database.default.DBDriver = MySQLi
    database.default.DBPrefix =
    database.default.port = 3306

    #--------------------------------------------------------------------
    # JWT Configuration
    #--------------------------------------------------------------------

    JWT_SECRET = "sua_secret_key"
    ```

5. Execute as migrações para criar as tabelas no banco de dados:
    ```
    php spark migrate
    ```

6. Inicie o servidor de desenvolvimento:
    ```
    php spark serve
    ```

## Uso

### Endpoints da API

- **Clientes**
  - `GET /api/clientes`: Retorna a lista de clientes.
  - `GET /api/clientes/{id}`: Retorna os detalhes de um cliente específico.
  - `POST /api/clientes`: Cria um novo cliente.
  - `PUT /api/clientes/{id}`: Atualiza os dados de um cliente.
  - `DELETE /api/clientes/{id}`: Deleta um cliente.

- **Produtos**
  - `GET /api/produtos`: Retorna a lista de produtos.
  - `GET /api/produtos/{id}`: Retorna os detalhes de um produto específico.
  - `POST /api/produtos`: Cria um novo produto.
  - `PUT /api/produtos/{id}`: Atualiza os dados de um produto.
  - `DELETE /api/produtos/{id}`: Deleta um produto.

- **Pedidos**
  - `GET /api/pedidos`: Retorna a lista de pedidos.
  - `GET /api/pedidos/{id}`: Retorna os detalhes de um pedido específico.
  - `POST /api/pedidos`: Cria um novo pedido.
  - `PUT /api/pedidos/{id}`: Atualiza os dados de um pedido.
  - `DELETE /api/pedidos/{id}`: Deleta um pedido.

### Autenticação

Para autenticação, use o endpoint de login para obter um token JWT:
  - `POST /api/login`: Autentica um usuário e retorna um token JWT.

Exemplo de corpo de requisição para login:
```json
{
    "cpf_cnpj": "12345678901",
    "password": "sua_senha"
}
```
Use o token JWT recebido para autenticar as requisições subsequentes, adicionando o cabeçalho Authorization: Bearer {seu_token}.

Usuário Admin
Para facilitar o acesso à API, você pode usar o seguinte usuário admin:
```json
{
    "cpf_cnpj": "12345678901",
    "password": "Admin@123"
}

Certifique-se de que este usuário admin esteja criado no banco de dados com a senha apropriada.
```

Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir uma issue ou enviar um pull request.

Licença
Este projeto está licenciado sob a MIT License.