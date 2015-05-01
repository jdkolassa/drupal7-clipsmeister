<?php

/**
 * Implements hook_preprocess_field().
 */
function dartik_preprocess_field(&$vars) {
  if (isset($vars['ds-config']['func'])) {
    $suggestion = 'field__' . str_replace('theme_ds_field_', '', $vars['ds-config']['func']);
  }
  else {
    $suggestion = 'field';
  }
  $vars['theme_hook_suggestions'][] = $suggestion . '__' . $vars['element']['#field_name'] . '__' . $vars['element']['#bundle'] . '__' . $vars['element']['#view_mode'];
}
