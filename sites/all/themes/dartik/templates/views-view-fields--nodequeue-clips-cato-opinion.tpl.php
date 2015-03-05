<style>
   .clip_entry div, .field-content {
    display: inline;
   }
</style>


<?php if (is_null($fields['field_clip_custom']->content)): ?>
  <div class="clip_entry">
  <?php print $fields['position']->content; ?>. <a href="<?php echo $fields['field_clip_url']->content; ?>" target="_blank"><?php print $fields['field_clip_primary']->content; ?></a>, <?php print $fields['field_print_publication_date']->content; ?>: <?php print $fields['field_clip_scholar']->content; ?> authored a <?php print $fields['field_clip_type']->content; ?> on <?php print $fields['field_clip_subject']->content; ?>: "<?php print $fields['title']->content; ?>"<br><br>
</div>

<?php else: ?>
  <div class="clip_entry">
    <?php print $fields['position']->content; ?>. <?php print $fields['field_clip_primary']->content; ?>, <?php print $fields['field_print_publication_date']->content; ?>: <?php print $fields['field_clip_custom']->content; ?><br><br>
  </div>
<?php endif; ?>
