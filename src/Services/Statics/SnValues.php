<?php

/**
 * @file
 * Contains a class to create a unique string base sur une timestamp
 */

namespace App\Services\Statics;

class SnValues
{
  const SNVALUES = [
    'Texts' => [
      'method' => 'getTexts',
      'class' => 'App\\Entity\\Texts',
      'name' => 'Texts',
      'type' => 'content',
      'json'=>['Texts'],
    ],
    'Motifs' => [
      'method' => 'getMotifs',
      'class' => 'App\\Entity\\Motifs',
      'name' => 'Motifs',
      'type' => 'motif',
      'json'=>['Motifs'],
    ],
    'Strings' => [
      'method' => 'getStrings',
      'class' => 'App\\Entity\\Strings',
      'name' => 'Strings',
      'type' => 'content',
      'json'=>['Strings'],
    ],
    'Types' => [
      'method' => 'getTypes',
      'class' => 'App\\Entity\\Types',
      'name' => 'Types',
      'type' => 'type',
      'json'=>['Types'],
    ],
    'Images' => [
      'method' => 'getImages',
      'class' => 'App\\Entity\\Images',
      'name' => 'Images',
      'type' => 'content',
      'json'=>['Images'],
    ],
  ];
}
