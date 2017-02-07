<?php

namespace Lib\Http;

class JsonResponse extends Response {
  public function render() {
    foreach($this->headers as $type => $value) {
      header(sprintf("%s: %s", $type, $value));
    }

    header(sprintf(
      "HTTP/1.0 %d %s",
      $this->statusCode,
      StatusCodes::STATUS_CODES[$this->statusCode]
    ));

    print json_encode($this->body, true);
  }
}
