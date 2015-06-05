<?php

/**
 * Implements hook_preprocess_field().
 */
function cliptik_preprocess_field(&$vars) {
  if (isset($vars['ds-config']['func'])) {
    $suggestion = 'field__' . str_replace('theme_ds_field_', '', $vars['ds-config']['func']);
  }
  else {
    $suggestion = 'field';
  }
  $vars['theme_hook_suggestions'][] = $suggestion . '__' . $vars['element']['#field_name'] . '__' . $vars['element']['#bundle'] . '__' . $vars['element']['#view_mode'];
 }

/**
 * Implements hook_preprocess_node().
 */

/* function cliptik_preprocess_node(&$vars) {
  $node = $vars['node'];
  $view_mode = $vars['view_mode'];
  if ($view_mode == 'daily_report') {
    $field_attached_files = field_get_items('node', $vars['node'], 'field_attached_files');
    $field_link = field_get_items('node', $vars['node'], 'field_link');
    $field_primary = field_get_items('node', $vars['node'], 'field_primarysource');
    if ($field_link){
    	$field_primary['und'][0]['#prefix'] = '<a href="$field_link">';
    	$field_primary['und'][0]['#suffix'] = '</a>';
    }
  }
} */