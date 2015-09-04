<?php

/**
 * Implements hook_preprocess_field().
 */
function cliptik_preprocess_field(&$vars) {
  if ($vars['element']['#field_name'] == 'field_scholar') {
    if ($vars['element']['#view_mode'] == 'daily_report' || $vars['element']['#view_mode'] == 'search_page' || $vars['element']['#view_mode'] == 'upcoming_appearances') {
      _cliptik_scholar_nicename($vars);
    }
  }
}

/**
 * Implements hook_preprocess_node().
 */
function cliptik_preprocess_node(&$vars) {
  if ($vars['node']->type == 'broadcast_clip' || $vars['node']->type == 'print_clip') {
    if ($vars['view_mode'] == 'daily_report' || $vars['view_mode'] == 'search_page' || $vars['view_mode'] == 'upcoming_appearances') {
      if ($vars['node']->type == 'broadcast_clip') {
        $primary_field_name = 'field_primary_outlet';
        _cliptik_broadcast_verb($vars);
      }
      else {
        $primary_field_name = 'field_primarysource';
        _cliptik_print_type_article($vars);
      }
      if ($vars['view_mode'] == 'daily_report') {
        _cliptik_link_primary($vars, $primary_field_name);
      }
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
  foreach ($vars['items'][0]['#items'] as $item) {
    $orig_scholar_text = explode(',', $item);
    if (count($orig_scholar_text) > 1) {
      $new_markup = trim($orig_scholar_text[1]).' '.trim ($orig_scholar_text[0]);
    }
    else {
      $new_markup = $item;
    }
    $new_items[]= $new_markup;
  }
  $vars['items'][0]['#items'] = $new_items;
}

/**
 * Determines what verb to use for broadcast clips in Daily Reports
 *
 * @param $vars
 */
function _cliptik_broadcast_verb(&$vars) {
  if ($broadcast_type = field_get_items('node', $vars['node'], 'field_broadcast_type')) {
    $vars['broadcast_verb'] = '';
    if (!field_get_items('node', $vars['node'], 'field_custom_desc')) {
      if ($scholars = field_get_items('node', $vars['node'], 'field_scholar')) {
        $count_authors = count($scholars);
        switch ($broadcast_type[0]['value']) {
          case 'Mention':
            $verb = 'mentioned regarding';
            break;
          case 'Event':
            $verb = 'covered';
            break;
          default:
            $verb = ($count_authors == 1) ? 'discusses' : 'discuss';
            break;
        }
        $vars['broadcast_verb'] = '&nbsp;' . $verb;
      }
    }
  }
}

/**
 * Prepends the proper grammatical article to the print type
 *
 * @param $vars
 */
function _cliptik_print_type_article(&$vars) {
  if (isset($vars['content']['field_type'])) {
    if (preg_match('/^[aeiou]|s\z/i', $vars['content']['field_type'][0]['#markup'])) {
      $gram_art = 'an';
    }
    else {
      $gram_art = 'a';
    }
    $use_in = 'in ';
    if ($nature_of_mention = field_get_items('node', $vars['node'], 'field_cite')) {
      if ($nature_of_mention[0]['value'] == 'Authored') {
        $use_in = '';
      }
    }
    $vars['content']['field_type'][0]['#markup'] = $use_in . $gram_art . ' ' .
      $vars['content']['field_type'][0]['#markup'];
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
        if ($primary_field_name == 'field_primarysource') {
          if ($files = field_get_items('node', $vars['node'], 'field_attached_files')) {
            $url = file_create_url($files[0]['uri']);
          }
        }
      }
      if (isset($url)) {
        $vars['content'][$primary_field_name][0]['#markup'] =
          l($vars['content'][$primary_field_name][0]['#markup'], $url, array(
            'html' => TRUE,
          ));
      }
    }
  }
}
