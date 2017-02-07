<?php

namespace Lib;

class Response {
  protected $statusCode;
  protected $body;
  protected $headers;

  public function __construct($body, $statusCode) {
    $this->headers = [];
    $this->body = $body;
    $this->statusCode = $statusCode;
  }

  public function setStatusCode($statusCode = 200) {
    $this->statusCode = $statusCode;
  }

  public function setHeaders(array $headers) {
    $this->headers = $headers;
  }

  public function setHeader($header, $value) {
    $this->headers[$header] = $value;
  }

  public function setBody($body) {
    $this->body = $body;
  }

  public function render() {
    foreach($this->headers as $type => $value) {
      header(sprintf("%s: %s", $type, $value));
    }

    header(sprintf(
      "HTTP/1.0 %d %s",
      $this->statusCode,
      StatusCodes::STATUS_CODES[$this->statusCode]
    ));

    print $this->body;
  }
}
