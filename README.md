### 📝 crud-produto-e-pedido

### Requisitos:

- PHP 8.*;
- Composer;
- Banco de dados MySQL;

### Siga os passo para roda o projeto:

1. Clone o repositorio para sua maquina:

```bash
$ git clone https://github.com/vittorfigueiredo/crud-produto-e-pedido.git
```

2. Instale as dependencias com o comando:

```bash
$ composer install
```

3. Faca uma copia do arquivo .env.example, renomeie-a para .env e adiciona as configuracoes do seu banco de dados.

4. Execute o comando para iniciar o servidor embutido do php:

```bash
$ composer start
```

### Querys para a criacao das tabelas na base de dados:
Obs: Rode-as em sequencia!

```sql
CREATE TABLE
  products (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(255) NOT NULL,
    valor_venda DECIMAL(7, 2) NOT NULL,
    estoque INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

CREATE TABLE
  product_images (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id INT UNSIGNED,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

CREATE TABLE
  orders (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

CREATE TABLE
  order_products (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id INT UNSIGNED,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    order_id INT UNSIGNED,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    quantity VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );
```
