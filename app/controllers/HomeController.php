<?php

declare(strict_types=1);

namespace app\controllers;

class HomeController extends Controller
{
  public function index()
  {
    return $this->view("home");
  }
}