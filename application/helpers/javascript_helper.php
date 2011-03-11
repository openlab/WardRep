<?php

defined('BASEPATH') OR exit;

function to_javascript($var) {
  switch (gettype($var)) {
    case 'boolean':
      return $var ? 'true' : 'false'; // Lowercase necessary!
    case 'integer':
    case 'double':
      return $var;
    case 'resource':
    case 'string':
      return '"' . str_replace(array("\r", "\n", "<", ">", "&"), 
                              array('\r', '\n', '\x3c', '\x3e', '\x26'), 
                              addslashes($var)) . '"';
    case 'array':
      // Arrays in JSON can't be associative. If the array is empty or if it
      // has sequential whole number keys starting with 0, it's not associative
      // so we can go ahead and convert it as an array.
      if (empty($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
        $output = array();
        foreach ($var as $v) {
          $output[] = to_javascript($v);
        }
        return '[ ' . implode(', ', $output) . ' ]';
      }
      // Otherwise, fall through to convert the array as an object.
    case 'object':
      $output = array();
      foreach ($var as $k => $v) {
        $output[] = to_javascript(strval($k)) . ': ' . to_javascript($v);
      }
      return '{ ' . implode(', ', $output) . ' }';
    default:
      return 'null';
  }
}
