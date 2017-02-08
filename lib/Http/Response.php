<?php

namespace Lib\Http;

interface Response {
  public function getStatusCode();

  public function getBody();

  public function render();
}
