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

  public static function old($key) {
    if($_SESSION['formData'][$key] ?? null) {
      $val = $_SESSION['formData'][$key];
      return $val;
    }
    return "";
  }

  public static function setFormData($data) {
    $_SESSION['formData'] = $data;
  }
}