<?php

declare(strict_types=1);

namespace app\routes;

use app\helpers\Request;
use app\helpers\Uri;

class Router
{
  const CONTROLLER_NAMESPACE = "app\\controllers";

  public static function load(string $controller, string $method)
  {
    try {
      $controllerNamespace = self::CONTROLLER_NAMESPACE."\\".$controller;

      if (!class_exists($controllerNamespace)) {
        throw new \Exception("The controller {$controller} not exists!");
      }

      $controllerInstance = new $controllerNamespace();

      if (!method_exists($controllerInstance, $method)) {
        throw new \Exception("The method {$method} not exists!");
      }

      $controllerInstance->$method((object) $_REQUEST);
    } catch (\Throwable $th) {
      echo $th->getMessage();
    }
  }

  public static function routes(): array
  {
    return [
      "GET" => [
        "/" => fn() => self::load("HomeController", "index"),
        "/produtos" => fn() => self::load("ProductController", "index"),
        "/produtos/novo" => fn() => self::load("ProductController", "newProduct"),
        "/produtos/editar" => fn() => self::load("ProductController", "updateProduct"),
        "/pedidos" => fn() => self::load("OrderController", "index"),
        "/pedidos/novo" => fn() => self::load("OrderController", "newOrder"),
      ],
      "POST" => [
        "/api/products/store" => fn() => self::load("ProductController", "store"),
        "/api/products/update" => fn() => self::load("ProductController", "update"),
        "/api/orders/store" => fn() => self::load("OrderController", "store"),
      ],
      "DELETE" => [
        "/api/products/destroy" => fn() => self::load("ProductController", "destroy"),
        "/api/orders/destroy" => fn() => self::load("OrderController", "destroy"),
      ],
    ];
  }

  public static function execute()
  {
    try {
      $routes = self::routes();
      $request = Request::get();
      $uri = Uri::get("path");

      if (!isset($routes[$request])) {
        throw new \Exception("Route {$request} not exists!");
      }

      $route = $routes[$request][$uri];

      if (!is_callable($route)) {
        throw new \Exception("A página procurada não existe ou está indisponível.");
      }

      $route();

    } catch (\Throwable $th) {
      echo $th->getMessage();
    }
  }
}