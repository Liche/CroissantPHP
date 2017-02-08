<?php

namespace Lib\Http\Response;

class ViewResponse extends BaseResponse {
  protected $parameters;

  public function __construct($viewFile, $parameters) {
    $this->body = $viewFile;
    $this->parameters = $parameters;
  }

  public function setParameters($parameters) {
    $this->parameters = $parameters;
  }

  public function render() {
    foreach ($this->parameters as $name => $value) {
      $$name = $value;
    }

    ob_start();
    include(__DIR__ . '/../../views/' . $this->body);
    print ob_get_clean();
  }
}
