<?php

declare(strict_types=1);

namespace app\controllers;

use app\database\DBConnection;
use app\helpers\Response;

class ProductController extends Controller
{
  protected DBConnection $connection;

  public function __construct()
  {
    $this->connection = new DBConnection();
  }

  public function index()
  {
    $products = $this->getAll();

    return $this->view("products/index", ["products" => $products]);
  }

  public function newProduct()
  {
    return $this->view("products/store");
  }

  public function updateProduct(object $params)
  {
    $product = $this->getProductById(intval($params->id))[0];

    return $this->view("products/update", ["product" => $product]);
  }

  public function getAll(): array
  {
    $query = "SELECT * FROM products ORDER BY created_at DESC";
    $statement = $this->connection->prepare($query);
    $statement->execute();

    return $statement->fetchAll(DBConnection::FETCH_ASSOC);
  }

  public function getProductById(int $id): array
  {
    $query = "SELECT * FROM products WHERE id = ?";
    $statement = $this->connection->prepare($query);
    $statement->execute([$id]);
    $product = $statement->fetchAll(DBConnection::FETCH_ASSOC);

    if (!$product) {
      return [];
    }

    $query = "SELECT * FROM product_images WHERE product_id = ?";
    $statement = $this->connection->prepare($query);
    $statement->execute([$id]);
    $product_images = $statement->fetchAll(DBConnection::FETCH_ASSOC);

    if ($product_images) {
      $product[0]["images"] = $product_images;
    }

    return $product;
  }

  public function store(object $params): object
  {
    try {
      foreach (["value", "stock", "description", "image"] as $param) {
        if (!$params->$param) {
          throw new \Exception("Parametro `$param` e obrigatorio e deve ser enviado!");
        }
      }

      $value = filter_var($params->value, FILTER_SANITIZE_NUMBER_FLOAT);
      $stock = filter_var($params->stock, FILTER_SANITIZE_NUMBER_INT);
      $description = htmlspecialchars($params->description, ENT_QUOTES);

      $query = "INSERT INTO products SET descricao = ?, valor_venda = ?, estoque = ?";
      $statement = $this->connection->prepare($query);
      $result = $statement->execute([$description, $value, $stock]);

      if (!$result) {
        throw new \Exception("Erro ao inserir produto no banco de dados!");
      }

      $productId = $this->connection->lastInsertId();

      $filename = date("Ymdhis").".jpg";
      file_put_contents("./uploads/$filename", base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $params->image)));

      $query = "INSERT INTO product_images SET url = ?, product_id = ?";
      $statement = $this->connection->prepare($query);
      $result = $statement->execute([$filename, $productId]);

      if (!$result) {
        throw new \Exception("Erro ao inserir imagem no banco de dados!");
      }

      return new Response("Produto adicionado com sucesso!", 201);

    } catch(\Throwable $th) {
      echo $th->getMessage();
    }
  }

  public function update(object $params): object
  {
    try {
      foreach (["id", "value", "stock", "description"] as $param) {
        if (!$params->$param) {
          throw new \Exception("Parametro `$param` e obrigatorio e deve ser enviado!");
        }
      }

      $id = filter_var($params->id, FILTER_SANITIZE_NUMBER_INT);
      $value = doubleval(htmlspecialchars($params->value, ENT_QUOTES));
      $stock = filter_var($params->stock, FILTER_SANITIZE_NUMBER_INT);
      $description = htmlspecialchars($params->description, ENT_QUOTES);

      $query = "UPDATE products SET descricao = ?, valor_venda = ?, estoque = ? WHERE id = ?";
      $statement = $this->connection->prepare($query);
      $result = $statement->execute([$description, $value, $stock, $id]);

      if (!$result) {
        throw new \Exception("Erro ao atualizar produto no banco de dados!");
      }

      if ($params->image) {
        $filename = date("Ymdhis").".jpg";
        file_put_contents("./uploads/$filename", base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $params->image)));

        $query = "INSERT INTO product_images SET url = ?, product_id = ?";
        $statement = $this->connection->prepare($query);
        $result = $statement->execute([$filename, $id]);

        if (!$result) {
          throw new \Exception("Erro ao inserir imagem no banco de dados!");
        }
      }

      return new Response("Produto atualizado com sucesso!", 200);

    } catch (\Throwable $th) {
      echo $th->getMessage();
    }
  }

  public function destroy(object $params): object
  {
    try {
      if (!$params->id) {
        throw new \Exception("Parametro `id` e obrigatorio e deve ser enviado!");
      }

      $id = filter_var($params->id, FILTER_SANITIZE_NUMBER_INT);

      $query = "SELECT * FROM product_images WHERE product_id = ?";
      $statement = $this->connection->prepare($query);
      $statement->execute([$id]);
      $productImages = $statement->fetchAll(DBConnection::FETCH_ASSOC);

      foreach ($productImages as $image) {
        unlink("./uploads/".$image["url"]);
      }

      $query = "DELETE FROM products WHERE id = ?";
      $statement = $this->connection->prepare($query);
      $result = $statement->execute([$id]);

      if (!$result) {
        throw new \Exception("Erro ao inserir produto no banco de dados!");
      }

      return new Response("Produto deletado com sucesso!", 200);

    } catch(\Throwable $th) {
      echo $th->getMessage();
    }
  }

}
