<?php

declare(strict_types=1);

namespace app\controllers;

use app\database\DBConnection;
use app\helpers\Response;

class OrderController extends Controller
{
  protected DBConnection $connection;

  public function __construct()
  {
    $this->connection = new DBConnection();
  }

  public function index()
  {
    $orders = $this->getAll();

    // print_r($orders); die;

    return $this->view("orders/index", ["orders" => $orders]);
  }

  public function newOrder()
  {
    $query = "SELECT * FROM products ORDER BY created_at DESC";
    $statement = $this->connection->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll(DBConnection::FETCH_ASSOC);

    return $this->view("orders/store", ["products" => $products]);
  }

  public function getAll(): array
  {
    $query = "SELECT * FROM orders ORDER BY created_at DESC";
    $statement = $this->connection->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll(DBConnection::FETCH_ASSOC);

    $data = [];

    foreach ($orders as $order) {
      $order["products"] = [];

      $query = "SELECT * FROM order_products WHERE order_id = ?";
      $statement = $this->connection->prepare($query);
      $statement->execute([$order["id"]]);
      $orderProducts = $statement->fetchAll(DBConnection::FETCH_ASSOC);

      foreach ($orderProducts as $orderProduct) {
        $query = "SELECT DISTINCT url FROM product_images WHERE product_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->execute([$orderProduct["product_id"]]);
        $productImages = $statement->fetchAll(DBConnection::FETCH_ASSOC);

        $orderProduct["images"] = $productImages;
        // array_push($orderProduct["images"], $productImages);

        array_push($order["products"], $orderProduct);
      }

      array_push($data, $order);
    }

    return $data;
  }

  public function store(object $params): object
  {
    try {
      foreach (["products", "quantity"] as $param) {
        if (!$params->$param) {
          throw new \Exception("Parametro `$param` e obrigatorio e deve ser enviado!");
        }
      }

      $products = explode(",", htmlspecialchars($params->products, ENT_QUOTES));
      $quantity = filter_var($params->quantity, FILTER_SANITIZE_NUMBER_INT);

      $query = "INSERT INTO orders SET created_at = NOW()";
      $statement = $this->connection->prepare($query);
      $result = $statement->execute();

      if (!$result) {
        throw new \Exception("Erro ao inserir pedido no banco de dados!");
      }

      $orderId = $this->connection->lastInsertId();

      foreach ($products as $product[0]) {
        $query = "INSERT INTO order_products SET product_id = ?, order_id = ?, quantity = ?";
        $statement = $this->connection->prepare($query);
        $result = $statement->execute([$product[0], $orderId, $quantity]);

        if (!$result) {
          throw new \Exception("Erro ao inserir produtos do pedido no banco de dados!");
        }
      }

      return new Response("Produto adicionado com sucesso!", 201);

    } catch(\Throwable $th) {
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

      $query = "DELETE FROM orders WHERE id = ?";
      $statement = $this->connection->prepare($query);
      $result = $statement->execute([$id]);

      if (!$result) {
        throw new \Exception("Erro ao deletar pedido no banco de dados!");
      }

      return new Response("Pedido deletado com sucesso!", 200);

    } catch(\Throwable $th) {
      echo $th->getMessage();
    }
  }

}