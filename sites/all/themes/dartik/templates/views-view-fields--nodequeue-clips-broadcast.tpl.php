<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<?php if (is_null($fields['field_clip_custom']->content)): ?>
  <div class="clip_entry">
    <?php print $fields['position']->content; ?>. <a href="<?php echo $fields['field_clip_url']->content; ?>" target="_blank"><?php print $fields['field_clip_primary']->content; ?></a> (<?php print $fields['field_broadcast_format']->content; ?>), <?php print $fields['field_broadcast_date']->content; ?>: <?php print $fields['field_clip_scholar']->content; ?> discusses <?php print $fields['field_clip_subject']->content; ?> <?php if (isset($fields['field_clip_program'])) { ?> on <em><?php print $fields['field_clip_program']->content;?></em> <?php } ?><br><br>
</div>
<?php else: ?>
  <div class="clip_entry">
    <?php print $fields['position']->content; ?>. <?php print $fields['field_clip_primary']->content; ?> (<?php print $fields['field_broadcast_format']->content; ?>), <?php print $fields['field_broadcast_date']->content; ?>: <?php print $fields['field_clip_custom']->content; ?><br><br>
  </div>

<?php endif; ?>
