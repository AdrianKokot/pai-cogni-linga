<?php

class Session {
  public static function setFlash($message) {
    $_SESSION['flash'] = $message;
  }

  public static function flash() {
    $message = $_SESSION['flash'] ?? "";
    $_SESSION['flash'] = null;
    unset($_SESSION['flash']);
    return $message;
  }
}