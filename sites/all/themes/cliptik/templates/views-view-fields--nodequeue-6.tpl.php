<style>
   .clip_entry div, .field-content {
    display: inline;
   }
</style>


<?php if (is_null($fields['field_custom_desc']->content)): ?>
  <div class="clip_entry">
  <?php print $fields['position']->content; ?>. <?php print $fields['field_primarysource']->content; ?></a>, <?php print $fields['field_publication_date']->content; ?>: <?php print $fields['field_scholar']->content; ?> authored a <?php print $fields['field_type']->content; ?> on <?php print $fields['field_subjects']->content; ?>: "<?php print $fields['field_headline']->content; ?>"<br><br>
</div>

<?php else: ?>
  <div class="clip_entry">
    <?php print $fields['position']->content; ?>. <?php print $fields['field_primarysource']->content; ?>, <?php print $fields['field_publication_date']->content; ?>: <?php print $fields['field_custom_desc']->content; ?><br><br>
  </div>
<?php endif; ?>
