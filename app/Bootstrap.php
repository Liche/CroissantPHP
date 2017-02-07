<?php

require_once "Front.php";
require_once "Config.php";

class Bootstrap {
  public function boot() {
    $front = new Front();
    $front->run();

  }
}
