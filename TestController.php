<?php

namespace Test\Controller;

use Lib\Http\ViewResponse;

class TestController {
  public function testAction() {
    return new ViewResponse("Test/test.php", ['test_value' => 'Works !']);
  }
}
