<?php

/**
* Implements hook_preprocess_node().
*/

function dartik_preprocess_node(&$vars) {
  if ($vars['node']->type == 'broadcast_clip' && $vars['view_mode'] == 'daily_report') {
    $vars['theme_hook_suggestions'][] = 'node__broadcast_clip__daily_report';
  };
  if ($vars['node']->type == 'print_clip' && $vars['view_mode'] == 'daily_report') {
    $vars['theme_hook_suggestions'][] = 'node__print_clip__daily_report'; 
  };
}