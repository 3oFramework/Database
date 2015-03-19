<?php return array (
  'post' => 
  array (
    'title' => 
    array (
      'type' => 'string',
    ),
    'body' => 
    array (
      'type' => 'text',
    ),
    'published' => 
    array (
      'type' => 'bool',
    ),
  ),
  'user' => 
  array (
    'email' => 
    array (
      'type' => 'string',
      'validate' => 'email',
    ),
    'password' => 
    array (
      'type' => 'hash',
    ),
  ),
);