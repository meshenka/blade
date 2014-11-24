<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>

<div id="page">

  <header class="header container-fluid" id="header" role="banner">

    <div class="row">

      <?php if ($logo): ?>
        <div class="col-md-2">
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo logo" id="logo">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="logo-link active header__logo-image" />
          </a>
        </div>
      <?php endif; ?>
      <?php if ($logo): ?>
        <div class="col-md-8">
            <?php print render($page['header']['menu_block_1']); ?>
        </div>
        <div class="col-md-2">
            <?php print render($page['header']['search_form']); ?>
        </div>
      <?php else: ?>
        <div class="col-md-12">
            <?php print render($page['header']); ?>
        </div>
      <?php endif; ?>

    </div>
  </header>

  <div id="main">

    <div id="content" class="column" role="main">

      <?php
        // pas de breadcrumb sur la home
        if (! $is_front) {
            print $breadcrumb;
        }?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php // print $feed_icons; ?>
    </div>

    <div id="navigation">
      <?php print render($page['navigation']); ?>
    </div>

    <?php if ($sidebar_first = render($page['sidebar_first'])): ?>
      <aside class="sidebars">
        <?php print $sidebar_first; ?>
      </aside>
    <?php endif; ?>

  </div>

  <?php print render($page['footer']); ?>

</div>

<?php print render($page['bottom']); ?>
