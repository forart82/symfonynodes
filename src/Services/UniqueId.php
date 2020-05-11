<?php

/**
 * @file
 * Contains a class to create a unique string base sur une timestamp
 */

namespace App\Services;

class UniqueId
{
  public static function createId()
  {
    $uniqueId=microtime(true).uniqid();
    return $uniqueId;
  }
}