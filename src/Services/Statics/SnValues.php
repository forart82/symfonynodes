<?php

/**
 * @file
 * Contains a class to create a unique string base sur une timestamp
 */

namespace App\Services\Statics;

class SnValues
{
  const SNVALUES = [
    'Types' => [
      'method' => 'getTypes',
      'class' => 'App\\Entity\\Types',
      'name' => 'Types',
      'type' => 'type',
      'json' => 'Types',
    ],
    'Motifs' => [
      'method' => 'getMotifs',
      'class' => 'App\\Entity\\Motifs',
      'name' => 'Motifs',
      'type' => 'motif',
      'json' => 'Motifs',
    ],
    'Texts' => [
      'method' => 'getTexts',
      'class' => 'App\\Entity\\Texts',
      'name' => 'Texts',
      'type' => 'content',
      'json'=>'Texts',
    ],
    'Strings' => [
      'method' => 'getStrings',
      'class' => 'App\\Entity\\Strings',
      'name' => 'Strings',
      'type' => 'content',
      'json'=>'Strings',
    ],
    'Images' => [
      'method' => 'getImages',
      'class' => 'App\\Entity\\Images',
      'name' => 'Images',
      'type' => 'content',
      'json'=>'Images',
    ],
  ];
}
