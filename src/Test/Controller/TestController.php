<?php

namespace Test\Controller;

use Lib\Http\Response\ViewResponse;

class TestController {
  public function testAction() {
    return new ViewResponse("Test/test.php", ['test_value' => 'Works !']);
  }
}
