<?php

/**
 * Implements hook_preprocess_field().
 */
function cliptik_preprocess_field(&$vars) {
  $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#view_mode'];
  $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#field_name'] . '__' . $vars['element']['#view_mode'];
  $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#field_name'] . '__' . $vars['element']['#bundle'] . '__' . $vars['element']['#view_mode'];
 }

/**
 * Implements hook_preprocess_node().
 */
function cliptik_preprocess_node(&$vars) {
  _cliptik_link_primary($vars);
}

/**
 * Wraps the primary outlet or source in a link to either the clip's link or
 * the taxonomy term page for the field
 *
 * @param $vars
 */
function _cliptik_link_primary(&$vars) {
  if ($vars['view_mode'] == 'daily_report') {
    switch ($vars['node']->type) {
      case 'broadcast_clip':
        $primary_field_name = 'field_primary_outlet';
        break;

      case 'print_clip':
        $primary_field_name = 'field_primary_source';
        break;
    }
    if (isset($primary_field_name)) {
      if ($primary_field = field_get_items('node', $vars['node'],
        $primary_field_name)) {
        $field_link = field_get_items('node', $vars['node'], 'field_link');
        if ($field_link){
          $url = url($field_link[0]['url'], array(
            'query' => $field_link[0]['query'],
            'fragment' => $field_link[0]['fragment'],
            'absolute' => TRUE,
          ));
        }
        else {
          $url = url('taxonomy/term/' . $primary_field[0]['tid'], array(
            'absolute' => TRUE,
          ));
        }
        $vars['content']['field_primary_outlet'][0]['#markup'] =
          l($vars['content']['field_primary_outlet'][0]['#markup'], $url, array(
            'html' => TRUE,
          ));
      }
    }
  }
}
