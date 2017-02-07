<?php

namespace Test\Controller;

use Lib\Response;

class TestController {
  public function testAction() {
    return new Response("test");
  }
}
