<?php

declare(strict_types=1);

namespace app\helpers;

class Response
{

  private string $body;
  private int $code;

  public function __construct(string $body, int $code)
  {
    $this->body = $body;
    $this->code = $code;

    echo json_encode([
      "success" => [
        "message" => $this->body ?? [],
        "code" => $this->code,
      ]
    ], http_response_code($code));

    return;
  }
}
