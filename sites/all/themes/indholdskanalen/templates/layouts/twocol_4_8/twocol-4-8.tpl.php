  <?php if ($content['left']) { ?>
    <div class="grid-4 alpha panel-col-left <?php if (!$content['right']) { ?>suffix-8 omega<?php } ?>">
      <?php print $content['left']; ?>
    </div>
  <?php } ?>
  
  <?php if ($content['right']) { ?>
  <div class="<?php if (!$content['left']) { ?>prefix-4 alpha <?php } ?> grid-8 omega panel-col-right">
    <?php print $content['right']; ?>
  </div>
  <?php } ?>