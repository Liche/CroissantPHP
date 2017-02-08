<?php

namespace Lib\Http;

final class Verb {
  const GET = 'GET';
  const POST = 'POST';
  const PATCH = 'PATCH';
  const PUT = 'PUT';
  const DELETE = 'DELETE';

  private function __construct() {}

  public static function getVerb() {
    global $_SERVER;

    return $_SERVER['REQUEST_METHOD'];
  }
}
