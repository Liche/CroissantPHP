<?php

namespace Lib\Http\Response;

use Lib\Http\StatusCodes;

class JsonResponse extends BaseResponse {
  public function render() {
    $this->headers['Content-Type'] = 'application/json';

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
