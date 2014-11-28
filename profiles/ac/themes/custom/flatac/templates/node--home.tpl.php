<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
$imgPath =  image_style_url('background', $node->field_background[LANGUAGE_NONE][0]['uri']);
?>

<style>
#content {
  /* top, transparent black, faked with gradient */
    background: linear-gradient(
        rgba(0, 0, 0, 0.6),
        rgba(0, 0, 0, 0.6)
      ),
    url("<?php print $imgPath ?>");
  background-repeat: no-repeat;
  background-size: cover;
  display: block;
  background-position: top right;

}
</style>
<section class="node-<?php print $node->nid; ?> <?php print $classes; ?> jumbotron"<?php print $attributes; ?>>

  <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
    <header>
      <?php print render($title_prefix); ?>
      <?php print render($title_suffix); ?>

      <?php if ($display_submitted): ?>
        <p class="submitted">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </p>
      <?php endif; ?>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
    </header>
  <?php endif; ?>
  <div class="text-center">
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['field_background']);
      hide($content['links']);

      echo '<div class="h1">'.$title.'</div>';
      print render($content);
    ?>
  </div>
  <?php print render($content['links']); ?>
</section>
