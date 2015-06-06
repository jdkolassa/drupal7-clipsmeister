<?php

/**
 * Implements hook_preprocess_field().
 */
function cliptik_preprocess_field(&$vars) {
  $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#view_mode'];
  $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#field_name'] . '__' . $vars['element']['#view_mode'];
  $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#field_name'] . '__' . $vars['element']['#bundle'] . '__' . $vars['element']['#view_mode'];
  if ($vars['element']['#field_name'] == 'field_scholar') {
    if ($vars['element']['#view_mode'] == 'daily_report') {
      _cliptik_scholar_nicename($vars);
    }
  }
}

/**
 * Implements hook_preprocess_node().
 */
function cliptik_preprocess_node(&$vars) {
  if ($vars['node']->type == 'broadcast_clip' || $vars['node']->type == 'print_clip') {
    if ($vars['view_mode'] == 'daily_report') {
      if ($vars['node']->type == 'broadcast_clip') {
        $primary_field_name = 'field_primary_outlet';
        _cliptik_broadcast_verb($vars);
      }
      else {
        $primary_field_name = 'field_primary_source';
      }
      _cliptik_link_primary($vars, $primary_field_name);
    }
  }
}

/**
 * Formats scholar names as (First Name) (Last Name)
 *
 * @param $vars
 */
function _cliptik_scholar_nicename(&$vars) {
  $new_items = array();
  foreach ($vars['items'] as $item) {
    $orig_scholar_text = explode(',', $item['#markup']);
    $new_items[]['#markup'] = trim($orig_scholar_text[1]).' '.trim ($orig_scholar_text[0]);
  }
  $vars['items'] = $new_items;
}

/**
 * Determines what verb to use for broadcast clips in Daily Reports
 *
 * @param $vars
 */
function _cliptik_broadcast_verb(&$vars) {
  if ($broadcast_type = field_get_items('node', $vars['node'], 'field_broadcast_type')) {
    if (!field_get_items('node', $vars['node'], 'field_custom_desc')) {
      switch ($broadcast_type[0]['value']) {
        case 'Mention':
          $verb = 'mentioned regarding';
          break;
        case 'Event':
          $verb = 'covered';
          break;
        default:
          $verb = 'discusses';
          break;
      }
      $vars['broadcast_verb'] = '&nbsp;' . $verb;
    }
    else {
      $vars['broadcast_verb'] = '';
    }
  }
}

/**
 * Wraps the primary outlet or source in a link to either the clip's link or
 * the taxonomy term page for the field
 *
 * @param $vars
 */
function _cliptik_link_primary(&$vars, $primary_field_name) {
  if (isset($primary_field_name)) {
    if ($primary_field = field_get_items('node', $vars['node'],
      $primary_field_name)
    ) {
      $field_link = field_get_items('node', $vars['node'], 'field_link');
      if ($field_link) {
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
